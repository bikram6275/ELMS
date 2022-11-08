@extends('backend.layouts.app')
@section('title')
    Enumerator
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Enumerator</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            {{--                            <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                            <li class="breadcrumb-item active">Enumerator</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('backend.message.flash')

                <div class="card card-default">
                    <div class="card-header with-border">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Enumerator</strong></h3>
                                <a href="{{url('/emitter/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/emitter')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                {{--                                                    <th>Parent</th>--}}
                                <th>Emitter Name</th>
                                <th>Pradesh </th>
                                <th>District </th>
                                <th>Municipality </th>
                                <th>Ward </th>
                                <th class="text-center">Status</th>
                                <th style="width: 10px" ;
                                    class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1;?>
                            @foreach($emitters as $key=>$emitter)
                                <tr>
                                    <th scope=row>{{$i}}</th>
                                    <td>{{$emitter->name??null}}</td>
                                    <td>{{$emitter->pradesh->pradesh_name??null}}</td>
                                    <td>{{$emitter->district->english_name??null}}</td>
                                    <td>{{$emitter->municipality->muni_name??null}}</td>
                                    <td>{{$emitter->ward_no??null}}</td>
                                    <td>{{$emitter->user_status??null}}</td>
{{--                                    <td>--}}

{{--                                        @if($organization->user_status== 'active')--}}

{{--                                            <a class="label label-success stat"--}}
{{--                                               href="{{url('/orgs/status',$organization->id)}}">--}}
{{--                                                <strong class="stat"> Active--}}
{{--                                                </strong>--}}
{{--                                            </a>--}}

{{--                                        @elseif($organization->user_status== 'inactive')--}}
{{--                                            <a class="label label-danger stat"--}}
{{--                                               href="{{url('/orgs/status',$organization->id)}}">--}}
{{--                                                <strong class="stat"> Inactive--}}
{{--                                                </strong>--}}
{{--                                            </a>--}}
{{--                                        @endif--}}

{{--                                    </td>--}}
                                    <td class="text-center">
                                        <a href="{{url('emitter/'.$emitter->id .'/edit')}}"
                                           class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        {!! Form::open(['method' => 'GET', 'route'=>['emitter.show',
                                                $emitter->id],'class'=> 'inline']) !!}
                                        <button type="submit"
                                                class="text-info btn btn-xs btn-default">
                                            <i class="fa fa-eye"></i>
                                        </button>

                                        {!! Form::close() !!}

                                        {!! Form::open(['method' => 'DELETE', 'route'=>['emitter.destroy',
                                                $emitter->id],'class'=> 'inline']) !!}
                                        <button type="submit"
                                                class="btn btn-danger btn-xs deleteButton actionIcon"
                                                data-toggle="tooltip"
                                                data-placement="top" title="Delete"
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
                {{--                                    {{$economicsectors->appends(request()->input())->links()}}--}}
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

@endsection
