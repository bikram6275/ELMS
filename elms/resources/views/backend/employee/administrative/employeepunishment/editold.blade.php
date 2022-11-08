@extends('backend.layouts.app')
@section('title')
    Employee Punishment
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
                            <li class="breadcrumb-item active"> Edit Punishment</li>
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
                                <a href="{{url('orgs/employee/punishment/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('orgs/employee/punishment')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                            @foreach($edits as $edit)
                            <div class="card-body">
                                {!! Form::model($edits, ['method'=>'put','route'=>['punishment.update',$edit->id],'enctype'=>'multipart/form-data','file'=>true]) !!}
                                <div class="card card-default">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" name="employee_name"
                                                   value="{{ $edit->employee->employee_name }}">
                                            <div class="col-md-3">

                                                <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                    <label> Select Employee: </label>

                                                    {{Form::select('employee_id',$employees->pluck('employee_name','id') ,$edit->employee_id,
                                                 ['class'=>'form-control select2','placeholder'=>'Select Employee'])}}
                                                    {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div
                                                    class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                                    <label>Select Year: </label>
                                                    {{Form::select('year',$fiscalyears->pluck('fy_name','id'),$edit->year,['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                                    'Select Year'])}}
                                                    {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group {{ ($errors->has('defence_letter_received'))?'has-error':'' }}">
                                                    <label>Number of Defense Letter Received: </label>
                                                    <div class="input-group mb-4">
                                                        {!! Form::number('defence_letter_received',null,['class'=>'form-control','placeholder'=>'Number of Defense Letter Received']) !!}
                                                    </div>
                                                    {!! $errors->first('defence_letter_received', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group{{ $errors->has('de_promoted') ? ' has-error' : '' }}">
                                                    <label>Grade deduction Records: </label>
                                                    <div class="form-group {{ ($errors->has('de_promoted'))?'has-error':'' }}">

                                                        {{Form::radio('de_promoted', '1',null,['class'=>'flat-red'])}} Yes &nbsp;&nbsp;&nbsp;
                                                        {{Form::radio('de_promoted', '0',true,['class'=>'flat-red'])}} No
                                                        {!! $errors->first('de_promoted', '<span class="text-danger">:message</span>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group{{ $errors->has('grade_deducted') ? ' has-error' : '' }}">
                                                    <label>De promoted Records: </label>
                                                    <div class="form-group {{ ($errors->has('grade_deducted'))?'has-error':'' }}">

                                                        {{Form::radio('grade_deducted', '1',null,['class'=>'flat-red'])}} Yes &nbsp;&nbsp;&nbsp;
                                                        {{Form::radio('grade_deducted', '0',true,['class'=>'flat-red'])}} No
                                                        {!! $errors->first('grade_deducted', '<span class="text-danger">:message</span>') !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('punishment_img'))?'has-error':'' }}">
                                                    <label for="avatar_image" class="control-label align">Document :</label>
                                                    <br>
                                                    {{Form::file('punishment_img',null,['class'=>'form-control','id'=>'org_image','placeholder'=>
                                                    'Choose File'])}}
                                                    {!! $errors->first('punishment_img', '<span class="text-danger">:message</span>') !!}
                                                    @if($edit->punishment_img)
                                                        <a href="{{asset('/storage/uploads/punishmentDoc/'.$edit->organization->org_name.'/'.$edit->year.'/'.$edit->employee_id.'/'.$edit->punishment_img)}}">{{$edit->punishment_img}}</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('app.update')}}
                                </button>
                            </div>
                            {{ Form::close() }}
                                {!! Form::open(['method' => 'DELETE', 'route'=>['punishment.destroy',
                                              $edit->id],'class'=> 'inline']) !!}
                                <div class="form-group" style="margin-left: 10px">
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </div>
                                {!! Form::close() !!}
                        </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            function getDisByPradesh(){
                var district_option =  '<option value="">Select District</option>';
                $('#district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{  url('/get/district/') }}/"+pradesh_id,

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
                    url: "{{  url('/get/municipality/') }}/"+district_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            var is_selected = value.id == municipality_id ?  'selected="selected"' : "";
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
