@extends('backend.layouts.app')
@section('title')
    Employee Trainings
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Leave</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Training</li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title"><strong><i class="fa fa-list"></i>Employee Trainings</strong></h3>
                            <a href="{{url('/orgs/employee/training/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/training')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>

                        <div class="card-body">
                            @if(!count($employees)<=0)
                                {!! Form::open(['method'=>'post','url'=>'/orgs/employee/training','enctype'=>'multipart/form-data','file'=>true]) !!}
                                <!-- //addition of row -->
                                    <div class="add_item">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                            <label>Employee: </label>
                                            {{Form::select('employee_id',$employees->pluck('employee_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'employee_id','name'=>'employee_id','placeholder'=>
                                            'Select Employee'])}}
                                            {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                   <div class="col-md-2">
                                       <div class="form-group {{ ($errors->has('training_type'))?'has-error':'' }}">
                                           <label>Training Type: </label>
                                           <div class="input-group mb-4">
                                               {{Form::select('training_type[]',$trainings,null,['style' => 'width:100%','class'=>"form-control trainingtype",  'placeholder'=>
                                       'Training Type','id'=>"training_type"])}}
                                           </div>
                                           {!! $errors->first('training_type', '<span class="text-danger">:message</span>') !!}
                                       </div>
                                   </div>
                                    <div class="col-md-2">
                                        <div class="form-group {{ ($errors->has('pre_service_yr'))?'has-error':'' }}">
                                            <label>Preservice Training (Year): </label>
                                            <div class="input-group mb-12">
                                                {!! Form::number('pre_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'pre_service_yr','required' => 'required']) !!}
                                            </div>
                                            {!! $errors->first('pre_service_yr', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group {{ ($errors->has('pre_service_month'))?'has-error':'' }}">
                                            <label>Preservice Training (Month): </label>
                                            <div class="input-group mb-12">
                                                {!! Form::number('pre_service_month[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'pre_service_month','required' => 'required']) !!}
                                            </div>
                                            {!! $errors->first('pre_service_month', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                        <div class="col-md-2">
                                            <div class="form-group {{ ($errors->has('in_service_yr'))?'has-error':'' }}">
                                                <label>Inservice Training (Year): </label>
                                                <div class="input-group mb-12">
                                                    {!! Form::number('in_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'in_service_yr','required' => 'required']) !!}
                                                </div>
                                                {!! $errors->first('in_service_yr', '<span class="text-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('in_service_month'))?'has-error':'' }}">
                                                    <label>Preservice Training (Month): </label>
                                                    <div class="input-group mb-12">
                                                        {!! Form::number('in_service_month[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'in_service_month','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('in_service_month', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                        </div>
                                    <div class="col-md-2" style="padding-top:30px;">
                                        <span class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div  id="addTable" style="display: none" >
                                            <div class="form-group  {{ ($errors->has('others'))?'has-error':'' }}">
                                                <div class="input-group mb-12">
                                                    {!! Form::text('others',null,['class'=>'form-control ','placeholder'=>'others','id'=>'others']) !!}
                                                </div>
                                                {!! $errors->first('others', '<span class="text-danger">:message</span>') !!}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                    </div>
                                    <!-- //addition of row -->


                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{trans('app.save')}}
                        </button>
                    </div>


                    {{ Form::close() }}
                </div>
                @else
                    <div class="col-md-12">
                        <label class="form-control label-danger">Please Add Employ Record First </label>
                    </div>
                @endif
            </div>
    </div>
    </div>
    </section>
    </div>

    <div style="visibility:hidden;">
    <div class="whole_extra_item_add" id="diwakar">
        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
            <div class="form-row">
                <div class="col-md-2">
                    <div class="form-group {{ ($errors->has('training_type'))?'has-error':'' }}">
                        <label>Training Type: </label>
                        <div class="input-group mb-4">
                            {{Form::select('training_type[]',$trainings,null,['style' => 'width:100%','class'=>"form-control  trainingtype",  'placeholder'=>
                    'Training Type','id'=>"training_type"])}}
                        </div>
                        {!! $errors->first('training_type', '<span class="text-danger">:message</span>') !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group {{ ($errors->has('pre_service_yr'))?'has-error':'' }}">
                        <label>Preservice Training (Year): </label>
                        <div class="input-group mb-12">
                            {!! Form::number('pre_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'pre_service_yr','required' => 'required']) !!}
                        </div>
                        {!! $errors->first('pre_service_yr', '<span class="text-danger">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group {{ ($errors->has('pre_service_month'))?'has-error':'' }}">
                        <label>Preservice Training (Month): </label>
                        <div class="input-group mb-12">
                            {!! Form::number('pre_service_month[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'pre_service_month','required' => 'required']) !!}
                        </div>
                        {!! $errors->first('pre_service_month', '<span class="text-danger">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group {{ ($errors->has('in_service_yr'))?'has-error':'' }}">
                        <label>Inservice Training (Year): </label>
                        <div class="input-group mb-12">
                            {!! Form::number('in_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'in_service_yr','required' => 'required']) !!}
                        </div>
                        {!! $errors->first('in_service_yr', '<span class="text-danger">:message</span>') !!}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group {{ ($errors->has('in_service_month'))?'has-error':'' }}">
                        <label>Preservice Training (Month): </label>
                        <div class="input-group mb-12">
                            {!! Form::number('in_service_month[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'in_service_month','required' => 'required']) !!}
                        </div>
                        {!! $errors->first('in_service_month', '<span class="text-danger">:message</span>') !!}
                    </div>
                </div>


                <div class="col-md-2" style="padding-top:30px;">
                    <span class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i></span>
                    <span class="btn btn-danger removeeventmore"><i class="fa fa-minus-circle"></i></span>
                </div>

            </div>
        </div>

    </div>

    </div>
    </div>

@endsection

@section('js')

    <script type="text/javascript">
        $(document).ready(function(){
            var counter=0;
            $(document).on("click",".addeventmore",function(){
                var whole_extra_item_add=$('#diwakar').html();
                $(this).closest(".add_item").append(whole_extra_item_add);
                counter++;
            });
            $(document).on("click",".removeeventmore",function(event){
                $(this).closest(".delete_whole_extra_item_add").remove();
                counter-=1
            });

        });


    </script>
    <script>
        console.log($('.trainingtype'))
        $('.trainingtype').change(function(){
alert();

        })
    </script>

@endsection
