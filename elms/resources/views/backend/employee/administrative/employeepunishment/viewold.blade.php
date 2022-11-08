@extends('backend.layouts.app')
@section('title')
    Employee Punishment
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
                        <h1>Employee Punishment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Punishment</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Punishment</strong></h3>
                                <a href="{{url('/orgs/employee/punishment/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/punishment')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @foreach($employee_punishments as $employee_punishment)
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
                                                            {{$employee_punishment->employee->employee_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Year</td>
                                                        <td>
                                                            {{$employee_punishment->year??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Number of Defense Letter Received</td>
                                                        <td>{{$employee_punishment->defence_letter_received??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Grade deduction Records	</td>
                                                        <td>
                                                            @if($employee_punishment->grade_deducted==0)
                                                                <span>No</span>
                                                            @else
                                                                <span>Yes</span>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>De promoted Records</td>
                                                        <td>
                                                            @if($employee_punishment->de_promoted==0)
                                                                <span>No</span>
                                                            @else
                                                                <span>Yes</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Document</td>
                                                        <td>
                                                            @if($employee_punishment->punishment_img)
                                                                <a href="{{asset('/storage/uploads/punishmentDoc/'.$employee_punishment->organization->org_name.'/'.$employee_punishment->year.'/'.$employee_punishment->employee_id.'/'.$employee_punishment->punishment_img)}}">{{$employee_punishment->punishment_img}}</a>
                                                            @else
                                                               <span>No img</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                                <hr style="border: 1px solid black;">
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
