@extends('backend.layouts.app')
@section('title')
    Product And Services
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product And Services</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            {{-- <li class="breadcrumb-item">{{trans('app.configuration')}}</li> --}}
                            <li class="breadcrumb-item active">Product and Services</li>
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

                        <div class="col-md-8" id="listing">
                        @else
                            <div class="col-md-12" id="listing">
                    @endif
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title"><i class="fa fa-list"></i> Product and Service</h3>
                            <?php
                            
                            $permission = helperPermissionLink(url('/product_and_service'), url('/product_and_service'));
                            
                            $allowEdit = $permission['isEdit'];
                            
                            $allowDelete = $permission['isDelete'];
                            
                            $allowAdd = $permission['isAdd'];
                            ?>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                                
                                <thead>
                                    <tr>
                                        <th style="width: 10px;">{{ trans('app.sn') }}</th>
                                        {{-- <th>Parent</th> --}}
                                        <th>Product and Service</th>
                                        <th>Sub Sector</th>
                                        <th style="width: 10px" ; class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <th scope=row>{{ $i }}</th>

                                            <td>{{ $product->product_and_services_name }}</td>
                                            <td>{{ $product->subSector->sector_name ?? null }}</td>
                                            <td class="text-right row" style="margin-right: 0px;">
                                                @if ($allowEdit)
                                                    <a href="{{ route('product_and_service.edit', [$product->id]) }}"
                                                        class="text-info btn btn-xs btn-default" data-toggle="tooltip"
                                                        data-placement="top" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                    </a>&nbsp;
                                                @endif
                                                @if ($allowDelete)
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product_and_service.destroy', $product->id], 'class' => 'inline']) !!}
                                                    <button type="submit"
                                                        class="btn btn-danger btn-xs deleteButton actionIcon"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"
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


                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                @if ($allowAdd)

                    <div class="col-md-4">
                        @if (\Request::segment(3) == 'edit')
                            @include('backend.configurations.productandservice.edit')
                        @else
                            @include('backend.configurations.productandservice.add')
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
