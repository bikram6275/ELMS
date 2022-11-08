@extends('backend.layouts.app')
@section('title')
    Occupation
@endsection
@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Occupation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Occupation</li>
                            <li class="breadcrumb-item active">Add Occupation</li>
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
                            <h3 class="card-title">Add Occupation</h3>
                            <a href="{{url('/occupation/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size: 20px;"></i></a>

                            <a href="{{url('/occupation')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                        </div>

                        <div class="card-body">
                            {!! Form::open(['method'=>'post','url'=>'occupation','enctype'=>'multipart/form-data','file'=>true]) !!}

                            <!-- //addition of row -->
                            <div class="add_item">

                                <div class="row">
                                <div class="form-group  col-md-4{{ ($errors->has('sector_id'))?'has-error':'' }}">
                                    <label>Sector: </label>
                                    {{Form::select('sector_id',$economicsectors->pluck('sector_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'designation_id','placeholder'=>
                                    'Select Sector'])}}
                                    {!! $errors->first('sector_id', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>

                                <div class="row">
                                    <div class="form-group col-md-4{{ ($errors->has('occupation_name.*'))?'has-error':'' }}">
                                        <label>Occupation: </label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('occupation_name[]',null,['class'=>'form-control','placeholder'=>'Occupation']) !!}
                                        </div>
                                        {!! $errors->first('occupation_name.*', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                    <div class="col-md-2" style="padding-top:32px;">
                                        <span class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i></span>

                                    </div>
                                </div>
                            </div>
                                <!-- //addition of row -->

                                <!-- /.form group -->
                                <div class="card-footer">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" class="btn btn-primary">Save</button>
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


    <div style="visibility:hidden;">
        <div class="whole_extra_item_add" id="whole_extra_item_add">
            <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                <div class="form-row">

                    <div class="form-group col-md-4{{ ($errors->has('occupation_name'))?'has-error':'' }}">
                        <label>Occupation: </label>
                        <div class="input-group mb-4">
                            {!! Form::text('occupation_name[]',null,['class'=>'form-control','placeholder'=>'Occupation']) !!}
                        </div>
                        {!! $errors->first('occupation_name', '<span class="text-danger">:message</span>') !!}

                    </div>

                    <div class="col-md-2" style="padding-top:25px;">
                        <span class="btn btn-success addeventmore"><i class="fa fa-plus-circle"></i></span>
                        <span class="btn btn-danger removeeventmore"><i class="fa fa-minus-circle"></i></span>
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

                var whole_extra_item_add=$('#whole_extra_item_add').html();
                $(this).closest(".add_item").append(whole_extra_item_add);
                counter++;
            });
            $(document).on("click",".removeeventmore",function(event){
                $(this).closest(".delete_whole_extra_item_add").remove();
                counter-=1
            });

        });


    </script>

@endsection




