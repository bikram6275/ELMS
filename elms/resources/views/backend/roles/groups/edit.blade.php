<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Edit Group</h3>

    </div>
    <div class="card-body">

    {!! Form::model($edits,['method'=>'PUT','route'=>['group.update',$edits->id]]) !!}

        <div class="form-group {{ ($errors->has('group_name'))?'has-error':'' }}">
            <label for="group_name">Name</label>
            {!! Form::text('group_name',null,['class'=>'form-control','placeholder'=>'Enter Group Name']) !!}
            {!! $errors->first('group_name', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('group_details'))?'has-error':'' }}">
            <label for="group_details">Details</label>
            {!! Form::textarea('group_details',null,['class'=>'form-control','placeholder'=>'Enter Menu Controller']) !!}
            {!! $errors->first('group_details', '<span class="text-danger">:message</span>') !!}
        </div>

        <!-- /.form group -->
        <div class="card-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary">Update</button>


            </div>
            <!-- /.card-footer -->

        </div>
        {!! Form::close() !!}


    </div>
    <!-- /.card-body -->
</div>