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
                        <h1>Employee Award</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Award</li>
                            <li class="breadcrumb-item active"> Edit Award</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Award</strong></h3>
                                <a href="{{url('/orgs/employee/award/create')}}" class="pull-right cardTopButton"
                                   id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/award')}}" class="pull-right cardTopButton"
                                   data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                            {!! Form::model($edits, ['method'=>'post','url'=>'/orgs/employee/award/update','enctype'=>'multipart/form-data','file'=>true]) !!}
                            @foreach($edits as $edit)
                                <div class="card-body" >
                                    <input type="hidden" value="{{$edit->id}}" name="id[]"/>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                <label>Select Employee: </label>
                                                {{Form::select('employee_id[]',$employees->pluck('employee_name','id') ,$edit->employee_id,
                                         ['class'=>'form-control select2','placeholder'=>'Select Employee'])}}
                                                {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                                <label>Select Year: </label>
                                                {{Form::select('fy_id[]',$fiscalyears->pluck('fy_name','id'),$edit->fy_id,['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                                'Select Year'])}}
                                                {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ ($errors->has('grade_earned'))?'has-error':'' }}">
                                                <label>Number of Grade Earned: </label>
                                                <div class="input-group mb-3">
                                                    {!! Form::number('grade_earned[]',$edit->grade_earned,['class'=>'form-control','placeholder'=>'Number of Grade Earned']) !!}
                                                </div>
                                                {!! $errors->first('grade_earned', '<span class="text-danger">:message</span>') !!}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group {{ ($errors->has('promotion_received'))?'has-error':'' }}">
                                                <label>Number of Promotion Received: </label>
                                                <div class="input-group mb-3">
                                                    {!! Form::number('promotion_received[]',$edit->promotion_received,['class'=>'form-control','placeholder'=>'Number of Promotion Received']) !!}
                                                </div>
                                                {!! $errors->first('promotion_received', '<span class="text-danger">:message</span>') !!}

                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group{{ $errors->has('appreciation_letter') ? ' has-error' : '' }}">
                                                <label for="employee_of_yr">Appreciation Letter </label><label
                                                    class="text-danger"> *</label><br>
                                                <select class="form-control"
                                                        name="appreciation_letter[]"
                                                        id="appreciation_letter">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                {!! $errors->first('appreciation_letter', '<span class="text-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group{{ $errors->has('employee_of_yr') ? ' has-error' : '' }}">
                                                <label for="employee_of_yr">Employee of Year </label><label
                                                    class="text-danger"> *</label><br>
                                                <select class="form-control"
                                                        name="employee_of_yr[]"
                                                        id="employee_of_yr">
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                {!! $errors->first('employee_of_yr', '<span class="text-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                </div>
                                <hr style="border: 1px solid grey;"/>

                            @endforeach
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" style="margin-left: 10px">
                                    {{trans('app.update')}}
                                </button>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            function getDisByPradesh() {
                var district_option = '<option value="">Select District</option>';
                $('#district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{  url('/get/district/') }}/" + pradesh_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            flag = (district_id == value.id) ? "selected='selected'" : "";
                            district_option += `<option value="${value.id}" ${flag}> ${value.nepali_name}</option>`;
                        });
                        var select_group = $('#district_id');
                        select_group.empty().append(district_option);
                        $('#district_id').prop('disabled', false);
                    },
                });
            }

            function getMuniByDis() {
                var muni_option = '<option value="">Select Municipality</option>';
                $('#municipality_id').prop('disabled', true);
                console.log(district_id);
                $.ajax({
                    url: "{{  url('/get/municipality/') }}/" + district_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            var is_selected = value.id == municipality_id ? 'selected="selected"' : "";
                            muni_option += `<option value="${value.id}" ${is_selected}>${value.muni_name}</option>`;
                        });
                        var select_group = $('#municipality_id');
                        select_group.empty().append(muni_option);
                        $('#municipality_id').prop('disabled', false);
                    },

                });
            }

            $('#pradesh_id').change(function () {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });

            $('#district_id').change(function () {
                district_id = $('#district_id').val();
                getMuniByDis();
            });
        });
    </script>
@endsection
