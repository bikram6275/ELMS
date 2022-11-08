@extends('backend.layouts.app')
@section('title')

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
                        <h1>Assigned Survey</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Emitter</a></li>
                            <li class="breadcrumb-item active">Assigned Survey</li>
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
{{--                                <h3 class="card-title">Emitter</h3>--}}

                                <a href="{{url('enumeratorassign/create')}}" class="pull-right boxTopButton" id="add"
                                   data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{url('/enumeratorassign')}}" class="pull-right boxTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right boxTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>{{$survey->survey_name}}</strong></h3>

                                </div>

                                <div class="col-md-12" id="" style="display: block">
                                    <hr />
                                    <div class=" row  mt-3 ml-2">
                                        <div class="col-md-3">
                                            <strong> Survey Year : <span
                                                    class="badge badge-warning">{{ $survey->survey_year??null }}</span></strong>
                                        </div>
                                        <div class="col-md-3">

                                            <strong> Start Date :
                                                <span class="badge badge-warning">{{ $survey->start_date??null }}</span>
                                                &nbsp;
                                            </strong>
                                        </div>
                                        <div class="col-md-3">

                                            <strong> End Date :
                                                <span class="badge badge-warning">{{ $survey->end_date??null }}</span>
                                                &nbsp;
                                            </strong>
                                        </div>
                                        <div class="col-md-3">

                                            <strong> Details :
                                                <span class="badge badge-warning">{{ $survey->detail??null}}</span>
                                                &nbsp;
                                            </strong>
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
