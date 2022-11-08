@extends('backend.layouts.app')
@section('title')
    User
@endsection

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Coordinator Supervisor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Coordinator Supervisor</li>
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
                    @if (helperPermission()['isAdd'])
                        <div class="col-md-9" id="listing">
                        @else
                            <div class="col-md-12" id="listing">
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-list"></i> Coordinator Supervisor</h3>
                            <div class="pull-right">
                                <?php
                                
                                $permission = helperPermissionLink(url('coordinator_survey'), url('user'));
                                
                                $allowEdit = $permission['isEdit'];
                                
                                $allowDelete = $permission['isDelete'];
                                
                                $allowAdd = $permission['isAdd'];
                                
                                ?>
                            </div>

                        </div>
                        <div class="card-body">
                            @if (!count($rows) <= 0)
                                <div class="table-responsive">
                                    <table id="example1"
                                        class="table table-striped table-bordered table-hover table-responsive">
                                        <thead>
                                            <tr>
                                                <th>S.N</th>
                                                <th>Coordinator Name</th>
                                                <th>Supervisor Name</th>
                                                <th style="width: 70px;" class="text-right">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $i = 1;
                                            ?>
                                            @foreach ($rows as $row)
                                                <tr>
                                                    <th scope=row>{{ $i++ }}</th>
                                                    <td>{{ $row->coordinator ? $row->coordinator->name : '-' }}</td>
                                                    <td>{{ $row->supervisor ? $row->supervisor->name : '-' }}</td>

                                                    <td class="text-right row" style="margin: 0px;">
                                                        @if ($allowEdit)
                                                            <a href="{{ route('coordinator_supervisor.edit', [$row->id]) }}"
                                                                class="text-info btn btn-xs btn-default"
                                                                data-toggle="tooltip" data-placement="top" title="Edit">
                                                                <i class="fa fa-pencil-square-o"></i>
                                                            </a>&nbsp;
                                                        @endif



                                                        @if ($allowDelete)
                                                            {!! Form::open(['method' => 'DELETE', 'class' => 'inline', 'route' => ['coordinator_supervisor.destroy', $row->id]]) !!}
                                                            <button type="submit"
                                                                class="btn btn-danger btn-xs deleteButton actionIcon"
                                                                data-toggle="tooltip" data-placement="top" title="Delete"
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

                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

                @if ($allowAdd)
                    <div class="col-md-3">
                        @if (\Request::segment(3) == 'edit')
                            @include('backend.coordinator_supervisor.edit')
                        @else
                            @include('backend.coordinator_supervisor.add')
                        @endif

                    </div>
                @endif
            </div>
    </div>
    </div>
    </section>
    <!-- /.content -->
    </div>
@endsection
