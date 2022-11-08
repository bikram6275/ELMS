<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Education Qualification</h3>
    </div>
    <div class="card-body">
        {!! Form::open(['method'=>'post',route('education_qualification.store'),'enctype'=>'multipart/form-data']) !!}

        <div class="form-group {{ ($errors->has('type'))?'has-error':'' }}">
            <label>Type: </label>
            {{Form::select('type',$educations,null,['style' => 'width:100%','class'=>'form-control select2','id'=>'designation_id','placeholder'=>
            'Select Type'])}}

{{--            {{Form::select('type',$educations->pluck('qualification','id'),Request::get('id'),['class'=>'form-control select2','id'=>'qualification_id','placeholder'=>--}}
{{--            'Select Type'])}}--}}
{{--            {!! $errors->first('type', '<span class="text-danger">:message</span>') !!}--}}
        </div>

        <div class="form-group {{ ($errors->has('name'))?'has-error':'' }}">
            <label>Name: </label>
            <div class="input-group mb-3">
                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name']) !!}
            </div>
            {!! $errors->first('name', '<span class="text-danger">:message</span>') !!}
        </div>

        <!-- /.form group -->
        <div class="card-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
        {!! Form::close() !!}


    </div>
    <!-- /.box-body -->
</div>
