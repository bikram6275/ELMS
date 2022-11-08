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
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Organization</li>
                            <li class="breadcrumb-item active">Add Organization</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Organization</h3>
                            <a href="{{url('/organization/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size: 20px;"></i></a>

                            <a href="{{url('/organization')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['method'=>'post','url'=>'organization','enctype'=>'multipart/form-data','file'=>true]) !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('org_name'))?'has-error':'' }}">
                                        <label>Organization Name: </label><label class="text-danger">*</label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('org_name',null,['class'=>'form-control','placeholder'=>'Organization Name']) !!}
                                        </div>
                                        {!! $errors->first('org_name', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group {{ ($errors->has('sector_id'))?'has-error':'' }}">
                                        <label>Select Sector: </label><label class="text-danger">*</label>
                                        {{Form::select('sector_id',$parents->pluck('sector_name','id'),Request::get('parent_id'),
                                ['class'=>'form-control select2','id'=>'parent-id','placeholder'=>'Select Sector'])}}
                                        {!! $errors->first('sector_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('pradesh_id'))?'has-error':'' }}">
                                        <label>Pradesh: </label><label class="text-danger">*</label>
                                        {{Form::select('pradesh_id',$pradeshes->pluck('pradesh_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'pradesh_id','name'=>'pradesh_id','placeholder'=>
                                        'Select Pradesh'])}}
                                        {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('district_id'))?'has-error':'' }}">
                                        <label>District: </label><label class="text-danger">*</label>
                                        {{Form::select('district_id',$districts->pluck('english_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'district_id','name'=>'district_id','placeholder'=>
                                        'Select District'])}}
                                        {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('muni_id'))?'has-error':'' }}">
                                        <label>Municipality: </label><label class="text-danger">*</label>
                                        {{Form::select('muni_id',$municipalities->pluck('muni_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'municipality_id','placeholder'=>
                                        'Select Municipality'])}}
                                        {!! $errors->first('muni_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('ward_no'))?'has-error':'' }}">
                                        <label>Ward No: </label><label class="text-danger">*</label>
                                        <div class="input-group mb-3">
                                            {!! Form::number('ward_no',null,['class'=>'form-control','placeholder'=>'Ward No']) !!}
                                        </div>
                                        {!! $errors->first('ward_no', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('tole'))?'has-error':'' }}">
                                        <label>Tole: </label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('tole',null,['class'=>'form-control','placeholder'=>'Tole']) !!}
                                        </div>
                                        {!! $errors->first('tole', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>
                                <div class="col-md-3">

                                        <div class="form-group {{ ($errors->has('establish_date'))?'has-error':'' }}">
                                            <label>Establish Date: </label><label class="text-danger">*</label>
                                            <div class="input-group mb-3">
                                                {!! Form::date('establish_date',null,['class'=>'form-control','placeholder'=>'Establish Date']) !!}
                                            </div>
                                            {!! $errors->first('establish_date', '<span class="text-danger">:message</span>') !!}
                                        </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('fax'))?'has-error':'' }}">
                                        <label>Fax: </label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('fax',null,['class'=>'form-control','placeholder'=>'Fax']) !!}
                                        </div>
                                        {!! $errors->first('fax', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('website'))?'has-error':'' }}">
                                        <label>Website: </label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('website',null,['class'=>'form-control','placeholder'=>'Website']) !!}
                                        </div>
                                        {!! $errors->first('website', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('pan_number'))?'has-error':'' }}">
                                        <label>Pan Number: </label><label class="text-danger">*</label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('pan_number',null,['class'=>'form-control','placeholder'=>'Pan Number']) !!}
                                        </div>
                                        {!! $errors->first('pan_number', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('licensce_no'))?'has-error':'' }}">
                                        <label>License Number: </label><label class="text-danger">*</label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('licensce_no',null,['class'=>'form-control','placeholder'=>'License Number']) !!}
                                        </div>
                                        {!! $errors->first('licensce_no', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('phone_no'))?'has-error':'' }}">
                                        <label>Phone: </label>
                                        <div class="input-group mb-3">
                                            {!! Form::text('phone_no',null,['class'=>'form-control','placeholder'=>'Phone']) !!}
                                        </div>
                                        {!! $errors->first('phone_no', '<span class="text-danger">:message</span>') !!}

                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 {{ ($errors->has('detail'))?'has-error':'' }}">
                                    <label for="user_status">Details: </label><label class="text-danger">*</label><br>
                                    <div class="input-group mb-3">
                                        {!! Form::textarea ('detail',null,['class'=>'form-control']) !!}
                                    </div>
                                    {!! $errors->first('detail', '<span class="text-danger">:message</span>') !!}

                                </div>
                            </div>

                            <br>
                            <div class="card card-default">
                                <div class="card-header with-border">
                                    <h3 class="card-title"><strong>Organization Login Registration Details :</strong></h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group {{ ($errors->has('email'))?'has-error':'' }}">
                                        <label>Login Email: </label><label class="text-danger">*</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'email@example.com']) !!}
                                        </div>
                                        {!! $errors->first('email', '<span class="text-danger">:message</span>') !!}

                                    </div>

                                    <div class="form-group {{ ($errors->has('password'))?'has-error':'' }}">
                                        <label for="user_status">Password: </label><label class="text-danger">*</label><br>
                                        <div class="input-group mb-3">
                                            {!! Form::password('password',null,['class'=>'form-control']) !!}
                                        </div>
                                        {!! $errors->first('password', '<span class="text-danger">:message</span>') !!}

                                    </div>

                                    <div class="form-group {{ ($errors->has('org_image'))?'has-error':'' }}">
                                        <label for="avatar_image" class="control-label align">Organization Logo : </label>
                                        <br>
                                        {{Form::file('org_image',null,array('class'=>'form-control','id'=>'org_image','placeholder'=>
                                        'Choose File'))}}
                                        <span class="help-block inline">Upload Type: JPG, JPEG, PNG</span><br>
                                        {!! $errors->first('org_image', '<span class="text-danger">:message</span>') !!}
                                    </div>


                                    <div class="form-group {{ ($errors->has('user_status'))?'has-error':'' }}">
                                        <label for="user_status">Status </label><br>
                                        {{Form::radio('user_status', 'active',null,['class'=>'flat-red'])}} Active &nbsp;&nbsp;&nbsp;
                                        {{Form::radio('user_status', 'inactive',true,['class'=>'flat-red'])}} Inactive
                                        {!! $errors->first('user_status', '<span class="text-danger">:message</span>') !!}
                                    </div>






                                </div>
                                <!-- /.box-body -->
                            </div>
                            <div class="card-footer ">
                                <div class="col-md-12">
                                    <a href="{{ url('/organization') }}" class="btn btn-danger pull-right">Cancel</a>
                                    <button type="submit" class="btn btn-primary pull-right mx-3 ">Save</button>
                                </div>

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
