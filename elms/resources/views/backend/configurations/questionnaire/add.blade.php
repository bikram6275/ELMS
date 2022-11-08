<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">{{trans('app.add')}}&nbsp;</h3>

    </div>
    <div class="card-body">
    {!! Form::open(['method'=>'post','url'=>'configurations/questionnaire', 'enctype' => 'multipart/form-data']) !!}


        <div class="form-group {{ ($errors->has('file'))?'has-error':'' }}">
            <label>{{trans('app.file')}}
                <label class="text-danger"> *</label>
            </label>
            <input type="file" name="file" class="form-control">
            {!! $errors->first('file', '<span class="text-danger">:message</span>') !!}

        </div>

        <!-- /.form group -->
        <div class="card-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary">{{trans('app.save')}}&nbsp;</button>
            </div>
            <!-- /.card-footer -->

        </div>
        {!! Form::close() !!}

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

