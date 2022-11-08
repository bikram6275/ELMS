@extends('backend.layouts.app')
@section('title')
    Employee Experience
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Employee Experience</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Employee</li>
                            <li class="breadcrumb-item active">Experience</li>
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
                            <h3 class="card-title"><strong><i class="fa fa-list"></i> Employee Experience</strong></h3>
                            <a href="{{url('/orgs/employee/experience/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{url('/orgs/employee/experience')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                        </div>

                        <div class="card-body">
                            @if(!count($employees)<=0)

                            {!! Form::open(['method'=>'post','url'=>'/orgs/employee/experience','enctype'=>'multipart/form-data','file'=>true]) !!}


                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                                <table class="table table-responsive">
                                                    <thead>
                                                    <tr>
                                                        <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                        <th>Employee</th>
                                                        <th>In the Present Organisation</th>
                                                        <th>In the same Occupation </th>
                                                        <th>At Present Position </th>
                                                        <th>In Other Organisation </th>
                                                        <th>Total Experience</th>
                                                    </tr>
                                                    </thead>
                                                    <?php $i = 1; ?>
                                                    <tbody>
                                                    @foreach($employees as $key=>$employee)
                                                        <tr>
                                                            <input type="hidden" name="ids[]" value="{{ $employee->id }}">
                                                            <th scope=row>{{$i}}</th>
                                                            <td>{{$employee->employee_name??null}}</td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('present_org_year'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('present_org_year[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'present_org_year','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('present_org_year', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group {{ ($errors->has('present_org_month'))?'has-error':'' }}">
                                                                                <div class="input-group mb-12">
                                                                                    {!! Form::number('present_org_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'present_org_month','required' => 'required']) !!}
                                                                                </div>
                                                                                {!! $errors->first('present_org_month', '<span class="text-danger">:message</span>') !!}
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                            </td>


                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('same_occu_year'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('same_occu_year[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'same_occu_year','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('same_occu_year', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('same_occu_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('same_occu_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'same_occu_month','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('same_occu_month', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('present_pos_year'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('present_pos_year[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'present_pos_year','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('present_pos_year', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('present_pos_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('present_pos_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'present_pos_month','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('present_pos_month', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('other_org_year'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('other_org_year[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'other_org_year','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('other_org_year', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('other_org_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('other_org_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'other_org_month','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('other_org_month', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('total_exp_year'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('total_exp_year[]',null,['class'=>'form-control','placeholder'=>'Year','id'=>'total_exp_year','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('total_exp_year', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group {{ ($errors->has('total_exp_month'))?'has-error':'' }}">
                                                                            <div class="input-group mb-12">
                                                                                {!! Form::number('total_exp_month[]',null,['class'=>'form-control','placeholder'=>'Month','id'=>'total_exp_month','required' => 'required']) !!}
                                                                            </div>
                                                                            {!! $errors->first('total_exp_month', '<span class="text-danger">:message</span>') !!}
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $i++; ?>
                                                    @endforeach
                                                    </tbody>

                                                </table>
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
                        </div>
                    </div>
        </section>

    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on("click",".addeventmore",function(){

                var whole_extra_item_add=$('#whole_extra_item_add').html();
                $(this).closest(".add_item").append(whole_extra_item_add);
                counter++;
            });
            $(document).on("click",".removeeventmore",function(event){
                $(this).closest(".delete_whole_extra_item_add").remove();
                counter-=1
            });

        });


    </script>

@endsection
