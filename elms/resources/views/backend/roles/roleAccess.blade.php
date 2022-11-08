@extends('backend.layouts.app')
@section('title')
    Role Access
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item">Roles</li>
                            <li class="breadcrumb-item active">Role Access</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header with-border">
                        <h3 class="card-title">Assign roles to group</h3>
                        <a href="#" class="pull-right" data-toggle="tooltip" title="Go Back"><i
                                    class="fa fa-arrow-circle-left fa-2x"></i></a>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                {{--<form class="form-inline">--}}
                                {!! Form::open(['class'=>'form-inline','url'=>'roles/roleAccessIndex','method'=>'GET']) !!}
                                @csrf
                                <div class="form-group col-sm-6 col-xs-6 col-md-3 col-lg-3">

                                    {{Form::select('group_id',$groupList->pluck('group_name','id'),Request::get('group_id'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'group_id','placeholder'=>
                                    'Select Group Name'])}}
                                    {!! $errors->first('group_id', '<span class="text-danger">:message</span>') !!}

                                </div>

                                <button type="submit" class="btn btn-primary save col-sm-3 col-xs-3 col-md-1 col-lg-1"
                                        name="filter">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                    Filter
                                </button>
                                {!! Form::close() !!}
                                {{--</form>--}}
                            </div>
                            <br>
                            <br>
                            {{--message flash--}}
                            <div class="col-lg-12">
                                @if(count($menus)>1)
                                    <div class="table-responsive">
                                        <table class="table  table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>Module</th>
                                                <th>Read?</th>
                                                <th>Write?</th>
                                                <th>Edit?</th>
                                                <th>Delete?</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @if(count($menus) !=0)

                                                <?php $i = 1; ?>
                                                @foreach($menus as $menu)

                                                    <tr>
                                                        <td>{{ $i }}. {{ $menu->menu_name }}</td>
                                                        <td>

                                                            {{--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch>--}}
                                                            {{--<input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">--}}


                                                            <div class="checkbox">

                                                                <label>

                                                                    <input type="checkbox" data-toggle="toggle"  data-bootstrap-switch data-off-color="danger read" data-on-color="success read"
                                                                           data-size="mini"
                                                                           class="read"
                                                                           {{ ($menu->allow_view == 1)?'checked':null }}
                                                                           value="{{$menu->group_role_id}}">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><!-- Rounded switch -->
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" data-toggle="toggle"  data-bootstrap-switch data-off-color="danger write" data-on-color="success write"
                                                                           data-size="mini"
                                                                           {{ ($menu->allow_add == 1)?'checked':null }}
                                                                           class="write"
                                                                           value="{{$menu->group_role_id}}">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><!-- Rounded switch -->
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" data-toggle="toggle"  data-bootstrap-switch data-off-color="danger edit" data-on-color="success edit"
                                                                           data-size="mini"
                                                                           {{ ($menu->allow_edit == 1)?'checked':null }}
                                                                           class="edit"
                                                                           value="{{ $menu->group_role_id }}">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td><!-- Rounded switch -->
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" data-toggle="toggle"  data-bootstrap-switch data-off-color="danger delete" data-on-color="success delete"
                                                                           data-size="mini"
                                                                           {{ ($menu->allow_delete == 1)?'checked':null }}
                                                                           class="delete"
                                                                           value="{{$menu->group_role_id}}">
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $secondLevelMenus = $menuRepo->getAccessMenu($menu->id,
                                                        Request::get('group_id'));
                                                    $j = 1;
                                                    ?>
                                                    @if(count($secondLevelMenus) > 0)
                                                        @foreach($secondLevelMenus as $secondLevelMenu)
                                                            <tr>
                                                                <td><p style="padding-left: 15px;">{{ $i.'.'.$j++ }}
                                                                        . {{ $secondLevelMenu->menu_name }}</p></td>
                                                                <td>
                                                                    <div class="checkbox">

                                                                        <label>
                                                                            <input type="checkbox" data-toggle="toggle"  data-bootstrap-switch data-off-color="danger read" data-on-color="success read"
                                                                                   data-size="mini"
                                                                                   {{ ($secondLevelMenu->allow_view == 1)?'checked':null }}
                                                                                   class="read"
                                                                                   value="{{$secondLevelMenu->group_role_id}}">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td><!-- Rounded switch -->
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" data-toggle="toggle"  data-bootstrap-switch data-off-color="danger write" data-on-color="success write"
                                                                                   data-size="mini"
                                                                                   {{ ($secondLevelMenu->allow_add == 1)?'checked':null }}
                                                                                   class="write"
                                                                                   value="{{$secondLevelMenu->group_role_id}}">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td><!-- Rounded switch -->
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" data-toggle="toggle"  data-bootstrap-switch data-off-color="danger edit" data-on-color="success edit"
                                                                                   data-size="mini"
                                                                                   {{ ($secondLevelMenu->allow_edit == 1)?'checked':null }}
                                                                                   class="edit"
                                                                                   value="{{ $secondLevelMenu->group_role_id }}">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                                <td><!-- Rounded switch -->
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input type="checkbox" data-toggle="toggle" data-bootstrap-switch data-off-color="danger delete" data-on-color="success delete"
                                                                                   data-size="mini"
                                                                                   {{ ($secondLevelMenu->allow_delete == 1)?'checked':null }}
                                                                                   class="delete"
                                                                                   value="{{$secondLevelMenu->group_role_id}}">
                                                                        </label>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif

                                                    <?php $i++; ?>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="callout callout-info">
                                        Please select the group name from above drop down menu.
                                    </div>
                                @endif
                            </div>

                        </div>


                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
//            alert('asldkasd');
            $('.read').on('click', function () {

                read = $(this).parent().children('input').val();

                console.log(read);
                $.ajax({
                    url: "roleChangeAccess/1/" + read,
                    type: "GET"
                });
            });
            $('.write').on('click', function () {
                write = $(this).parent().children('input').val();

                $.ajax({
                    url: "roleChangeAccess/2/" + write,
                    type: "GET"
                });
            });
            $('.edit').on('click', function () {
                edit = $(this).parent().children('input').val();
//                        console.log(edit);

                $.ajax({
                    url: "roleChangeAccess/3/" + edit,
                    type: "GET"
                });
            });
            $('.delete').on('click', function () {
                del = $(this).parent().children('input').val();
//                        console.log(delete);

                $.ajax({
                    url: "roleChangeAccess/4/" + del,
                    type: "GET"
                });
            });
        });
    </script>
@endsection
