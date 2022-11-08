@extends('backend.layouts.app')
@section('title')
    Questions
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Questions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('app.dashboard')}}</a></li>
                            <li class="breadcrumb-item active">Questions</li>
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
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title">Questions</h3>
                                <?php

                                $permission = helperPermissionLink(url('question/create'), url('question'));

                                $allowEdit = $permission['isEdit'];

                                $allowDelete = $permission['isDelete'];

                                $allowAdd = $permission['isAdd'];
                                ?>


                            </div>
                            <div class="card-body">
                                @if(!count($questions)<=0)
                                        <div class="col-md-12 topFilter">
                                            <table id="example1"
                                                   class="table table-striped table-bordered table-hover table-responsive">
                                                <thead>
                                                 <tr>
                                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                <th>Question Number</th>
                                                <th>Question Name</th>
                                                <th>Status</th>
                                                <th style="width: 40px !important" ;
                                                    class="text-right">Action</th>
                                            </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $i = 1; ?>
                                                @foreach($questions as $key=>$question)
                                               <tr>
                                                    <th scope=row>{{$i}}</th>
                                                    <td>{{$question->qsn_number}}</td>
                                                    <td>{{$question->qsn_name}}</td>
                                                    <td class="text-center">
                                                        @if($question->qst_status == 'active')
                                                            <a  class="label label-success" href="{{url('question/status',$question->id)}}">
                                                                <strong class="stat"> {{trans('app.active')}}</strong>
                                                            </a>

                                                        @elseif($question->qst_status == 'inactive')
                                                            <a class="label label-danger" href="{{url('question/status',$question->id)}}">
                                                                <strong class="stat"> {{trans('app.inactive')}}</strong>
                                                            </a>
                                                        @endif
                                                    </td>

                                                    <td class="text-right row" >
                                                        @if($allowEdit)
                                                            <a href="{{route('question.edit',[$question->id])}}"
                                                               class="text-info btn btn-xs btn-default" data-toggle="tooltip"
                                                               data-placement="top" title="Edit">
                                                                <i class="fa fa-pencil-square-o"></i>
                                                            </a>&nbsp;
                                                        @endif

                                                        @if($allowDelete)
                                                            {!! Form::open(['method' => 'DELETE', 'route'=>['question.destroy',
                                                                $question->id],'class'=> 'inline']) !!}
                                                            <button type="submit"
                                                                    class="btn btn-danger btn-xs deleteButton actionIcon"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top" title="Delete"
                                                                    onclick="javascript:return confirm('Are you sure you want to delete?');">
                                                                <i class="fa fa-trash"></i>
                                                            </button>

                                                            {!! Form::close() !!}
                                                        @endif



                                                    </td>
                                                </tr>
                                                    <?php $i++; ?>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                @else
                                    <div class="col-md-12">
                                        <label class="form-control label-danger">No records found</label>
                                    </div>
                                @endif

                            </div>

                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>


                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

@endsection
