@extends('backend.layouts.app')
@section('title')
    Employee Experience
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
                        <h1> Employee Experience</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Employee</a></li>
                            <li class="breadcrumb-item active">Exerience</li>
                            <li class="breadcrumb-item active"> Edit </li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i>  Employee Experience</strong></h3>
                                <a href="{{url('/orgs/employee/experience/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/orgs/employee/experience')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                            <div class="card-body">
                                {!! Form::model($edits, ['method'=>'put','route'=>['experience.update',$edits->id],'enctype'=>'multipart/form-data','file'=>true]) !!}
                                <div class="card card-default">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                    <label> Employee: </label>
                                                    {{Form::select('employee_id',$employees->pluck('employee_name','id'),Request::get('id'),
                                            ['class'=>'form-control ','id'=>'employee_id','placeholder'=>'Select Employee', 'readonly','disabled'])}}
                                                    {!! $errors->first('employee_id', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <div class="card card-default">

                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="primary">Experience In the Present Organisation	</span>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('present_org_year'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('present_org_year',null,['class'=>'form-control','placeholder'=>'Year','id'=>'present_org_year','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('present_org_year', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('present_org_month'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('present_org_month',null,['class'=>'form-control','placeholder'=>'Month','id'=>'present_org_month','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('present_org_month', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="primary">Experience In the same Occupation		</span>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('same_occu_year'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('same_occu_year',null,['class'=>'form-control','placeholder'=>'Year','id'=>'same_occu_year','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('same_occu_year', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('same_occu_month'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('same_occu_month',null,['class'=>'form-control','placeholder'=>'Month','id'=>'same_occu_month','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('same_occu_month', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="primary">Experience At Present Position			</span>

                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('present_pos_year'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('present_pos_year',null,['class'=>'form-control','placeholder'=>'Year','id'=>'present_pos_year','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('present_pos_year', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('present_pos_month'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('present_pos_month',null,['class'=>'form-control','placeholder'=>'Month','id'=>'present_pos_month','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('present_pos_month', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="primary">Experience In Other Organisation		</span>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('other_org_year'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('other_org_year',null,['class'=>'form-control','placeholder'=>'Year','id'=>'other_org_year','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('other_org_year', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('other_org_month'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('other_org_month',null,['class'=>'form-control','placeholder'=>'Month','id'=>'other_org_month','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('other_org_month', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <span class="primary">Total Experience</span>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('total_exp_year'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('total_exp_year',null,['class'=>'form-control','placeholder'=>'Year','id'=>'total_exp_year','required' => 'required']) !!}
                                                    </div>
                                                    {!! $errors->first('total_exp_year', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group {{ ($errors->has('total_exp_month'))?'has-error':'' }}">
                                                    <div class="input-group mb-2">
                                                        {!! Form::number('total_exp_month',null,['class'=>'form-control','placeholder'=>'Month','id'=>'total_exp_month','required' => 'required']) !!}

                                                    </div>
                                                    {!! $errors->first('total_exp_month', '<span class="text-danger">:message</span>') !!}
                                                </div>
                                            </div>

                                        </div>
                                        </div>




                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        {{trans('app.update')}}
                                    </button>
                                </div>
                                {{ Form::close() }}
                            </div>
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
