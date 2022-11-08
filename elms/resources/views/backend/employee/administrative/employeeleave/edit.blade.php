@extends('backend.layouts.app')
@section('title')
    Employee Leave
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
                        <h1>Employee Leave</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Leave</li>
                            <li class="breadcrumb-item active"> Edit Leave</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Leave</strong></h3>
                                <a href="{{url('/orgs/employee/leave/create')}}" class="pull-right cardTopButton"
                                   id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/leave')}}" class="pull-right cardTopButton"
                                   data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                            <div class="card-body">
                                {!! Form::model($edits, ['method'=>'put','route'=>['leave.update',$edits->id],'enctype'=>'multipart/form-data','file'=>true]) !!}
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div
                                                    class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                    <label> Employee: </label>
                                                    {{Form::text('employee_id',$edits->employee->employee_name,
                                            ['class'=>'form-control ','id'=>'employee_id','placeholder'=>'Select Employee','readonly','disabled'])}}
                                                    {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group {{ ($errors->has('year'))?'has-error':'' }}">
                                                    <label>Year: </label>
                                                    <div class="input-group mb-3">
                                                        {{Form::select('year',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control
                                                              select2','placeholder'=>
                                                              'Select Leave Type','name'=>'year'])}}
                                                    </div>
                                                    {!! $errors->first('leavetype_id', '<span
                                                        class="text-danger">:message</span>')
                                                    !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {{ ($errors->has('leavetype_id'))?'has-error':'' }}">
                                                    <label>Leave Type: </label>
                                                    <div class="input-group mb-3">
                                                        {{Form::select('leavetype_id',$leave_types->pluck('leave_type','id'),Request::get('id'),['class'=>'form-control
                                                              select2','placeholder'=>
                                                              'Select Leave Type','name'=>'leave_type'])}}
                                                    </div>
                                                    {!! $errors->first('leavetype_id', '<span
                                                        class="text-danger">:message</span>')
                                                    !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div
                                                    class="form-group {{ ($errors->has('paid_leave'))?'has-error':'' }}">
                                                    <label> Paid Leave: </label>
                                                    <div class="input-group mb-4">
                                                        {!! Form::number('paid_leave',null,['class'=>'form-control','placeholder'=>'Paid Leave','id'=>'paid_leave[]']) !!}
                                                    </div>
                                                    {!! $errors->first('paid_leave', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div
                                                    class="form-group {{ ($errors->has('paid_leave_used'))?'has-error':'' }}">
                                                    <label> Paid Leave: (Used) </label>
                                                    <div class="input-group mb-4">
                                                        {!! Form::number('paid_leave_used',null,['class'=>'form-control','placeholder'=>'Paid Leave (Days Spent)','id'=>'paid_leave_used[]','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('paid_leave_used', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{trans('app.update')}}
                                    </button>
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            function getDisByPradesh() {
                var district_option = '<option value="">Select District</option>';
                $('#district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{  url('/get/district/') }}/" + pradesh_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            flag = (district_id == value.id) ? "selected='selected'" : "";
                            district_option += `<option value="${value.id}" ${flag}> ${value.nepali_name}</option>`;
                        });
                        var select_group = $('#district_id');
                        select_group.empty().append(district_option);
                        $('#district_id').prop('disabled', false);
                    },
                });
            }

            function getMuniByDis() {
                var muni_option = '<option value="">Select Municipality</option>';
                $('#municipality_id').prop('disabled', true);
                console.log(district_id);
                $.ajax({
                    url: "{{  url('/get/municipality/') }}/" + district_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            var is_selected = value.id == municipality_id ? 'selected="selected"' : "";
                            muni_option += `<option value="${value.id}" ${is_selected}>${value.muni_name}</option>`;
                        });
                        var select_group = $('#municipality_id');
                        select_group.empty().append(muni_option);
                        $('#municipality_id').prop('disabled', false);
                    },

                });
            }

            $('#pradesh_id').change(function () {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });

            $('#district_id').change(function () {
                district_id = $('#district_id').val();
                getMuniByDis();
            });
        });
    </script>
@endsection
