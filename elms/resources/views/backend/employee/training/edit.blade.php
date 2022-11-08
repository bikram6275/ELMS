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
                        <h1>  Employee Training</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Training</li>
                            <li class="breadcrumb-item active"> Edit </li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i>   Employee Training</strong></h3>
                                <a href="{{url('/orgs/employee/training/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/training')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                            <div class="card-body">
                                {!! Form::model($edits, ['method'=>'put','route'=>['training.update',$edits->id],'enctype'=>'multipart/form-data','file'=>true]) !!}
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                    <label> Employee: </label>
                                                    {{Form::text('employee_id',$edits->employee->employee_name,
                                             ['class'=>'form-control ','id'=>'employee_id','placeholder'=>'Select Employee','readonly','disabled'])}}
                                                    {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label> Training Type</label>
                                                <div class="form-group {{ ($errors->has('others'))?'has-error':'' }}">
                                                    <div class="input-group mb-12">
                                                        <div class="input-group mb-6">
                                                            {{Form::select('training_type',$trainings,null,['style' => 'width:100%','class'=>'form-control select2','id'=>"training_type",'placeholder'=>
                                                             'Training Type'])}}
                                                        </div>
                                                        <br>
                                                        <br>
                                                        <div id="othersTable" >
                                                            <div class="form-group {{ ($errors->has('others'))?'has-error':'' }}">
                                                                <div class="input-group mb-12">
                                                                    {!! Form::text('others',null,['class'=>'form-control','placeholder'=>'others','id'=>'others']) !!}
                                                                </div>
                                                                {!! $errors->first('others', '<span class="text-danger">:message</span>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {!! $errors->first('others', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                                <div class="col-md-2">
                                                    <label> Pre-Service Training Duration (Year)</label>
                                                    <div class="form-group {{ ($errors->has('pre_service_yr'))?'has-error':'' }}">
                                                        <div class="input-group mb-12">
                                                            {!! Form::number('pre_service_yr',null,['class'=>'form-control','placeholder'=>'Year','id'=>'pre_service_yr','required' => 'required']) !!}
                                                        </div>
                                                        {!! $errors->first('pre_service_yr', '<span class="text-danger">:message</span>') !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label> Pre-Service Training Duration (Month)	</label>
                                                    <div class="form-group {{ ($errors->has('pre_service_month'))?'has-error':'' }}">
                                                        <div class="input-group mb-12">
                                                            {!! Form::number('pre_service_month',null,['class'=>'form-control','placeholder'=>'Month','id'=>'pre_service_month','required' => 'required']) !!}
                                                        </div>
                                                        {!! $errors->first('pre_service_month', '<span class="text-danger">:message</span>') !!}
                                                    </div>
                                                </div>
                                            <div class="col-md-2">
                                                <label> In-service Training Duration (Year)</label>
                                                <div class="form-group {{ ($errors->has('in_service_yr'))?'has-error':'' }}">
                                                    <div class="input-group mb-12">
                                                        {!! Form::number('in_service_yr',null,['class'=>'form-control','placeholder'=>'Year','id'=>'in_service_yr','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('in_service_yr', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label> In-service Training Duration (Month)	</label>
                                                <div class="form-group {{ ($errors->has('in_service_month'))?'has-error':'' }}">
                                                    <div class="input-group mb-12">
                                                        {!! Form::number('in_service_month',null,['class'=>'form-control','placeholder'=>'Month','id'=>'in_service_month','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('in_service_month', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
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
        </section>
    </div>
@endsection
@section('js')
    <script>
        $('#training_type').change(function(){
            var ans= $('#training_type').val();
            if(ans=='others' ){
                $('#othersTable').show();
            }else{
                $('#othersTable').hide();
            }
        })
    </script>
@endsection
