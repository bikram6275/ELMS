@extends('backend.layouts.app')
@section('title')
    Survey
@endsection

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Survey</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/emitters/dashboard')}}">{{trans('app.dashboard')}}</a></li>
                            <li class="breadcrumb-item active">survey</li>
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
                                <h3 class="card-title">Survey</h3>


                            </div>
                            <div class="card-body">
                                @if(!count($surveys)<=0)
                                    <div class="col-md-12 topFilter">
                                        <table id="example1"
                                               class="table table-striped table-bordered table-hover table-responsive">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                <th> Survey Name</th>
                                                <th>Fiscal Year</th>
                                                <th>Survey Year</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th style="width: 40px !important" ;
                                                    class="text-right">Action</th>
                                            </tr>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = 1; ?>
                                            @foreach($surveys as $key=>$survey)
                                                <tr>
                                                    <th scope=row>{{$i}}</th>
                                                    <td>{{$survey->survey_name}}</td>
                                                    <td>{{$survey->fy_id}}</td>
                                                    <td>{{$survey->survey_year}}</td>
                                                    <td>{{$survey->start_date}}</td>
                                                    <td>{{$survey->end_date}}</td>

{{--                                                    <td class="text-right row" >--}}
{{--                                                        {!! Form::open(['method' => 'GET', 'route'=>['org.survey.show',--}}
{{--                                                                    $survey->id],'class'=> 'inline']) !!}--}}
{{--                                                        <button type="submit"--}}
{{--                                                                class="text-info btn btn-xs btn-default">--}}
{{--                                                            <i class="fa fa-eye"></i>--}}
{{--                                                        </button>--}}
{{--                                                        {!! Form::close() !!}--}}

{{--                                                        {!! Form::open(['method' => 'GET', 'route'=>['orgs.answere.show',--}}
{{--                                                                   $survey->id],'class'=> 'inline']) !!}--}}
{{--                                                        <button type="submit"--}}
{{--                                                                class="text-info btn btn-xs btn-default">--}}
{{--                                                            <i class="fa fa-reply" aria-hidden="true"></i>--}}

{{--                                                        </button>--}}


{{--                                                        {!! Form::close() !!}--}}
{{--                                                        <a href={{url('orgs/answer/'.$survey->id)}} class=" btn text-info btn btn-xs btn-default mt-2">--}}
{{--                                                        <strong> Survey Start</strong> </a>--}}

{{--                                                    </td>--}}
                                                </tr>
                                                <?php $i++; ?>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                @else
                                    <div class="col-md-12">
                                        <label class="form-control label-danger">No records found</label>
                                    </div>
                                @endif

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
