@extends('backend.layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
@inject('survey_helper','App\Http\Helpers\SurveyHelper')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline" style="overflow-x: scroll">
                        <div class="card-header">
                            <h3 class="card-title">
                                Survey Status
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body ">
                            <table class="table">
                                <tr>
                                    <td> S.N </td>
                                    <td>Enumerator</td>
                                    <td>Question</td>
                                    <td>Answer</td>

                                </tr>
                            {{ count($a) }}
                            </table>
                        </div>
                    </div>
        </section>
    </div>
@endsection

