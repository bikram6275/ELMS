@extends('backend.layouts.app')
@section('title')
    Survey Form
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Survey Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ url('orgs/dashboard') }}">{{ trans('app.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item active">{{ trans('app.survey') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('backend.message.flash')
            <div class="card card-default bg-light">
                <div class="card-body ">
                    {!! Form::open(['method' => 'post', 'url' => '/emitters/answer', 'autocomplete' => 'off', 'role' => 'form', 'id' => 'question_form']) !!}
                    {!! Form::hidden('pivot_id', $pivot_id, ['class' => 'form-control ']) !!}
                    <div class="row">
                        <div class="col-md-12" id="register">
                            <h1>Survey Form</h1>
                        </div>
                        @php
                            $qsn_id = Request::segment(6);
                        @endphp
                        <div class="all-steps" id="all-steps">
                            <a class="step step1 {{ $first_page == true ? 'active' : '' }}"
                                href="{{ url('emitters/survey/orgs/' . $pivot_id) }}">1</a>
                            @foreach ($questions as $key => $qsn)
                                <a class="step {{ isset($qsn->is_answer) && $qsn->is_answer ? 'visited' : '' }} {{ $qsn_id == $qsn->id ? 'active' : '' }} "
                                    href="{{ url('emitters/survey/orgs/question/' . $pivot_id . '/' . $qsn->id) }}"
                                    id={{ $qsn->qsn_number }}>{{ $qsn->qsn_number }}</a>
                            @endforeach
                        </div>
                        @if ($first_page == true)
                            <div class="card mx-auto col-md-10  mt-3">
                                <div class="card-body">
                                    <div class="col-md-12 ">
                                        <p class="title-size">
                                            <strong>1. General Information of Enterprises</strong>
                                        </p>
                                    </div>
                                    <div class="col-md-12" style="text-align: left">
                                        <table class="table table-border table-striped table-hover">
                                            <tr>
                                                <th> a. Name of Enterprise</th>
                                                <td>{{ $org_details->org_name }}</td>
                                            </tr>
                                            <tr>
                                                <th> b. Economic Sector: </th>
                                                <td>{{ $org_details->sector->sector_name }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12 mx-1" style="text-align: left">
                                        <p><strong>e. Address:</strong></p>
                                        <table class="table table-border table-striped table-hover ml-3">
                                            <tr>
                                                <th>Province</th>
                                                <td>{{ $org_details->pradesh->pradesh_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>District</th>
                                                <td>{{ $org_details->district->english_name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Local Level</th>
                                                <td>{{ $org_details->municipality ? $org_details->municipality->muni_name : null }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th> Ward No</th>
                                                <td> {{ $org_details->ward_no }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-12" style="text-align: left">
                                        <table class="table table-border table-striped table-hover">
                                        </table>
                                    </div>
                                </div>
                        @endif
                        @if ($first_page == false)
                            <div
                                class="card mx-auto  mt-3 {{ $recent_questions['qsn_number'] == '18' || $recent_questions['qsn_number'] == '6.b' || $recent_questions['qsn_number'] == '6.a' || $recent_questions['qsn_number'] == '5' ? 'col-md-12' : 'col-md-10' }}">
                                <div class="card-body">
                                    @include('emitter.answer.question')
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
                <!-- /.form group -->
                @if ($first_page == false)
                    <div class="card-footer mt-4 ">
                        <div class="col-md-12">
                            <?php
                            $qsn_order = App\Http\Controllers\Emitter\AnswerController::getQsnList($qsn_id);
                            if ($qsn_id == '14' || $qsn_id == '7' || $qsn_id == '38' || $qsn_id == '8') {
                                $previous_id = App\Http\Controllers\Emitter\AnswerController::checkMembershipPrevious($pivot_id, $qsn_id);
                            } elseif ($qsn_id == '17' || $qsn_id == '42' || ($qsn_id = '41')) {
                                $previous_id = App\Http\Controllers\Emitter\AnswerController::checkQuestion5Previous($pivot_id, $qsn_id);
                            } else {
                                $previous_id = $qsn_order->prev_qst_id;
                            }
                            // dd($previous_id);
                            $next = $qsn_order->next_qst_id;
                            ?>
                            <button type="submit"
                                class="btn  pull-right mx-3 {{ $next == 0 ? 'btn-danger' : 'btn-success' }}"
                                id="submitBtn">{{ $next == 0 ? 'Submit' : 'Next' }}
                            </button>
                            <a href="{{ url('emitters/survey/orgs/question/' . $pivot_id . '/' . $previous_id) }}"
                                class="btn btn-primary pull-right mx-3">Previous </a>
                        </div>
                    </div>
                @else
                    <div class="card-footer mt-4">
                        <div class="col-md-12">
                            <a href="{{ url('emitters/survey/orgs/question/' . $pivot_id . '/' . '1') }}"
                                class="btn btn-primary pull-right mx-3">Start </a>
                        </div>
                    </div>
                @endif
                {!! Form::close() !!}
            </div>

    </div>
    <!-- /.card-body -->
    </div>

    </section>
    <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
@endsection
