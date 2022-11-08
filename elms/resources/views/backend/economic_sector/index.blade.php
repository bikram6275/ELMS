@extends('backend.layouts.app')
@section('title')
    Economic Sector
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Economic Sector</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
{{--                            <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                            <li class="breadcrumb-item active">Economic Sector</li>
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
                                            <h3 class="card-title"><i class="fa fa-list"></i> Economic Sector</h3>
                                            <?php

                                            $permission = helperPermissionLink(url('/economic_sector'), url('/economic_sector'));

                                            $allowEdit = $permission['isEdit'];

                                            $allowDelete = $permission['isDelete'];

                                            $allowAdd = $permission['isAdd'];
                                            ?>
                                        </div>
                                        <div class="card-body">
                                            <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                                                <div class="row">
                                                        {!! Form::open(['method'=>'get',route('economic_sector.index'),'enctype'=>'multipart/form-data']) !!}

                                                   <div class="col-md-4 form-group">
                                                       {{Form::select('parent_id',$parents->pluck('sector_name','id'),Request::get('parent_id'),
                                                ['class'=>'form-control select2','id'=>'parent-id','placeholder'=>'Select Sector'])}}

                                                   </div>
                                                        <div class="col-md-2 ">
                                                            <button type="submit" class="btn btn-primary">Filter</button>
                                                        </div>
                                                    {!! Form::close() !!}
                                                </div>
                                                <thead>
                                                <tr>
                                                    <th style="width: 10px;">{{trans('app.sn')}}</th>
{{--                                                    <th>Parent</th>--}}
                                                    <th>Sector Name</th>
                                                    <th>Parent</th>
                                                    <th style="width: 10px" ;
                                                        class="text-right">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $i = 1;?>
                                                @foreach($economicsectors as $key=>$economicsector)
                                                    <tr>
                                                        <th scope=row>{{$i}}</th>
{{--                                                        <td>{{$economicsector->parent_id}}</td>--}}
                                                        <td>{{$economicsector->sector_name}}</td>
                                                        <td>{{$economicsector->getParentCategory->sector_name??null}}</td>
                                                        <td class="text-right row" style="margin-right: 0px;">
                                                            @if($allowEdit)
                                                                <a href="{{route('economic_sector.edit',[$economicsector->id])}}"
                                                                   class="text-info btn btn-xs btn-default" data-toggle="tooltip"
                                                                   data-placement="top" title="Edit">
                                                                    <i class="fa fa-pencil-square-o"></i>
                                                                </a>&nbsp;
                                                            @endif
                                                            @if($allowDelete)
                                                                {!! Form::open(['method' => 'DELETE', 'route'=>['economic_sector.destroy',
                                                                    $economicsector->id],'class'=> 'inline']) !!}
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
{{--                                    {{$economicsectors->appends(request()->input())->links()}}--}}

                                    <!-- /.card-body -->
                                    </div>
                                    <!-- /.card -->
                                </div>

                                @if($allowAdd)

                                    <div class="col-md-3">
                                        @if(\Request::segment(3)=='edit')
                                            @include('backend.economic_sector.edit')
                                        @else
                                            @include('backend.economic_sector.add')
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
