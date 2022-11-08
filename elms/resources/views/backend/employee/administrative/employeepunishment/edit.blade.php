@extends('backend.layouts.app')
@section('title')
    Employee Award
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Punishment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Punishment</li>
                            <li class="breadcrumb-item active">Edit</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Punishment</strong></h3>
                                <a href="{{url('/orgs/employee/punishment/create')}}" class="pull-right cardTopButton"
                                   id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/punishment')}}" class="pull-right cardTopButton"
                                   data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="tab-content">
                                    <div class="active">
                                        <div class="box-body box-profile">
                                            <div class="post">
                                                @if(!count($edits)<=0)
                                                    <div class="row">
                                                        <div class="box-header with-border">
                                                            <h4 class="box-title"><strong>Employee Name:
                                                                    <span
                                                                        class="badge badge-success">{{$edits[0]->employee->employee_name??null}}</span></strong>
                                                            </h4>
                                                        </div>
                                                        <div class="box-header with-border">
                                                            <h4 class="box-title" style="margin-left: 20px"><strong>Fiscal
                                                                    Year:
                                                                    <span
                                                                        class="badge badge-success">{{$edits[0]->fiscal->fy_name??null}}</span></strong>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    {!! Form::model($edits, ['method'=>'post','url'=>'/orgs/employee/punishmentupdate','enctype'=>'multipart/form-data','file'=>true]) !!}
                                                    <table class="table table-bordered table-responsive table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                            <th>Number of Defense Letter Received</th>
                                                            <th>Grade deduction Records</th>
                                                            <th>De promoted Records</th>
                                                            <th>Document</th>
                                                            <th>Action</th>

                                                        </tr>
                                                        </thead>
                                                        <?php $i = 1;?>

                                                        <tbody>

                                                        @foreach($edits as $edit)
                                                            <tr>
                                                                <input type="hidden" value="{{$edit->id}}" name="id[]"/>
                                                                <input type="hidden" value="{{$edit->employee_id}}"
                                                                       name="employee_id[]"/>
                                                                <input type="hidden" value="{{$edit->year}}"
                                                                       name="fy_id[]"/>
                                                                <input type="hidden" name="employee_name"
                                                                       value="{{ $edit->employee->employee_name }}">
                                                                <input type="hidden" name="year"
                                                                       value="{{ $edit->fiscal->fy_name }}">
                                                                <th scope=row>{{$i}}</th>
                                                                <td>
                                                                    <div class="input-group mb-3">
                                                                        {!! Form::number('defence_letter_received[]',$edit->defence_letter_received,['class'=>'form-control','placeholder'=>'Number of Grade Earned']) !!}
                                                                    </div>
                                                                    {!! $errors->first('defence_letter_received', '<span class="text-danger">:message</span>') !!}
                                                                </td>
                                                                <td>
                                                                    <select class="form-control"
                                                                            name="de_promoted[]"
                                                                            id="de_promoted">
                                                                        <option value="0" {{ $edit->de_promoted == 0 ? 'selected' : '' }}>No</option>
                                                                        <option value="1" {{ $edit->de_promoted == 0 ? 'selected' : '' }}>Yes</option>
                                                                    </select>
                                                                    {!! $errors->first('de_promoted', '<span class="text-danger">:message</span>') !!}
                                                                </td>

                                                                <td>
                                                                    <select class="form-control"
                                                                            name="grade_deducted[]"
                                                                            id="grade_deducted">
                                                                        <option value="0" {{ $edit->grade_deducted == 0 ? 'selected' : '' }}>No</option>
                                                                        <option value="1" {{ $edit->grade_deducted == 0 ? 'selected' : '' }}>Yes</option>
                                                                    </select>
                                                                    {!! $errors->first('grade_deducted', '<span class="text-danger">:message</span>') !!}
                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class="form-group {{ ($errors->has('punishment_img'))?'has-error':'' }}">
                                                                        <input type="file" class="form-control"
                                                                               name="punishment_img[]"
                                                                               id="punishment_img"
                                                                               placeholder="Choose File" multiple>
                                                                        {!! $errors->first('punishment_img', '<span class="text-danger">:message</span>') !!}
                                                                        @if($edit->punishment_img)
                                                                            <a href="{{asset('/storage/uploads/punishmentDoc/'.$edit->organization->org_name.'/'.$edit->year.'/'.$edit->employee_id.'/'.$edit->punishment_img)}}">{{$edit->punishment_img}}</a>
                                                                        @endif
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    {!! Form::open(['method' => 'post', 'url'=>'/orgs/employee/punishmentupdate',
                                                                        'class'=> 'inline']) !!}
                                                                    <button type="submit"
                                                                            name="submit"
                                                                            value="{{$edit->id}}"
                                                                            class="btn btn-danger btn-xs "
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Delete"
                                                                            onclick="return confirm('Are you sure you want to delete?');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>

                                                                    {{ Form::close() }}
                                                                </td>

                                                            </tr>
                                                            <?php $i++; ?>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                    <div class="form-group">
                                                        <button value="update" name="submit" type="submit"
                                                                class="btn btn-primary" style="margin-left: 10px">
                                                            {{trans('app.update')}}
                                                        </button>
                                                    </div>

                                                    {!! Form::close() !!}
                                            </div>
                                            @else
                                                <div class="col-md-12">
                                                    <label class="form-control label-danger">No Record found</label>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
