@extends('backend.layouts.app')
@section('title')
    Employee Punishment
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Punishment</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Employee Punishment</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            {!!Form::open(['method'=>'post','url'=>'/orgs/employee/punishment','enctype'=>'multipart/form-data'])!!}
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">

                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Employee Punishment</h3>
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
                        <div class="card-body">
                            <div class="card card-default">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div
                                                            class="form-group {{ ($errors->has('employee_id'))?'has-error':'' }}">
                                                            <label>Employee: </label>
                                                            {{Form::select('employee_id',$employees->pluck('employee_name','id'),Request::get('id'),['class'=>'form-control
                                                            select2','id'=>'employee_id','name'=>'ids','placeholder'=>
                                                            'Select Employee'])}}
                                                            {!! $errors->first('employee_id', '<span
                                                                class="text-danger">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div
                                                            class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
                                                            <label>Select Year: </label>
                                                            {{Form::select('year',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
                                                            'Select Year' , 'required' => 'required'])}}
                                                            {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
                                                        </div>
                                                    </div>
                                                </div>

                                                <table class="table table-responsive" id="dynamicTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Number of Defense Letter Received</th>
                                                        <th>Grade deduction Records</th>
                                                        <th>De promoted Records</th>
                                                        <th>Upload Document</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody class="add_item">
                                                    <tr>

                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group {{ ($errors->has('defence_letter_received'))?'has-error':'' }}">
                                                                        <div class="input-group mb-12">
                                                                            {!!
                                                                            Form::number('defence_letter_received[]',null,['class'=>'form-control','placeholder'=>'Defence Letter Received','id'=>'defence_letter_received','required'
                                                                            => 'required']) !!}
                                                                        </div>
                                                                        {!! $errors->first('defence_letter_received', '<span
                                                                            class="text-danger">:message</span>')
                                                                        !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group{{ $errors->has('grade_deducted') ? ' has-error' : '' }}">
                                                                        <select class="form-control"
                                                                                name="grade_deducted[]"
                                                                                id="grade_deducted">
                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>
                                                                        </select>
                                                                        {!! $errors->first('grade_deducted', '<span class="text-danger">:message</span>') !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group{{ $errors->has('de_promoted') ? ' has-error' : '' }}">
                                                                        <select class="form-control"
                                                                                name="de_promoted[]"
                                                                                id="de_promoted">
                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>
                                                                        </select>
                                                                        {!! $errors->first('de_promoted', '<span class="text-danger">:message</span>') !!}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group {{ ($errors->has('punishment_img'))?'has-error':'' }}">
                                                                        <input type="file" class="form-control"
                                                                               name="punishment_img[]"
                                                                               id="punishment_img"
                                                                               placeholder="Choose File" multiple>
                                                                        {!! $errors->first('punishment_img', '<span class="text-danger">:message</span>') !!}
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
                        </div>

                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </section>
    </div>


@endsection
@section('js')
    <script>
        $("#sub-btn").click(function (e) {
            var punishmentimage = document.getElementById("punishment_img");
            let size = punishmentimage.files[0].size;
            if (size > 2000000) {
                alert("Document Size is exceeding 2 Mb");
                event.preventDefault();
            }
        });
    </script>
    <script>
        var row_count = 0;
        $('#addeventmore').click(function () {
            var row = $('#dynamicTable tr').length + 1;

            $("#dynamicTable").append(`
            <tr>

                                                        <td>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div
                                                                        class="form-group {{ ($errors->has('defence_letter_received'))?'has-error':'' }}">
                                                                        <div class="input-group mb-12">
                                                                            {!!
                                                                            Form::number('defence_letter_received[]',null,['class'=>'form-control','placeholder'=>'Defence Letter Received','id'=>'defence_letter_received','required'
                                                                            => 'required']) !!}
            </div>
{!! $errors->first('defence_letter_received', '<span
                                                                            class="text-danger">:message</span>')
                                                                        !!}
            </div>
        </div>
    </div>
</td>
<td>
    <div class="row">
        <div class="col-md-12">
            <div
                class="form-group{{ $errors->has('grade_deducted') ? ' has-error' : '' }}">
                                                                        <select class="form-control"
                                                                                name="grade_deducted[]"
                                                                                id="grade_deducted">
                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>
                                                                        </select>
                                                                        {!! $errors->first('grade_deducted', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
    </div>
</td>
<td>
    <div class="row">
        <div class="col-md-12">
            <div
                class="form-group{{ $errors->has('de_promoted') ? ' has-error' : '' }}">
                                                                        <select class="form-control"
                                                                                name="de_promoted[]"
                                                                                id="de_promoted">
                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>
                                                                        </select>
                                                                        {!! $errors->first('de_promoted', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
    </div>
</td>
<td>
    <div class="row">
        <div class="col-md-12">
            <div
                class="form-group {{ ($errors->has('punishment_img'))?'has-error':'' }}">
                                                                        <input type="file" class="form-control"
                                                                               name="punishment_img[]"
                                                                               id="punishment_img"
                                                                               placeholder="Choose File" multiple>
                                                                        {!! $errors->first('punishment_img', '<span class="text-danger">:message</span>') !!}
            </div>
        </div>
    </div>
</td>
<td><button type="button" class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button></td>
</tr>
`);
            $('.select2').select2();
        });
        $(document).on('click', '.remove-tr', function () {
            $(this).parents('tr').remove();
        });
    </script>
@endsection


