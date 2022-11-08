@extends('backend.layouts.app')
@section('title')
    Employee Trainings
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Trainings</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Training</li>
                            <li class="breadcrumb-item active">Add</li>
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
                            <h3 class="card-title"><strong><i class="fa fa-list"></i>Employee Trainings</strong></h3>
                            <a href="{{url('/orgs/employee/training/create')}}" class="pull-right cardTopButton"
                               id="add"
                               data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x"
                                                                        style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/training')}}" class="pull-right cardTopButton"
                               data-toggle="tooltip" title="View All"><i class="fa fa-list fa-2x"
                                                                         style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>

                        <div class="card-body">
                            @if(!count($employees)<=0)
                                {!! Form::open(['method'=>
                                'post','url'=>'/orgs/employee/training','enctype'=>'multipart/form-data','file'=>true]) !!}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div
                                                                class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                                <label>Employee: </label>
                                                                {{Form::select('employee_id',$employees->pluck('employee_name','id'),Request::get('id'),['class'=>'form-control
                                                                select2','id'=>'employee_id','name'=>'employee_id','placeholder'=>
                                                                'Select Employee'])}}
                                                                {!! $errors->first('employee_id', '<span
                                                                    class="text-danger">:message</span>') !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <table class="table table-responsive" id="dynamicTable">
                                                        <thead>
                                                        <tr>
                                                            <th>Training Type</th>
                                                            <th>Pre-Service Training Duration</th>
                                                            <th>In-service Training Duration</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody class="add_item">
                                                        <tr>
                                                            <td>
                                                                <div class="row">
                                                                    <div
                                                                        class="form-group {{ ($errors->has('training_type'))?'has-error':'' }}">
                                                                        <div class="input-group mb-6">
                                                                            {!!
                                                                                Form::select('training_type[]',$trainings,null,['class'=>'form-control training_type','placeholder'=>'Training Type','id'=>'training_type-2','required'
                                                                                => 'required','onchange' => 'addOthers(this)']) !!}
                                                                        </div>
                                                                        {!! $errors->first('training_type', '<span
                                                                            class="text-danger">:message</span>') !!}
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div id="addTable-2" style="display: none">
                                                                        <div
                                                                            class="form-group  {{ ($errors->has('others'))?'has-error':'' }}">
                                                                            <div class="input-group mb-6">
                                                                                {!! Form::text('others[]',null,['class'=>'form-control training_type','placeholder'=>'others']) !!}
                                                                            </div>
                                                                            {!! $errors->first('others', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div id="addOthers-2">

                                                                </div>

                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div
                                                                            class="form-group {{ ($errors->has('pre_service_yr'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('pre_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'pre_service_yr','required'
                                                                                => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('pre_service_yr', '<span
                                                                                class="text-danger">:message</span>')
                                                                            !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div
                                                                            class="form-group {{ ($errors->has('pre_service_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('pre_service_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'pre_service_month','required'
                                                                                => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('pre_service_month',
                                                                            '<span class="text-danger">:message</span>')
                                                                            !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div
                                                                            class="form-group {{ ($errors->has('in_service_yr'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('in_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'in_service_yr','required'
                                                                                => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('in_service_yr', '<span
                                                                                class="text-danger">:message</span>')
                                                                            !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div
                                                                            class="form-group {{ ($errors->has('in_service_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('in_service_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'in_service_month','required'
                                                                                => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('in_service_month',
                                                                            '<span class="text-danger">:message</span>')
                                                                            !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-2" style="">
                                                                        <span class="btn btn-success"
                                                                              id="addeventmore"><i
                                                                                class="fa fa-plus-circle"></i></span>
                                                                    </div>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{trans('app.save')}}
                        </button>
                    </div>

                    {{ Form::close() }}
                </div>
                @else
                    <div class="col-md-12">
                        <label class="form-control label-danger">Please Add Employ Record First </label>
                    </div>
                @endif
            </div>

        </section>
    </div>

@endsection

@section('js')
    <script>
        function addOthers(s) {
            var rowCount = $('#addTable tr').length;
            var ans = s.value;
            var id = s.id.split("-")[1];
            if (ans == 'others') {

                $('#addTable-' + id).show();
            } else {
                $('#addTable-' + id).hide();
            }
        }

    </script>
    <script>
        var row_count = 0;
        $('#addeventmore').click(function () {
            var row = $('#dynamicTable tr').length + 1;

            $("#dynamicTable").append(` <tr>
                <td
                                                                <div class="row">
                                                                    <div
                                                                        class="form-group {{ ($errors->has('training_type'))?'has-error':'' }}">
                                                                       <div class="input-group mb-6">
                                                                            {{Form::select('training_type[]',$trainings,null,['class'=>'form-control
                                                                            training_type','id'=>'training_type-${row}','placeholder'=>
                                                                            'Training Type','onchange' => 'addOthers(this)'])}}
            </div>
{!! $errors->first('training_type', '<span class="text-danger">:message</span>') !!}
            </div>
            <div class="col-md-6">
                    <div  id='addTable-${row}' style="display: none" >
                                                                                <div class="form-group  {{ ($errors->has('others'))?'has-error':'' }}">
                                                                                    <div class="input-group mb-6">
                                                                                        {!! Form::text('others[]',null,['class'=>'form-control training_type','placeholder'=>'others']) !!}
            </div>
{!! $errors->first('others', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
</div>
</div>

</td>
<td>
<div class="row">
<div class="col-md-6">
<div
    class="form-group {{ ($errors->has('pre_service_yr'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('pre_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'pre_service_yr','required'
                                                                                => 'required']) !!}
            </div>
{!! $errors->first('pre_service_yr', '<span
                                                                                class="text-danger">:message</span>')
                                                                            !!}
            </div>
        </div>
        <div class="col-md-6">
            <div
                class="form-group {{ ($errors->has('pre_service_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('pre_service_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'pre_service_month','required'
                                                                                => 'required']) !!}
            </div>
{!! $errors->first('pre_service_month',
                                                                            '<span class="text-danger">:message</span>')
                                                                            !!}
            </div>
        </div>
    </div>
</td>
<td>
    <div class="row">
        <div class="col-md-6">
            <div
                class="form-group {{ ($errors->has('in_service_yr'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('in_service_yr[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'in_service_yr','required'
                                                                                => 'required']) !!}
            </div>
{!! $errors->first('in_service_yr', '<span
                                                                                class="text-danger">:message</span>')
                                                                            !!}
            </div>
        </div>
        <div class="col-md-6">
            <div
                class="form-group {{ ($errors->has('in_service_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!!
                                                                                Form::number('in_service_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'in_service_month','required'
                                                                                => 'required']) !!}
            </div>
{!! $errors->first('in_service_month',
                                                                            '<span class="text-danger">:message</span>')
                                                                            !!}
            </div>
        </div>
    </div>
</td>
<td><button type="button" class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button></td></tr>`);
            $('.select2').select2();
        });
        $(document).on('click', '.remove-tr', function () {
            $(this).parents('tr').remove();
        });
    </script>
@endsection
