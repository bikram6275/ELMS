@extends('backend.layouts.app')
@section('title')
    Assigned Organization
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assigned Organization</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a
                                    href="{{ url('/emitters/dashboard') }}">{{ trans('app.dashboard') }}</a></li>
                            <li class="breadcrumb-item active">Assigned Organization</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title">Survey Status</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <span class="button square closer"></span>
                                            <div class="info-box-content">
                                                <h5>Assigned Survey</h5>
                                                <h2 class="font-weight-bold">{{ $assignedCount }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <span class="button square closer"></span>
                                            <div class="info-box-content">
                                                <h5>Approved Survey</h5>
                                                <h2 class="font-weight-bold">{{ $approvedCount }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box">
                                            <span class="button square closer"></span>
                                            <div class="info-box-content">
                                                <h5>Feedback Provided</h5>
                                                <h2 class="font-weight-bold">{{ $feedbackCount }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title">Assigned Organization</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12 topFilter">
                                    <table id="example1"
                                        class="table table-striped table-bordered table-hover table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px;">{{ trans('app.sn') }}</th>
                                                <th>Assigned Organization</th>
                                                <th>Start Date</th>
                                                <th>Finish Date</th>
                                                <th>Status</th>

                                                <th style="width: 100px !important" ; class="text-right">Action</th>
                                            </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1; ?>
                                            @foreach ($assignSurvey as $key => $data)
                                                <tr>
                                                    <td scope=row>{{ $i }}</td>
                                                    <td>{{ $data->org_name }}</td>
                                                    <td>{{ $data->start_date }}</td>
                                                    <td>{{ $data->finish_date }}</td>
                                                    <td>
                                                        <span
                                                            class="badge {{ $data->finish_date != null ? 'badge-danger' : 'badge-primary' }}">{{ $data->finish_date != null ? 'Complete' : ($data->start_date != null ? 'Started' : null) }}</span>
                                                        <span
                                                            class="badge {{ $data->status == 'unsupervised' ? 'badge-danger' : ($data->status == 'feedback' ? 'badge-warning' : 'badge-success') }}">{{ $data->status }}</span>

                                                    </td>
                                                    <td>
                                                        @if ($data->status != 'supervised')
                                                            @if ($data->respondent_name != null)
                                                                <a href="{{ url('emitters/survey/orgs/' . $data->pivot_id) }}"
                                                                    class="btn btn-xs btn-primary"><strong> Survey
                                                                        Start</strong> </a>
                                                            @else
                                                                <button class="btn btn-primary btn-xs" data-toggle="modal"
                                                                    data-target="#respondent_{{ $data->pivot_id }}"><strong>
                                                                        Survey Start</strong></button>
                                                                @include('emitter.formLayout.respondentModel')
                                                            @endif
                                                        @endif
                                                        <a href="{{ url('emitters/survey/view/' . $data->pivot_id) }}"
                                                            class=" btn btn-xs btn-danger">
                                                            <strong> View</strong> </a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>


                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
@endsection
