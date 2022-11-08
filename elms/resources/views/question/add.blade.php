@extends('backend.layouts.app')
@section('title')
    Questions
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Questions</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">{{ trans('app.dashboard') }}</a>
                            </li>
                            <li class="breadcrumb-item">Questions</li>
                            <li class="breadcrumb-item active">{{ trans('app.add') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('backend.message.flash')

            <div class="form">
                <div class="card card-default">
                    <div class="card-header with-border">
                        <h3 class="card-title">{{ trans('app.add') }}</h3>
                        <?php
                        $permission = helperPermissionLink(url('question/create'), url('question'));

                        $allowEdit = $permission['isEdit'];

                        $allowDelete = $permission['isDelete'];

                        $allowAdd = $permission['isAdd'];
                        ?>
                    </div>
                    <div class="card-body">
                        @if ($allowAdd)

                            {!! Form::open(['method' => 'post', 'url' => '/question', 'autocomplete' => 'off', 'role' => 'form']) !!}


                            <div class="row">
                                <div class="form-group col-md-4 {{ ($errors->has('qsn.parent_id'))?'has-error':'' }}">
                                    <label>Select Survey</label><label class="text-danger">*</label>
                                    {{Form::select('qsn[survey_id]',$survey->pluck('survey_name','id'),Request::get('survey_id'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'parent_id','placeholder'=>
                                    'Select Survey'])}}
                                    {!! $errors->first('qsn.survey_id', '<span class="text-danger">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4 {{ ($errors->has('qsn.parent_id'))?'has-error':'' }}">
                                    <label>Parent Question</label><label class="text-danger">*</label>
                                    {{Form::select('qsn[parent_id]',$parent_qsn->pluck('qsn_name','id'),Request::get('parent_id'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'parent_id','placeholder'=>
                                    'Select Parent Question'])}}
                                    {!! $errors->first('qsn.parent_id', '<span class="text-danger">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4 {{ $errors->has('qsn.qsn_number') ? 'has-error' : '' }}">
                                    <label>Question Number</label><label class="text-danger">*</label>
                                    {!! Form::text('qsn[qsn_number]', null, ['class' => 'form-control ', 'placeholder' => 'Question Number'])
                                    !!}
                                    {!! $errors->first('qsn.qsn_number', '<span class="text-danger">:message</span>') !!}
                                </div>

                                <div class="form-group col-md-12 {{ $errors->has('qsn.qsn_name') ? 'has-error' : '' }}">
                                    <label>Question Name</label><label class="text-danger">*</label>
                                    {!! Form::text('qsn[qsn_name]', null, ['class' => 'form-control ', 'placeholder' => 'Question Name'])
                                    !!}
                                    {!! $errors->first('qsn.qsn_name', '<span class="text-danger">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-12 {{ $errors->has('qsn.instruction') ? 'has-error' : '' }}">
                                    <label>Instruction (If Any)</label>
                                    {!! Form::text('qsn[instruction]', null, ['class' => 'form-control ', 'placeholder' => 'Instruction'])
                                    !!}
                                    {!! $errors->first('qsn.instruction', '<span class="text-danger">:message</span>') !!}
                                </div>
                                <div class="form-group col-md-4 {{ ($errors->has('qsn.ans_type'))?'has-error':'' }}">
                                    <label>Answer Type</label><label class="text-danger">*</label>
                                    {{Form::select('qsn[ans_type]',$ansTypes,Request::get('ans_type'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'ans_type','placeholder'=>
                                    'Select Answer Type'])}}
                                    {!! $errors->first('qsn.ans_type', '<span class="text-danger">:message</span>') !!}
                                </div>
                            </div>

                            <div class="row" style="display: none" id="optionTable">
                                <table class="table table-bordered" id="dynamicTable" >
                                    <thead>
                                        <tr>
                                            <th>Option Number</th>
                                            <th>Option Name</th>
                                            <th>Option Order</th>
                                            <th>Option Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if(Request::old('option')!=null)
                                            @foreach(Request::old('option') as $key => $value)
                                            <tr>
                                                <td>
                                                    {!! Form::text("option[$key][option_number]", null, ['class' => 'form-control ', 'placeholder' => 'Option Number'])!!}
                                                    {!! $errors->first("option.$key.option_number", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>
                                                    {!! Form::text("option[$key][option_name]", null, ['class' => 'form-control ', 'placeholder' => 'Option Name']) !!}
                                                   {!! $errors->first("option.$key.option_name", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>
                                                    {!! Form::number("option[$key][option_order]", null, ['class' => 'form-control ', 'placeholder' => 'Option Order','min'=>1]) !!}
                                                   {!! $errors->first("option.$key.option_order", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>  {{Form::select("option[$key][option_type]",$optionType,Request::get('option_type'),['class'=>'form-control select2','style'=>'width:100%;','id'=>"option_type_$key",'placeholder'=>
                                                    'Select Option Type'])}}
                                                   {!! $errors->first("option.$key.option_type", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td><button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button></td>

                                            </tr>

                                            @endforeach
                                            @else
                                            <tr>
                                                <td>
                                                    {!! Form::text('option[0][option_number]', null, ['class' => 'form-control ', 'placeholder' => 'Option Number'])!!}
                                                   {!! $errors->first("option.0.option_number", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('option[0][option_name]', null, ['class' => 'form-control ', 'placeholder' => 'Option Name']) !!}
                                                   {!! $errors->first("option.0.option_name", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>
                                                    {!! Form::number('option[0][option_order]', null, ['class' => 'form-control ', 'placeholder' => 'Option Order','min'=>1]) !!}
                                                   {!! $errors->first("option.0.option_order", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>  {{Form::select('option[0][option_type]',$optionType,Request::get('option_type'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'option_type_0','placeholder'=>
                                                    'Select Option Type'])}}
                                                   {!! $errors->first("option.0.option_type", '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td><button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button></td>

                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>


                                <div class="row">
                                    <div class="form-group col-md-10 {{ $errors->has('qsn.qsn_order') ? 'has-error' : '' }}">
                                        <label>Order</label><label class="text-danger">*</label>
                                        {!! Form::text('qsn[qsn_order]', null, ['class' => 'form-control ', 'placeholder' => 'Question Order'])
                                        !!}
                                        {!! $errors->first('qsn.qsn_order', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                    <div class="form-group col-md-4 {{ ($errors->has('qsn.qst_status'))?'has-error':'' }}">
                                        <label for="status">{{trans('app.status')}} </label><label class="text-danger">*</label><br>
                                        {{Form::radio('qsn[qst_status]', 'active',true,['class'=>'minimal-red'])}} {{trans('app.active')}} &nbsp;&nbsp;&nbsp;
                                        {{Form::radio('qsn[qst_status]', 'inactive',null,['class'=>'minimal-red'])}} {{trans('app.inactive')}}
                                    </div>
                                    <div class="form-group col-md-4 {{ ($errors->has('qsn.required'))?'has-error':'' }}">
                                        <label for="status">{{trans('app.required')}} </label><label class="text-danger">*</label><br>
                                        {{Form::radio('qsn[required]', 'yes',true,['class'=>'minimal-red'])}} Yes&nbsp;&nbsp;&nbsp;
                                        {{Form::radio('qsn[required]', 'no',null,['class'=>'minimal-red'])}} No
                                    </div>


                                 </div>
                            <!-- /.form group -->
                            <div class="card-footer ">
                                <div class="col-md-12">
                                    <a href="{{ url('/question') }}" class="btn btn-danger pull-right">Cancel</a>
                                    <button type="submit" class="btn btn-primary pull-right mx-3 ">Save</button>
                                </div>

                            </div>
                            {!! Form::close() !!}
                        @else
                            <div class="alert alert-info">
                                <i class="fa fa-check" aria-hidden="true"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                </button>
                                You Cannot access this module Please Contact your Super Admin user to access this.
                            </div>

                        @endif

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>

    <!-- /.content-wrapper -->
@endsection
@section('js')
<script>
      var row_count = 0;
        $('#add1').click(function() {
            console.log('click event');
            ++row_count;
            $("#dynamicTable").append(` <tr>
                                                <td>
                                                    {!! Form::text('option[${row_count}][option_number]', null, ['class' => 'form-control ', 'placeholder' => 'Option Number'])!!}
                                                    {!! $errors->first('option.${row_count}.option_number', '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('option[${row_count}][option_name]', null, ['class' => 'form-control ', 'placeholder' => 'Option Name']) !!}
                                                 {!! $errors->first('option.${row_count}.option_name', '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>
                                                    {!! Form::number('option[${row_count}][option_order]', null, ['class' => 'form-control ', 'placeholder' => 'Option Order','min'=>1]) !!}
                                                 {!! $errors->first('option.${row_count}.option_order', '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td>  {{Form::select('option[${row_count}][option_type]',$optionType,Request::get('option_type'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'option_type_${row_count}','placeholder'=>
                                                    'Select Option Type'])}}
                                                 {!! $errors->first('option.${row_count}.option_type', '<span class="text-danger">:message</span>') !!}
                                                </td>
                                                <td><button type="button" class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button></td></tr>`);
        $('.select2').select2();
        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
</script>
<script>
    $('#ans_type').change(function(){
        var ans= $('#ans_type').val();
        if(ans=='radio' || ans=='checkbox' || ans=='multiple_input' || ans=='cond_radio' || ans=='range'){
               $('#optionTable').show();
        }else{
            $('#optionTable').hide();

        }
    })
</script>
@endsection

