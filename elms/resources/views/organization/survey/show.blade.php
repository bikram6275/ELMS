@extends('backend.layouts.app')
@section('title')
    Survey
@endsection
@section('content')


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
{{--                <div class="col-sm-6">--}}
{{--                    <h1>Survey</h1>--}}
{{--                </div>--}}
{{--                <div class="col-sm-6">--}}
{{--                    <ol class="breadcrumb float-sm-right">--}}
{{--                        <li class="breadcrumb-item"><a href="{{url('/orgs/dashboard')}}">Survey</a></li>--}}
{{--                        <li class="breadcrumb-item active">Survey</li>--}}
{{--                    </ol>--}}
{{--                </div>--}}
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Survey</h3>

{{--                            <a href="{{url('/organization')}}" class="pull-right boxTopButton" data-toggle="tooltip"--}}
{{--                               title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>--}}

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

                            <div class="tab-content">
                                <div class="active">
                                    <div class="box-body box-profile">

                                        <div class="post">
                                            <table class="table table-bordered table-responsive table-hover">
                                                <tr>
                                                    <td>Survey Name</td>
                                                    <td>
                                                        {{$survey->survey_name??null}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Fiscal Year</td>
                                                    <td>{{$survey->fiscalyear->fy_name??null}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Survey Year</td>
                                                    <td>{{$survey->survey_year??null}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Start Date</td>
                                                    <td>{{$survey->start_date??null}}</td>
                                                </tr>
                                                <tr>
                                                    <td>End Date</td>
                                                    <td>{{$survey->end_date??null}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Detail</td>
                                                    <td>{{$survey->detail??null}}</td>
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
