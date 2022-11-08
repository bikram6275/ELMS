@extends('backend.layouts.app')
@section('title')
    Group
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Group</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">Roles</li>
                            <li class="breadcrumb-item active">Groups</li>
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
                @if(helperPermission()['isAdd'])
                    <div class="col-md-9" id="listing">
                        @else
                            <div class="col-md-12" id="listing">
                                @endif
                                <div class="card card-default">
                                    <div class="card-header with-border">
                                        <h3 class="card-title"><i class="fa fa-list"></i> Groups</h3>
                                        <?php

                                        $permission = helperPermission();

                                        $allowEdit = $permission['isEdit'];

                                        $allowDelete = $permission['isDelete'];
                                        $allowAdd = $permission['isAdd'];
                                        ?>
                                        <a href="{{url('roles/group')}}" class="pull-right boxTopButton"
                                           data-toggle="tooltip" title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>
                                        <a href="{{url('roles/group')}}" class="pull-right  boxTopButton"
                                           data-toggle="tooltip" title="Go Back"><i
                                                    class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                                    </div>

                                    <div class="card-body">

                                        @if(!count($groups)<=0)
                                            <div class="table-responsive">
                                                <table id="example1" class="table table-hover table-striped  table-bordered table-responsive">
                                                    <thead>
                                                    <tr>
                                                        <th>S.N</th>
                                                        <th>Name</th>
                                                        <th>Details</th>
                                                        <th style="width: 50px" class="text-right">Action</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php
                                                    $i = 1;
                                                    ?>
                                                    @foreach($groups as $group)
                                                        <tr>
                                                            <th scope=row>{{$i++}}</th>
                                                            <td>{{$group->group_name}}</td>
                                                            <td>{{$group->group_details}}</td>

                                                            <td class="text-right row" style="margin-right: 0px;">
                                                                @if($allowEdit)
                                                                    <a href="{{route('group.edit',[$group->id])}}"
                                                                       class="text-info btn btn-xs btn-default"
                                                                       data-toggle="tooltip"
                                                                       data-placement="top" title="Edit" style="margin: 0 5px;">
                                                                        <i class="fa fa-pencil-square-o"></i>
                                                                    </a>
                                                                @endif


                                                                @if($allowDelete)
                                                                    {!! Form::open(['method' => 'DELETE', 'route'=>['group.destroy',$group->id],'class'=>'inline']) !!}

                                                                    <button type="submit"
                                                                            class="btn btn-danger btn-xs deleteButton actionIcon"
                                                                            data-toggle="tooltip"
                                                                            data-placement="top" title="Delete"
                                                                            onclick="javascript:return confirm('Are you sure you want to delete?');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                @endif

                                                                {!! Form::close() !!}
                                                            </td>
                                                        </tr>
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

                            @if($allowAdd)
                                <div class="col-md-3">
                                    @if(\Request::segment(4)=='edit')
                                        @include('backend.roles.groups.edit')
                                    @else
                                        @include('backend.roles.groups.add')
                                    @endif

                                </div>
                            @endif
                    </div>
            </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

@endsection