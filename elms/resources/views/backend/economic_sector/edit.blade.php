<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">{{trans('app.edit')}} &nbsp;</h3>

    </div>
    <div class="card-body">

    {!! Form::model($edits,['method'=>'PUT','route'=>['economic_sector.update',$edits->id],'files'=>true]) !!}

        <div class="form-group {{ ($errors->has('parent_id'))?'has-error':'' }}">
            <label>Parent</label>
            {{Form::select('parent_id',$parents->pluck('sector_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'designation_id','placeholder'=>
            'Select Parent'])}}
            {!! $errors->first('parent_id', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('sector_name'))?'has-error':'' }}">
            <label>Sector Name: </label>
            <div class="input-group mb-3">
                {!! Form::text('sector_name',null,['class'=>'form-control','placeholder'=>'Sector Name']) !!}
            </div>
            {!! $errors->first('sector_name', '<span class="text-danger">:message</span>') !!}

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

