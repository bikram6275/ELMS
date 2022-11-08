<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Edit </h3>

    </div>
    <div class="card-body">
        {!! Form::model($edits,['method'=>'PUT','route'=>['district.update',$edits->id],'enctype'=>'multipart/form-data']) !!}
        <div class="form-group {{ ($errors->has('pradesh_id'))?'has-error':'' }}">
            <label>Pradesh Name</label><label class="text-danger">*</label>
            {{Form::select('pradesh_id',$pradesh->pluck('pradesh_name','id'),Request::get('pradesh_id'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'pradesh_id','placeholder'=>
            'Select Pradesh Name'])}}
            {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('district_code'))?'has-error':'' }}">
            <label>{{trans('app.division')}} {{trans('app.name')}}
                <label class="text-danger"> *</label>
            </label>
        {!! Form::text('district_code',null,['class'=>'form-control','placeholder' => 'Example:001']) !!}
        {!! $errors->first('district_code', '<span class="text-danger">:message</span>') !!}

        <!-- /.input group -->
        </div>

        <div class="form-group {{ ($errors->has('nepali_name'))?'has-error':'' }}">
            <label>Nepali Name
            </label>
        {!! Form::text('nepali_name',null,['class'=>'form-control','placeholder' => 'Example:काठमाण्डौ']) !!}
        {!! $errors->first('nepali_name', '<span class="text-danger">:message</span>') !!}

        <!-- /.input group -->
        </div>

        <div class="form-group {{ ($errors->has('english_name'))?'has-error':'' }}">
            <label>English Name
                <label class="text-danger"> *</label>
            </label>
        {!! Form::text('english_name',null,['class'=>'form-control','placeholder' => 'Example:Kathmandu']) !!}
        {!! $errors->first('english_name', '<span class="text-danger">:message</span>') !!}

        <!-- /.input group -->
        </div>

        <!-- /.form group -->
        <div class="card-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary">Update</button>
                {{--<button type="submit" class="btn btn-default bg-green">Save & Add New</button>--}}

            </div>
            <!-- /.card-footer -->

        </div>
        {!! Form::close() !!}


    </div>
    <!-- /.card-body -->
</div>