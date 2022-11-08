@extends('backend.layouts.app')
@section('title')
    Employee Experience
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
                        <h1>Employee Experience</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Experience</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i>  Employee Experience</strong></h3>
                                <a href="{{url('/orgs/employee/experience/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/experience')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
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
                                                            {{$employee_experience->employee->employee_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Experience In the Present Organisation</td>
                                                        <td>
                                                            {{$employee_experience->present_org_year??null}} Year and {{$employee_experience->present_org_month??null}} Month
                                                        </td>
                                                    </tr>

                                                   <tr>
                                                        <td>Experience In the same Occupation</td>
                                                        <td>
                                                            {{$employee_experience->same_occu_year??null}} Year and {{$employee_experience->same_occu_month??null}} Month
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Experience At Present Position</td>
                                                        <td>
                                                            {{$employee_experience->present_pos_year??null}} Year and {{$employee_experience->present_pos_month??null}} Month
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Experience In Other Organisation</td>
                                                        <td>
                                                            {{$employee_experience->other_org_year??null}} Year and {{$employee_experience->other_org_month??null}} Month
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Total Experience</td>
                                                        <td>
                                                            {{$employee_experience->total_exp_year??null}} Year and {{$employee_experience->total_exp_month??null}} Month
                                                        </td>
                                                    </tr>
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
