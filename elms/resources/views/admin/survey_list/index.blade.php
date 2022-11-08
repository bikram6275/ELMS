@extends('backend.layouts.app')
@section('title')
    Survey List
@endsection

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1> Survey List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Survey List</li>

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
                                <h3 class="card-title">Survey List</h3>


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
                                            @foreach($surveys as $key=>$val)
                                            @if($val->survey!=null)
                                                <tr>
                                                    <th scope=row>{{$i}}</th>
                                                    <td>{{$val->survey->survey_name}}</td>
                                                    <td>{{$val->survey->fiscalyear->fy_name}}</td>
                                                    <td>{{$val->survey->survey_year}}</td>
                                                    <td>{{$val->survey->start_date}}</td>
                                                    <td>{{$val->survey->end_date}}</td>
                                                    <td>

                                                        {!! Form::open(['method' => 'GET', 'route'=>['survey.orgs.show',
                                                                 $val->survey_id],'class'=> 'inline']) !!}
                                                        <button type="submit"
                                                                class="btn-success btn btn-xs ">
                                                           <b>Start</b>
                                                        </button>
                                                        {!! Form::close() !!}
                                                    </td>
                                                </tr>
                                                @else
                                                <tr><td colspan="7" style="text-align: center">No records found</td></tr>
                                                @endif
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
        </section>
    </div>
@endsection
