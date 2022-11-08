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
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Survey</li>
                            <li class="breadcrumb-item active">Add Survey</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Add Survey</h3>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['method'=>'post','url'=>'survey','enctype'=>'multipart/form-data','file'=>true]) !!}


                            <div class="row">
                                <div class="form-group  col-md-12 {{ ($errors->has('survey_name'))?'has-error':'' }}">
                                    <label>Survey Name: </label><label class="text-danger">*</label>
                                    <div class="input-group mb-3">
                                        {!! Form::text('survey_name',null,['class'=>'form-control','placeholder'=>'Survey Name']) !!}
                                    </div>
                                    {!! $errors->first('survey_name', '<span class="text-danger">:message</span>') !!}

                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-3 {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                    <label>Fiscal Year: </label><label class="text-danger">*</label>
                                    {{Form::select('fy_id',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                    'Fiscal Year'])}}
                                    {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-3 {{ ($errors->has('survey_year'))?'has-error':'' }}">
                                    <label>Survey Year: </label><label class="text-danger">*</label>
                                    <div class="input-group mb-3">
                                        {!! Form::text('survey_year',null,['class'=>'form-control','placeholder'=>'Survey Year']) !!}
                                    </div>
                                    {!! $errors->first('survey_year', '<span class="text-danger">:message</span>') !!}

                                </div>
                                <div class="form-group col-md-3 {{ ($errors->has('start_date'))?'has-error':'' }}">
                                    <label>Start Date: </label><label class="text-danger">*</label>
                                    <div class="input-group mb-3">
                                        {!! Form::date('start_date',null,['class'=>'form-control','placeholder'=>'Start Date']) !!}
                                    </div>
                                    {!! $errors->first('start_date', '<span class="text-danger">:message</span>') !!}

                                </div>
                                <div class="form-group col-md-3{{ ($errors->has('end_date'))?'has-error':'' }}">
                                    <label>End Date: </label><label class="text-danger">*</label>
                                    <div class="input-group mb-3">
                                        {!! Form::date('end_date',null,['class'=>'form-control','placeholder'=>'End Date']) !!}
                                    </div>
                                    {!! $errors->first('end_date', '<span class="text-danger">:message</span>') !!}

                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group  col-md-12 {{ ($errors->has('detail'))?'has-error':'' }}">
                                    <label for="user_status">Details: </label> <label class="text-danger">*</label><br>
                                    <div class="input-group mb-3">
                                        {!! Form::textarea ('detail',null,['class'=>'form-control']) !!}
                                    </div>
                                    {!! $errors->first('detail', '<span class="text-danger">:message</span>') !!}

                                </div>

                            </div>

                            <div class="form-group {{ ($errors->has('survey_status'))?'has-error':'' }}">
                                <label for="user_status">Status </label><br>
                                {{Form::radio('survey_status', 'active',null,['class'=>'flat-red'])}} Active &nbsp;&nbsp;&nbsp;
                                {{Form::radio('survey_status', 'inactive',true,['class'=>'flat-red'])}} Inactive
                                {!! $errors->first('survey_status', '<span class="text-danger">:message</span>') !!}
                            </div>

                            <!-- /.form group -->
                            <div class="card-footer ">
                                <div class="col-md-12">
                                    <a href="{{ url('/survey') }}" class="btn btn-danger pull-right">Cancel</a>
                                    <button type="submit" class="btn btn-primary pull-right mx-3 ">Save</button>
                                </div>

                            </div>
                            {!! Form::close() !!}


                        </div>
                        <!-- /.box-body -->
                    </div>

                </div>
            </div>
        </section>
    </div>


@endsection

