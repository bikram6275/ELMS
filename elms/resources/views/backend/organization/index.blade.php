@extends('backend.layouts.app')
@section('title')
    Organization
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Organization</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            {{-- <li class="breadcrumb-item">{{trans('app.configuration')}}</li> --}}
                            <li class="breadcrumb-item active">Organization</li>
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
                                Filter
                            </div>
                            <div class="card-body">
                                {{-- {!! Form::open(['method'=>'post','url'=>'enumeratorassign','enctype'=>'multipart/form-data','file'=>true]) !!} --}}
                                {!! Form::open(['method' => 'get', route('organization.index'), 'enctype' => 'multipart/form-data', 'file' => true]) !!}

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('pradesh_id') ? 'has-error' : '' }}">
                                            {{ Form::select('pradesh_id', $pradeshes->pluck('pradesh_name', 'id'), Request::get('pradesh_id'), ['class' => 'form-control select2','id' => 'pradesh_id','name' => 'pradesh_id','placeholder' => 'Select Pradesh']) }}
                                            {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
                                            {{ Form::select('district_id', $districts->pluck('english_name', 'id'), Request::get('district_id'), ['class' => 'form-control select2','id' => 'district_id','name' => 'district_id','placeholder' => 'Select District']) }}
                                            {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('org_name') ? 'has-error' : '' }}">
                                            {{ Form::text('org_name', Request::get('org_name'), ['class' => 'form-control','id' => 'org_name','name' => 'org_name','placeholder' => 'Enter Organization name']) }}
                                            {!! $errors->first('org_name', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info " id="assign_button"><i
                                                    class="fa fa-search"></i>Filter
                                            </button>
                                            <a href="{{ url('organization/') }}" class="btn btn-warning "><i
                                                    class="fa fa-refresh"></i> Refresh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-default">
                <div class="card-header with-border">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title"><strong><i class="fa fa-list"></i> Organization</strong></h3>

                            <a href="{{ url('/organization/create') }}" class="pull-right cardTopButton" id="add"
                                data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                    style="font-size:20px;"></i></a>
                            <a href="{{ url('/organization') }}" class="pull-right cardTopButton" data-toggle="tooltip"
                                title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{ URL::previous() }}" class="pull-right cardTopButton" data-toggle="tooltip"
                                title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            {{-- <a href="{{ route('org.import') }}" class="btn btn-primary float-right mr-3 mb-2"> Bulk
                                Import</a> --}}

                        </div>
                    </div>
                </div>
                <div class="card-body" style="overflow-x: scroll">
                    <div class="table-responsive" >
                        <table  class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">{{ trans('app.sn') }}</th>
                                    <th>Organization Name</th>
                                    <th>Pradesh </th>
                                    <th>District </th>
                                    <th>Sector </th>
                                    <th>Ward </th>
                                    <th class="text-center">Status</th>
                                    <th style="width: 10px" ; class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($organizations as $key => $organization)
                                    <tr>
                                        <th scope=row>{{ $i }}</th>
                                        <td>{{ $organization->org_name ?? null }}</td>
                                        <td>{{ $organization->pradesh->pradesh_name ?? null }}</td>
                                        <td>{{ $organization->district->english_name ?? null }}</td>
                                        <td>{{ $organization->sector->sector_name }}</td>
                                        <td>{{ $organization->ward_no ?? null }}</td>
                                        <td>
    
                                            @if ($organization->user_status == 'active')
    
                                                <a class="label label-success stat"
                                                    href="{{ url('/orgs/status', $organization->id) }}">
                                                    <strong class="stat"> Active
                                                    </strong>
                                                </a>
    
                                            @elseif($organization->user_status == 'inactive')
                                                <a class="label label-danger stat"
                                                    href="{{ url('/orgs/status', $organization->id) }}">
                                                    <strong class="stat"> Inactive
                                                    </strong>
                                                </a>
                                            @endif
    
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('organization/' . $organization->id . '/edit') }}"
                                                class="text-info btn btn-xs btn-default">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
    
                                            {!! Form::open(['method' => 'GET', 'route' => ['organization.show', $organization->id], 'class' => 'inline']) !!}
                                            <button type="submit" class="text-info btn btn-xs btn-default">
                                                <i class="fa fa-eye"></i>
                                            </button>
    
                                            {!! Form::close() !!}
    
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['organization.destroy', $organization->id], 'class' => 'inline']) !!}
                                            <button type="submit" class="btn btn-danger btn-xs deleteButton actionIcon"
                                                data-toggle="tooltip" data-placement="top" title="Delete"
                                                onclick="javascript:return confirm('Are you sure you want to delete?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
    
                                            {!! Form::close() !!}
    
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
    
                            </tbody>
    
                        </table>
                    </div>

                </div>
                <div class="pull-right">
                    {{ $organizations->links() }}
                </div>
                {{-- {{$economicsectors->appends(request()->input())->links()}} --}}
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </div>
    </section>
    <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

@endsection
