@extends('backend.layouts.app')
@section('title')
    Fiscal Year
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{trans('app.configuration')}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">{{trans('app.configuration')}}</li>
                            <li class="breadcrumb-item active">{{trans('app.fiscalYear')}}</li>
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
                                        <h3 class="card-title"><i class="fa fa-list"></i> {{trans('app.fiscalYear')}}</h3>
                                        <?php

                                        $permission = helperPermissionLink(url('/configurations/fiscalYear'), url('/configurations/fiscalYear'));

                                        $allowEdit = $permission['isEdit'];

                                        $allowDelete = $permission['isDelete'];

                                        $allowAdd = $permission['isAdd'];

                                        ?>
                                    </div>
                                    <div class="card-body">
                                        <table id="example1"
                                               class="table table-hover table-responsive table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                <th class="text-center">Fiscal Year Name</th>
                                                <th class="text-center">{{trans('app.startDate')}}</th>
                                                <th class="text-center">{{trans('app.startDateLocalize')}}</th>
                                                <th class="text-center">{{trans('app.endDate')}}</th>
                                                <th class="text-center">{{trans('app.endDateLocalize')}}</th>
                                                <th class="text-center">{{trans('app.status')}}</th>
                                                <th style="width: 50px;" class="text-right">{{trans('app.action')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1;?>
                                            @forelse($fiscalYears as $fiscalYear)
                                                <tr>
                                                    <th scope=row>{{$i}}</th>
                                                    <td>{{$fiscalYear->fy_name}}</td>
                                                    <td>{{$fiscalYear->fy_start_date}}</td>
                                                    <td>{{$fiscalYear->fy_start_date_localized}}</td>
                                                    <td>{{$fiscalYear->fy_end_date}}</td>
                                                    <td>{{$fiscalYear->fy_end_date_localized}}</td>
                                                    <td class="text-center">
                                                        @if($fiscalYear->fy_status == 'active')
                                                            <a class="label label-success stat"
                                                               href="{{url('configurations/fiscalYear/status',$fiscalYear->id)}}">
                                                                <strong class="stat"> {{trans('app.active')}}
                                                                </strong>
                                                            </a>

                                                        @elseif($fiscalYear->fy_status == 'inactive')
                                                            <a class="label label-danger stat"
                                                               href="{{url('configurations/fiscalYear/status',$fiscalYear->id)}}">
                                                                <strong class="stat"> {{trans('app.inactive')}}
                                                                </strong>
                                                            </a>
                                                        @endif
                                                    </td>
                                                    <td class="text-right row" style="margin-right: 0px;">
                                                        @if($allowEdit)
                                                            <a href="{{route('fiscalYear.edit',[$fiscalYear->id])}}"
                                                               class="text-info btn btn-xs btn-default"
                                                               data-toggle="tooltip"
                                                               data-placement="top" title="Edit">
                                                                <i class="fa fa-pencil-square-o"></i>
                                                            </a>&nbsp;
                                                        @endif

                                                        @if($allowDelete)
                                                            {!! Form::open(['method' => 'DELETE', 'route'=>['fiscalYear.destroy',
                                                                $fiscalYear->id],'class'=> 'inline']) !!}
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
                                            @empty
                                            @endforelse
                                            </tbody>
                                        </table>

                                    </div>

                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>

                            @if($allowAdd)
                                <div class="col-md-3">
                                    @if(\Request::segment(4)=='edit')
                                        @include('backend.configurations.fiscalYear.edit')
                                    @else
                                        @include('backend.configurations.fiscalYear.add')
                                    @endif

                                </div>
                            @endif
                    </div>
            </div>
            </div>
        </section>
    </div>

@endsection
@section('js')

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $( function() {
            $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );

        $( function() {
            $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );

        $( function() {
            $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );

        $( function() {
            $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
        } );
    </script>
@endsection