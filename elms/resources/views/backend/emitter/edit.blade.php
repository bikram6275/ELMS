@extends('backend.layouts.app')
@section('title')
    Enumerator
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
                        <h1>Enumerator</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Enumerator</a></li>
                            {{-- <li class="breadcrumb-item active">Organization</li> --}}
                            <li class="breadcrumb-item active"> Edit Enumerator</li>
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
                                <h3 class="card-title">Enumerator</h3>

                                <a href="{{ url('emitter/create') }}" class="pull-right boxTopButton" id="add"
                                    data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                        style="font-size: 20px;"></i></a>

                                <a href="{{ url('/emitter') }}" class="pull-right boxTopButton" data-toggle="tooltip"
                                    title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{ URL::previous() }}" class="pull-right boxTopButton" data-toggle="tooltip"
                                    title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                            </div>
                            <div class="card-body">
                                {!! Form::model($edits, [
                                    'method' => 'put',
                                    'route' => ['emitter.update', $edits->id],
                                    'enctype' => 'multipart/form-data',
                                    'file' => true,
                                ]) !!}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <label>Emitter Name: </label><label class="text-danger">*</label>
                                            <div class="input-group mb-3">
                                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'emitter Name']) !!}
                                            </div>
                                            {!! $errors->first('name', '<span class="text-danger">:message</span>') !!}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('phone_no') ? 'has-error' : '' }}">
                                            <label>Phone: </label>
                                            <div class="input-group mb-3">
                                                {!! Form::text('phone_no', null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                                            </div>
                                            {!! $errors->first('phone_no', '<span class="text-danger">:message</span>') !!}

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('supervisor_id') ? 'has-error' : '' }}">
                                            <label>Supervisor: </label><label class="text-danger">*</label>
                                            {{ Form::select('supervisor_id', $supervisors, Request::get('id'), [
                                                'class' => 'form-control select2',
                                                'id' => 'supervisor_id',
                                                'name' => 'supervisor_id',
                                                'placeholder' => 'Select Supervisor',
                                            ]) }}
                                            {!! $errors->first('supervisor_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group {{ $errors->has('pradesh_id') ? 'has-error' : '' }}">
                                            <label>Pradesh: </label><label class="text-danger">*</label>
                                            {{ Form::select('pradesh_id', $pradeshes->pluck('pradesh_name', 'id'), Request::get('id'), [
                                                'class' => 'form-control select2',
                                                'id' => 'pradesh_id',
                                                'name' => 'pradesh_id',
                                                'placeholder' => 'Select Pradesh',
                                            ]) }}
                                            {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
                                            <label>District: </label><label class="text-danger">*</label>
                                            {{ Form::select('district_id', $districts->pluck('english_name', 'id'), Request::get('id'), [
                                                'class' => 'form-control select2',
                                                'id' => 'district_id',
                                                'name' => 'district_id',
                                                'placeholder' => 'Select District',
                                            ]) }}
                                            {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {{ $errors->has('muni_id') ? 'has-error' : '' }}">
                                            <label>Municipality: </label><label class="text-danger">*</label>
                                            {{ Form::select('muni_id', $municipalities->pluck('muni_name', 'id'), Request::get('id'), [
                                                'class' => 'form-control select2',
                                                'id' => 'municipality_id',
                                                'placeholder' => 'Select Municipality',
                                            ]) }}
                                            {!! $errors->first('muni_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group {{ $errors->has('ward_no') ? 'has-error' : '' }}">
                                            <label>Ward No: </label><label class="text-danger">*</label>
                                            <div class="input-group mb-3">
                                                {!! Form::number('ward_no', null, ['class' => 'form-control', 'placeholder' => 'Ward No']) !!}
                                            </div>
                                            {!! $errors->first('ward_no', '<span class="text-danger">:message</span>') !!}

                                        </div>
                                    </div>
                                </div>





                                <div class="card-footer ">
                                    <div class="col-md-12">
                                        <a href="{{ url('/emitter') }}" class="btn btn-danger pull-right">Cancel</a>
                                        <button type="submit" class="btn btn-primary pull-right mx-3 ">Update</button>
                                    </div>

                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title"><strong>Emitter Login Registration Details :</strong></h3>
                            </div>
                            <div class="card-body">
                                {!! Form::model($edits, [
                                    'method' => 'post',
                                    'route' => ['emitter.changePassword', $edits->id],
                                    'enctype' => 'multipart/form-data',
                                    'file' => true,
                                ]) !!}
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                        <label>Login Email:</label><label class="text-danger">*</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            </div>
                                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'email@example.com']) !!}
                                        </div>
                                        {!! $errors->first('email', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>

                               <div class="col-md-6">
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label for="user_status">Password: </label><label class="text-danger">*</label><br>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        {!! Form::password('password', ['class' => 'form-control']) !!}
                                    </div>
                                    {!! $errors->first('password', '<span class="text-danger">:message</span>') !!}

                                </div>
                               </div>
                               <div class="col-md-6">
                                <div class="form-group {{ $errors->has('user_status') ? 'has-error' : '' }}">
                                    <label for="user_status">Status </label><br>
                                    {{ Form::radio('user_status', 'active', null, ['class' => 'flat-red']) }} Active
                                    &nbsp;&nbsp;&nbsp;
                                    {{ Form::radio('user_status', 'inactive', true, ['class' => 'flat-red']) }} Inactive
                                    {!! $errors->first('user_status', '<span class="text-danger">:message</span>') !!}
                                </div>
                               </div>
                            </div>
                            <div class="card-footer ">
                                <div class="col-md-12">
                                    <a href="{{ url('/emitter') }}" class="btn btn-danger pull-right">Cancel</a>
                                    <button type="submit" class="btn btn-primary pull-right mx-3 ">Update</button>
                                </div>
                            </div>
                            {{ Form::close() }}

                            <!-- /.box-body -->
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
            function getDisByPradesh() {
                var district_option = '<option value="">Select District</option>';
                $('#district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{ url('/get/district/') }}/" + pradesh_id,

                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            flag = (district_id == value.id) ? "selected='selected'" : "";
                            district_option +=
                                `<option value="${value.id}" ${flag}> ${value.nepali_name}</option>`;
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
                    url: "{{ url('/get/municipality/') }}/" + district_id,

                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var is_selected = value.id == municipality_id ?
                                'selected="selected"' : "";
                            muni_option +=
                                `<option value="${value.id}" ${is_selected}>${value.muni_name}</option>`;
                        });
                        var select_group = $('#municipality_id');
                        select_group.empty().append(muni_option);
                        $('#municipality_id').prop('disabled', false);
                    },

                });
            }

            $('#pradesh_id').change(function() {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });

            $('#district_id').change(function() {
                district_id = $('#district_id').val();
                getMuniByDis();
            });
        });
    </script>
@endsection
