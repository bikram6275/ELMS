@extends('backend.layouts.app')
@section('title')
    Employee Training
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Training</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Training</li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('backend.message.flash')
                <div class="row">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title"><strong><i class="fa fa-list"></i>  Employee Training</strong></h3>
                                <a href="{{url('/orgs/employee/training/create')}}" class="pull-right cardTopButton"
                                   id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/training')}}" class="pull-right cardTopButton"
                                   data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="tab-content">
                                    <div class="active">
                                        <div class="box-body box-profile">

                                            <div class="post">
                                                <table class="table table-bordered table-responsive table-hover">
                                                    <tr>

                                                        <td>Employee Name:</td>
                                                        <td>
                                                            {{$shows->employee->employee_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Training Type</td>
                                                        <td>
                                                            {{$shows->training_type??null}}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Preservice Training (Year)</td>
                                                        <td>
                                                            {{$shows->pre_service_yr??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Preservice Training (Month)</td>
                                                        <td>
                                                            {{$shows->pre_service_month??null}}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Inservice Training (Year)</td>
                                                        <td>
                                                            {{$shows->in_service_yr??null}}
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Preservice Training (Month)</td>
                                                        <td>
                                                            {{$shows->in_service_month??null}}
                                                        </td>
                                                    </tr>
                                                    @if(isset($shows->others))
                                                    <tr>

                                                        <td>Others</td>
                                                        <td>
                                                            {{$shows->others??null}}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </table>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
