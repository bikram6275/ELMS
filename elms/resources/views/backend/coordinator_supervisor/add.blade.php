<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Map Coordinator Supervisor</h3>

    </div>
    <div class="card-body">

        {!! Form::open(['method' => 'post', 'url' => 'coordinator_supervisor', 'enctype' => 'multipart/form-data']) !!}

        <div class="form-group {{ $errors->has('coordinator_id') ? 'has-error' : '' }}">
            <label>Coordinator</label>
            {{ Form::select('coordinator_id', $coordinators->pluck('name', 'id'), Request::get('coordinator_id'), [
                'class' => 'form-control select2',
                'id' => 'coordinator_id',
                'placeholder' => 'Select Coordinator Name',
            ]) }}
            {!! $errors->first('coordinator_id', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ $errors->has('supervisor_id') ? 'has-error' : '' }}">
            <label>Supervisor</label>
            {{ Form::select('supervisor_id', $supervisors->pluck('name', 'id'), Request::get('supervisor_id'), [
                'class' => 'form-control select2',
                'id' => 'supervisor_id',
                'placeholder' => 'Select Supervisor',
            ]) }}
            {!! $errors->first('supervisor_id', '<span class="text-danger">:message</span>') !!}
        </div>
        <div class="form-group {{ $errors->has('survey_id') ? 'has-error' : '' }}">
            <label>Survey</label>
            {{ Form::select('survey_id', $surveys->pluck('survey_name', 'id'), Request::get('survey_id'), [
                'class' => 'form-control select2',
                'id' => 'survey_id',
                'placeholder' => 'Select Survey',
            ]) }}
            {!! $errors->first('survey_id', '<span class="text-danger">:message</span>') !!}
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
