@extends('backend.layouts.app')
@section('title')
    Employee Experience
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Experience</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Employee Experience</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            {!!
            Form::open(['method'=>'post','url'=>'/orgs/employee/experience','enctype'=>'multipart/form-data','file'=>true])
            !!}
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">

                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Employee Experience</h3>
                            <a href="{{url('/orgs/employee/experience/create')}}" class="pull-right cardTopButton"
                               id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/experience')}}" class="pull-right cardTopButton"
                               data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                            <label>Select Year: </label>
                                            {{Form::select('fy_id',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                            'Select Year' , 'required' => 'required'])}}
                                            {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                            <label>Employee Name: </label>
                                            <div class="input-group mb-3">
                                                {{Form::select('employee_id',$employees->pluck('employee_name','id'),Request::get('id'),['class'=>'form-control
                                             select2','id'=>'employee_id','name'=>'ids[]','placeholder'=>
                                             'Employee Name'])}}
                                            </div>
                                            {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>In the Present Organisation: </label><br>
<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group  {{ ($errors->has('present_org_year'))?'has-error':'' }}">
                                            <label>Year</label>
                                            {!!
                                            Form::number('present_org_year[]',null,['class'=>'form-control',
                                            'placeholder'=>'Year']) !!}
                                            {!! $errors->first('present_org_year', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group  {{ ($errors->has('present_org_month'))?'has-error':'' }}">
                                            <label>Month</label>
                                            {!!
                                            Form::text('present_org_month[]',null,['class'=>'form-control',
                                            'placeholder'=>'Month']) !!}
                                            {!! $errors->first('present_org_month', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
</div>
                                </div>

<div class="col-md-6">
    <label>In the same Occupation: </label><br>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ ($errors->has('same_occu_year'))?'has-error':'' }}">
                <label>Year</label>
                <div class="input-group mb-3">
                    {!!
                    Form::number('same_occu_year[]',null,['class'=>'form-control',
                    'placeholder'=>'Year']) !!}
                </div>
                {!! $errors->first('same_occu_year', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ ($errors->has('same_occu_month'))?'has-error':'' }}">
                <label>Month</label>
                <div class="input-group mb-3">
                    {!!
                    Form::text('same_occu_month[]',null,['class'=>'form-control',
                    'placeholder'=>'Month']) !!}
                </div>
                {!! $errors->first('same_occu_month', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <label>At Present Position: </label><br>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ ($errors->has('present_pos_year'))?'has-error':'' }}">
                <label>Year</label>
                <div class="input-group mb-3">
                    {!!
                    Form::number('present_pos_year[]',null,['class'=>'form-control',
                    'placeholder'=>'Year']) !!}
                </div>
                {!! $errors->first('present_pos_year', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ ($errors->has('present_pos_month'))?'has-error':'' }}">
                <label>Month</label>
                <div class="input-group mb-3">
                    {!!
                    Form::text('present_pos_month[]',null,['class'=>'form-control',
                    'placeholder'=>'Month']) !!}
                </div>
                {!! $errors->first('present_pos_month', '<span class="text-danger">:message</span>') !!}

            </div>
        </div>
    </div>
</div>

<div class="col-md-6">
    <label>In Other Organisation: </label><br>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {{ ($errors->has('other_org_year'))?'has-error':'' }}">
                <label>Year</label>
                <div class="input-group mb-3">
                    {!!
                    Form::number('other_org_year[]',null,['class'=>'form-control',
                    'placeholder'=>'Year']) !!}
                </div>
                {!! $errors->first('other_org_year', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group {{ ($errors->has('other_org_month'))?'has-error':'' }}">
                <label>Month</label>
                <div class="input-group mb-3">
                    {!!
                    Form::text('other_org_month[]',null,['class'=>'form-control',
                    'placeholder'=>'Month']) !!}
                </div>
                {!! $errors->first('other_org_month', '<span class="text-danger">:message</span>') !!}

            </div>
        </div>

    </div>
</div>

<div class="col-md-6">
    <label>Total Experience: </label><br>
    <div class="row">
        <div class="col-md-6">
            <div
                class="form-group {{ ($errors->has('total_exp_year'))?'has-error':'' }}">
                <label>Year: </label>
                <div class="input-group mb-3">
                    {!!Form::number('total_exp_year[]',null,['class'=>'form-control','placeholder'=>'Year']) !!}
                </div>
                {!! $errors->first('total_exp_year', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div
                class="form-group {{ ($errors->has('total_exp_month'))?'has-error':'' }}">
                <label>Month: </label>
                <div class="input-group mb-3">
                    {!!Form::text('total_exp_month[]',null,['class'=>'form-control',
                    'placeholder'=>'Month']) !!}
                </div>
                {!! $errors->first('total_exp_month', '<span class="text-danger">:message</span>') !!}

            </div>
        </div>
    </div>
</div>
                                    <div class="col-md-12">

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('app.save')}}
                                </button>
                            </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}

        </section>
    </div>


@endsection



