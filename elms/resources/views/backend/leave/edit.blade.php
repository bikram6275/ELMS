<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">{{trans('app.edit')}} &nbsp;</h3>

    </div>
    <div class="card-body">

        {!! Form::model($edits,['method'=>'PUT','route'=>['leavetype.update',$edits->id]]) !!}


        <div class="form-group {{ ($errors->has('pradesh_name'))?'has-error':'' }}">
            <label>Leave Type
                <label class="text-danger"> *</label>
            </label>
            {!! Form::text('leave_type',null,['class'=>'form-control','placeholder' => 'Leave type']) !!}
            {!! $errors->first('leave_type', '<span class="text-danger">:message</span>') !!}
        </div>
        <!-- /.form group -->
        <div class="card-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary">{{trans('app.update')}}</button>
            </div>
            <!-- /.card-footer -->
        </div>
        {!! Form::close() !!}


    </div>
    <!-- /.card-body -->
</div>
