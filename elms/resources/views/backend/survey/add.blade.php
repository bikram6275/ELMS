<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Add Survey</h3>
    </div>
    <div class="card-body">
        {!! Form::open(['method'=>'post',route('survey.store'),'enctype'=>'multipart/form-data']) !!}

        <div class="form-group {{ ($errors->has('survey_name'))?'has-error':'' }}">
            <label>Survey Name: </label>
            <div class="input-group mb-3">
                {!! Form::text('survey_name',null,['class'=>'form-control','placeholder'=>'Survey Name']) !!}
            </div>
            {!! $errors->first('survey_name', '<span class="text-danger">:message</span>') !!}

        </div>
{{--        <div class="form-group {{ ($errors->has('org_id'))?'has-error':'' }}">--}}
{{--            <label>Organization: </label>--}}
{{--            {{Form::select('org_id',$organizations->pluck('org_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'organization_id','placeholder'=>--}}
{{--            'Select Organization'])}}--}}
{{--            {!! $errors->first('org_id', '<span class="text-danger">:message</span>') !!}--}}
{{--        </div>--}}

        <div class="form-group {{ ($errors->has('fy_id'))?'has-error':'' }}">
            <label>Fiscal Year: </label>
            {{Form::select('fy_id',$fiscalyears->pluck('fy_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'fy_id','placeholder'=>
            'Fiscal Year'])}}
            {!! $errors->first('fy_id', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('survey_year'))?'has-error':'' }}">
            <label>Survey Year: </label>
            <div class="input-group mb-3">
                {!! Form::text('survey_year',null,['class'=>'form-control','placeholder'=>'Survey Year']) !!}
            </div>
            {!! $errors->first('survey_year', '<span class="text-danger">:message</span>') !!}

        </div>

        <div class="form-group {{ ($errors->has('detail'))?'has-error':'' }}">
            <label for="user_status">Details: </label><br>
            <div class="input-group mb-3">
                {!! Form::textarea ('detail',null,['class'=>'form-control']) !!}
            </div>
            {!! $errors->first('detail', '<span class="text-danger">:message</span>') !!}

        </div>
        <div class="form-group {{ ($errors->has('start_date'))?'has-error':'' }}">
            <label>Start Date: </label>
            <div class="input-group mb-3">
                {!! Form::date('start_date',null,['class'=>'form-control','placeholder'=>'Start Date']) !!}
            </div>
            {!! $errors->first('start_date', '<span class="text-danger">:message</span>') !!}

        </div>
        <div class="form-group {{ ($errors->has('end_date'))?'has-error':'' }}">
            <label>End Date: </label>
            <div class="input-group mb-3">
                {!! Form::date('end_date',null,['class'=>'form-control','placeholder'=>'End Date']) !!}
            </div>
            {!! $errors->first('end_date', '<span class="text-danger">:message</span>') !!}

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
