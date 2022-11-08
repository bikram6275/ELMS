@extends('backend.layouts.app')
@section('title')
    Occupation
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
                        <h1>Occupation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Occupation</a></li>
                            {{--                            <li class="breadcrumb-item active">Organization</li>--}}
                            <li class="breadcrumb-item active"> Edit Occupation</li>
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
                                <h3 class="card-title">Occupation</h3>

                                <a href="{{url('occupation/create')}}" class="pull-right boxTopButton" id="add"
                                   data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{url('/occupation')}}" class="pull-right boxTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right boxTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                            </div>
                            <div class="card-body">

                                {!! Form::model($edits,['method'=>'PUT','route'=>['occupation.update',$edits->id],'files'=>true]) !!}

                                <div class="row">
                                    <div class="form-group col-md-4 {{ ($errors->has('sector_id'))?'has-error':'' }}">
                                        <label>Sector: </label>
                                        {{Form::select('sector_id',$economicsectors->pluck('sector_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'designation_id','placeholder'=>
                                        'Select Sector'])}}
                                        {!! $errors->first('sector_id', '<span class="text-danger">:message</span>') !!}
                                    </div>


                                    <div class="form-group col-md-4 {{ ($errors->has('occupation_name'))?'has-error':'' }}">
                                        <label>Occupation: </label>
                                        <div class="input-group mb-3">

                                            {!! Form::text('occupation_name',null,['class'=>'form-control','placeholder'=>'Occupation Name']) !!}
                                        </div>
                                        {!! $errors->first('occupation_name', '<span class="text-danger">:message</span>') !!}

                                    </div>

                                </div>

                                <!-- /.form group -->
                                <div class="card-footer ">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}


                            </div>
                            <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection



