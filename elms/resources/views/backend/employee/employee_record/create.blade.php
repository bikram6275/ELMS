@extends('backend.layouts.app')
@section('title')
Employee Record
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Employee Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee</li>
                        <li class="breadcrumb-item active">Employee Details</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        {!!
        Form::open(['method'=>'post','route'=>'employeeRecord.store','enctype'=>'multipart/form-data','file'=>true])
        !!}
        @include('backend.message.flash')
        <div class="row">
            <div class="col-md-12" id="listing">

                <div class="card card-default">
                    <div class="card-header with-border">
                        <h3 class="card-title">Employee Details</h3>
                        <a href="{{url('/orgs/employeeRecord/create')}}" class="pull-right cardTopButton" id="add"
                            data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                style="font-size: 20px;"></i></a>
                        <a href="{{url('/orgs/employeeRecord')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                            title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                        <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                            title="Go Back">
                            <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('employee_name'))?'has-error':'' }}">
                                    <label>Employee Name: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('employee_name',null,['class'=>'form-control',
                                        'placeholder'=>'Emloyee Name']) !!}
                                    </div>
                                    {!! $errors->first('employee_name', '<span class="text-danger">:message</span>') !!}

                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="form-group {{ ($errors->has('date_of_birth'))?'has-error':'' }}">
                                    <label>Date Of Birth: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::date('date_of_birth',null,['class'=>'form-control','placeholder'=>'Date Of
                                        Birth']) !!}
                                    </div>
                                    {!! $errors->first('date_of_birth', '<span class="text-danger">:message</span>') !!}
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('gender'))?'has-error':'' }}">
                                    <label>Gender: </label>
                                    {{Form::select('gender',$genders->pluck('name','id'),Request::get('id'),['class'=>'form-control
                                    select2','id'=>'gender','name'=>'gender','placeholder'=>
                                    'Select Gender'])}}
                                    {!! $errors->first('gender', '<span
                                        class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('phone_no'))?'has-error':'' }}">
                                    <label>Phone: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::number('phone_no',null,['class'=>'form-control',
                                        'placeholder'=>'Phone']) !!}
                                    </div>
                                    {!! $errors->first('phone_no', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('mobile_no'))?'has-error':'' }}">
                                    <label>Mobile: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::number('mobile_no',null,['class'=>'form-control',
                                        'placeholder'=>'Mobile']) !!}
                                    </div>
                                    {!! $errors->first('mobile_no', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('email'))?'has-error':'' }}">
                                    <label>Email: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::email('email',null,['class'=>'form-control',
                                        'placeholder'=>'Email']) !!}
                                    </div>
                                    {!! $errors->first('email', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('education_type_id'))?'has-error':'' }}">
                                    <label>Education Type: </label>
                                    <div class="input-group mb-3">
                                        {{Form::select('education_type_id',$eduTypes->pluck('name','id'),Request::get('id'),['class'=>'form-control
                                        select2','id'=>'education_type_id','name'=>'education_type_id','placeholder'=>
                                        'Select Education Type'])}}
                                    </div>
                                    {!! $errors->first('education_type_id', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('education_level_id'))?'has-error':'' }}">
                                    <label>Education Level: </label>
                                    <div class="input-group mb-3">
                                        {{Form::select('education_level_id',$eduLevels->pluck('level','id'),Request::get('id'),['class'=>'form-control
                                        select2','id'=>'education_level_id','name'=>'education_level_id','placeholder'=>
                                        'Select Education level'])}}
                                    </div>
                                    {!! $errors->first('education_level_id', '<span
                                        class="text-danger">:message</span>')
                                    !!}
                                </div>

                            </div>
                            <div class="col-md-4">

                                <div class="form-group {{ ($errors->has('marital_status'))?'has-error':'' }}">
                                    <label for="marital_status">Marital Status </label><br>
                                    {{Form::radio('marital_status',
                                    'unmarried',true,['class'=>'flat-red','id'=>'unmarried'])}} Unmarried
                                    &nbsp;&nbsp;&nbsp;
                                    {{Form::radio('marital_status',
                                    'married',null,['class'=>'flat-red','id'=>'married'])}}
                                    Married
                                    {!! $errors->first('marital_status', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>

                            </div>
                        </div>
                        <div class="row" style="display: none" id="maritial_status">
                            <div class="col-md-6">
                                <div class="form-group {{ ($errors->has('spouse_name'))?'has-error':'' }}">
                                    <label>Spouse Name: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('spouse_name',null,['class'=>'form-control',
                                        'placeholder'=>'Spouse Name']) !!}
                                    </div>
                                    {!! $errors->first('spouse_name', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ ($errors->has('no_of_children'))?'has-error':'' }}">
                                    <label>No. of Childrens: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::number('no_of_children',null,['class'=>'form-control',
                                        'placeholder'=>'No. of Childrens']) !!}
                                    </div>
                                    {!! $errors->first('no_of_children', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                        </div>
                        <hr />
                        <label>Parents Details: </label><br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('father_name'))?'has-error':'' }}">
                                    <label>Father Name: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('father_name',null,['class'=>'form-control',
                                        'placeholder'=>'Father Name']) !!}
                                    </div>
                                    {!! $errors->first('father_name', '<span class="text-danger">:message</span>') !!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('mother_name'))?'has-error':'' }}">
                                    <label>Mother Name: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('mother_name',null,['class'=>'form-control',
                                        'placeholder'=>'Mother Name']) !!}
                                    </div>
                                    {!! $errors->first('mother_name', '<span class="text-danger">:message</span>') !!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('grand_father_name'))?'has-error':'' }}">
                                    <label>Grand Father: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('grand_father_name',null,['class'=>'form-control',
                                        'placeholder'=>'Grand Father Name']) !!}
                                    </div>
                                    {!! $errors->first('grand_father_name', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12" id="listing">
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title"><strong>Address:</strong></h3><br>
                    <div class="card-body">
                        <label for="contact-permanent">Permanent Address:</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('permanent_pradesh_id'))?'has-error':'' }}">
                                    <label>Pradesh: </label>
                                    {{Form::select('permanent_pradesh_id',$pradeshes->pluck('pradesh_name','id'),Request::get('id'),['class'=>'form-control
                                    select2','id'=>'permanent_pradesh_id','name'=>'permanent_pradesh_id','placeholder'=>
                                    'Select Permanent Pradesh'])}}
                                    {!! $errors->first('permanent_pradesh_id', '<span
                                        class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('permanent_district_id'))?'has-error':'' }}">
                                    <label>District: </label>
                                    {{Form::select('permanent_district_id',$districts->pluck('english_name','id'),Request::get('id'),['class'=>'form-control
                                    select2','id'=>'permanent_district_id','name'=>'permanent_district_id','placeholder'=>
                                    'Select District'])}}
                                    {!! $errors->first('permanent_district_id', '<span
                                        class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('permanent_muni_id'))?'has-error':'' }}">
                                    <label>Municipality/R.Municipality: </label>
                                    {{Form::select('permanent_muni_id',$municipalities->pluck('muni_name','id'),Request::get('id'),['class'=>'form-control
                                    select2','id'=>'permanent_municipality_id','name'=>'permanent_muni_id','placeholder'=>
                                    'Select Municipality'])}}
                                    {!! $errors->first('permanent_muni_id', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('permanent_ward_no'))?'has-error':'' }}">
                                    <label>Ward No: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::number('permanent_ward_no',null,['class'=>'form-control',
                                        'placeholder'=>'Ward No']) !!}
                                    </div>
                                    {!! $errors->first('permanent_ward_no', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                        </div>
                        <label for="contact-permanent">Contact Address:</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('pradesh_id'))?'has-error':'' }}">
                                    <label>Pradesh: </label>
                                    {{Form::select('pradesh_id',$pradeshes->pluck('pradesh_name','id'),Request::get('id'),['class'=>'form-control
                                    select2','id'=>'pradesh_id','name'=>'pradesh_id','placeholder'=>
                                    'Select Pradesh'])}}
                                    {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('district_id'))?'has-error':'' }}">
                                    <label>District: </label>
                                    {{Form::select('district_id',$districts->pluck('english_name','id'),Request::get('id'),['class'=>'form-control
                                    select2','id'=>'district_id','name'=>'district_id','placeholder'=>
                                    'Select District'])}}
                                    {!! $errors->first('district_id', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('muni_id'))?'has-error':'' }}">
                                    <label>Municipality/R.Municipality: </label>
                                    {{Form::select('muni_id',$municipalities->pluck('muni_name','id'),Request::get('id'),['class'=>'form-control
                                    select2','id'=>'municipality_id','placeholder'=>
                                    'Select Municipality'])}}
                                    {!! $errors->first('muni_id', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('ward_no'))?'has-error':'' }}">
                                    <label>Ward No: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::number('ward_no',null,['class'=>'form-control',
                                        'placeholder'=>'Ward No']) !!}
                                    </div>
                                    {!! $errors->first('ward_no', '<span class="text-danger">:message</span>') !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="listing">
            <div class="card card-default">
                <div class="card-header with-border">
                    <h3 class="card-title"><strong>Employment Records:</strong></h3><br>
                    <div class="card-body">
                        <label for="contact-permanent">Records at Present Organisation/Company:</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('first_entry_position'))?'has-error':'' }}">
                                    <label>First Entry Position/Title: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('first_entry_position',null,['class'=>'form-control',
                                        'placeholder'=>'Emloyee Position']) !!}
                                    </div>
                                    {!! $errors->first('first_entry_position', '<span
                                        class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('level'))?'has-error':'' }}">
                                    <label>Level: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('level',null,['class'=>'form-control',
                                        'placeholder'=>'Emloyee Level']) !!}
                                    </div>
                                    {!! $errors->first('level', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('join_date'))?'has-error':'' }}">
                                    <label>First Entry Date: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::date('join_date',null,['class'=>'form-control',
                                        'placeholder'=>'join_date']) !!}
                                    </div>
                                    {!! $errors->first('join_date', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('employee_type_id'))?'has-error':'' }}">
                                    <label>Employee Type: </label>
                                    <div class="input-group mb-3">
                                        {{Form::select('employee_type_id',$employeeTypes->pluck('name','id'),Request::get('id'),['class'=>'form-control
                                        select2','placeholder'=>
                                        'Select Employee Type','name'=>'employee_type_id'])}}
                                    </div>
                                    {!! $errors->first('employee_type_id', '<span class="text-danger">:message</span>')
                                    !!}
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('promoted_level'))?'has-error':'' }}">
                                    <label>Promoted Level: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('promoted_level',null,['class'=>'form-control',
                                        'placeholder'=>'Emloyee promoted level']) !!}
                                    </div>
                                    {!! $errors->first('promoted_level', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('present_position'))?'has-error':'' }}">
                                    <label>Present Position/Title: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('present_position',null,['class'=>'form-control',
                                        'placeholder'=>'Emloyee present position']) !!}
                                    </div>
                                    {!! $errors->first('present_position', '<span class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group {{ ($errors->has('immediate_promoted_date'))?'has-error':'' }}">
                                    <label>Immediate Promoted Date: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::date('immediate_promoted_date',null,['class'=>'form-control',
                                        'placeholder'=>'immediate_promoted_date']) !!}
                                    </div>
                                    {!! $errors->first('immediate_promoted_date', '<span
                                        class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <br>
                        </div>
                        <label>Working Hours/Days:</label>
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group {{ ($errors->has('working_hour_per_week'))?'has-error':'' }}">
                                    <label>Per Week: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('working_hour_per_week',null,['class'=>'form-control',
                                        'placeholder'=>'Working hour per week']) !!}
                                    </div>
                                    {!! $errors->first('working_hour_per_week', '<span
                                        class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                            <div class="col-md-4">

                                <div
                                    class="form-group {{ ($errors->has('working_hour_per_days_in_month'))?'has-error':'' }}">
                                    <label>Days in Month: </label>
                                    <div class="input-group mb-3">
                                        {!!
                                        Form::text('working_hour_per_days_in_month',null,['class'=>'form-control',
                                        'placeholder'=>'Working hour per days in month']) !!}
                                    </div>
                                    {!! $errors->first('working_hour_per_days_in_month', '<span
                                        class="text-danger">:message</span>')
                                    !!}

                                </div>
                            </div>
                        </div>
                        <label for="contact-permanent">Records of Previous Organisation/s (if applicable):</label>
                        <div class="row">
                            <table class="table table-bordered" id="dynamicTable">
                                <tbody>
                                    <tr>
                                        <td width="400px">
                                            <div class="form-group"><input class="form-control"
                                                    name="organization_name[]" type="text" placeholder='Organization'>
                                            </div>
                                        </td>
                                        <td width="400px">
                                            <div class="form-group"><input class="form-control" name="last_position[]"
                                                    placeholder='Last Position' type="text">
                                            </div>
                                        </td>
                                        <td width="400px">
                                            <div class="form-group"><input class="form-control" name="year[]"
                                                    placeholder='Year' type="text">
                                            </div>
                                        </td>
                                        <td width="400px">
                                            <div class="form-group"><input class="form-control" name="month[]"
                                                    placeholder='Month' type="text">
                                            </div>
                                        </td>
                                        <td width="200px">
                                            <a href='#' class='btn btn-small btn-danger remove_employee'><i
                                                    class="fa fa-remove"></i></a>
                                            <a href='#'>
                                                <button class="btn btn-small btn-info add_employee ml-2"><i
                                                        class="fa fa-plus"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{trans('app.save')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

        </div>
        {{ Form::close() }}

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
                    url: "{{  url('/orgs/get/district/') }}/"+pradesh_id,

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
                    url: "{{  url('/orgs/get/municipality/') }}/"+district_id,

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
<script type="text/javascript">
    $(document).ready(function() {
        function getDisByEdu(){
            var education_option =  '<option value="">Select Education Level</option>';
            $('#education_level_id').prop('disabled', true);
            var flag = "";
            $.ajax({
                url: "{{  url('/orgs/get/educationLevel/') }}/"+education_type_id,

                type: "GET",
                dataType: "json",
                success: function (data) {
                    $.each(data, function (key, value) {
                        flag = (education_level_id == value.id) ? "selected='selected'" : "";
                        education_option += `<option value="${value.id}" ${flag}> ${value.level}</option>`;
                    });
                    var select_group = $('#education_level_id');
                    select_group.empty().append(education_option);
                    $('#education_level_id').prop('disabled', false);
                },
            });
        }

        $('#education_type_id').change(function () {
            education_type_id = $('#education_type_id').val();
            getDisByEdu();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
            function getDisByPradesh(){
                var district_option =  '<option value="">Select District</option>';
                $('#permanent_district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{  url('/orgs/get/district/') }}/"+permanent_pradesh_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            flag = (district_id == value.id) ? "selected='selected'" : "";
                            district_option += `<option value="${value.id}" ${flag}> ${value.nepali_name}</option>`;
                        });
                        var select_group = $('#permanent_district_id');
                        select_group.empty().append(district_option);
                        $('#permanent_district_id').prop('disabled', false);
                    },
                });
            }

            function getMuniByDis() {
                var muni_option = '<option value="">Select Municipality</option>';
                $('#permanent_municipality_id').prop('disabled', true);
                $.ajax({
                    url: "{{  url('/orgs/get/municipality/') }}/"+permanent_district_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            var is_selected = value.id == municipality_id ?  'selected="selected"' : "";
                            muni_option += `<option value="${value.id}" ${is_selected}>${value.muni_name}</option>`;
                        });
                        var select_group = $('#permanent_municipality_id');
                        select_group.empty().append(muni_option);
                        $('#permanent_municipality_id').prop('disabled', false);
                    },

                });
            }

            $('#permanent_pradesh_id').change(function () {
                permanent_pradesh_id = $('#permanent_pradesh_id').val();
                getDisByPradesh();
            });

            $('#permanent_district_id').change(function () {
                permanent_district_id = $('#permanent_district_id').val();
                getMuniByDis();
            });
        });
</script>
<script>
    $('#married').change(function(){
        var ans= $('#married').val();
        //alert(ans);
        if(ans=='married'){
               $('#maritial_status').show();
        }else{
            $('#maritial_status').hide();

        }
    })
</script>
<script>
    $('#unmarried').change(function(){
        var ans= $('#unmarried').val();
        if(ans=='unmarried'){
               $('#maritial_status').hide();
        }
    })
</script>
<script>
    $(document).ready(function () {
        $('body').on('click', '.add_employee', function () {
            var $this = $(this),
                $parentTR = $this.closest('tr');
            $parentTR.clone().insertAfter($parentTR).find('input').val('');
            return false;
        });
        $('body').on('click', '.remove_employee', function () {
            var parentTag = $(this).parent().get(0)
            var trs = parentTag.parentNode.parentNode.getElementsByTagName('tr')
            if (trs.length > 1) {
                $parentTR = $(this).closest('tr')
                $parentTR.remove()
            }
            return false
        });
    });
</script>
@endsection
