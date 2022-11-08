<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Edit Menu</h3>

    </div>
    <div class="card-body">

    {!! Form::model($edits,['method'=>'PUT','route'=>['menu.update',$edits->id]]) !!}

        <div class="form-group {{ ($errors->has('parent_id'))?'has-error':'' }}">
            <label>Parent Menu</label>
            {{Form::select('parent_id',$parentList->pluck('menu_name','id'),Request::get('parent_id'),['class'=>'form-control select2','style'=>'width:100%;','id'=>'state_id','placeholder'=>
            'Select Parent Name'])}}
            {!! $errors->first('state_id', '<span class="text-danger">:message</span>') !!}

        </div>
        <div class="form-group {{ ($errors->has('menu_name'))?'has-error':'' }} ">
            <label for="menu_name">Name
                <label class="text-danger"> *</label>
            </label>
            {!! Form::text('menu_name',null,['class'=>'form-control','placeholder'=>'Enter Menu Name']) !!}
            {!! $errors->first('menu_name', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('menu_controller'))?'has-error':'' }} ">
            <label for="menu_controller">Controller
                <label class="text-danger"> *</label>
            </label>
            {!! Form::text('menu_controller',null,['class'=>'form-control','placeholder'=>'Enter Menu Controller']) !!}
            {!! $errors->first('menu_controller', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('menu_link'))?'has-error':'' }}">
            <label for="menu_link">Link
                <label class="text-danger"> *</label>
            </label>
            {!! Form::text('menu_link',null,['class'=>'form-control','placeholder'=>'Enter Menu Link']) !!}
            {!! $errors->first('menu_link', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('menu_css'))?'has-error':'' }}">
            <label for="menu_css">CSS</label>
            {!! Form::text('menu_css',null,['class'=>'form-control','placeholder'=>'Enter Menu CSS']) !!}
            {!! $errors->first('menu_css', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('menu_icon'))?'has-error':'' }}">
            <label for="menu_icon">Icon
                <label class="text-danger"> *</label>
            </label>
            {!! Form::text('menu_icon',null,['class'=>'form-control','placeholder'=>'Enter Menu Icon']) !!}
            {!! $errors->first('menu_icon', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('menu_status'))?'has-error':'' }}">
            <label for="menu_status">Status
                <label class="text-danger"> *</label>
            </label><br>
            {{--<label for="item_type" class="control-label align">Item Type<label class="text-danger"> *</label></label><br>--}}
            {{Form::radio('menu_status', '1','true',['class'=>'flat-red'])}}&nbsp;&nbsp;Active &nbsp;&nbsp;&nbsp;
            {{Form::radio('menu_status', '0',null,['class'=>'flat-red'])}}&nbsp;&nbsp;Inactive
            {!! $errors->first('menu_status', '<span class="text-danger">:message</span>') !!}
        </div>

        <div class="form-group {{ ($errors->has('menu_order'))?'has-error':'' }}">
            <label for="menu_order">Order
                <label class="text-danger"> *</label>
            </label>
            {!! Form::number('menu_order',null,['class'=>'form-control','placeholder'=>'Enter Menu Order']) !!}
            {!! $errors->first('menu_order', '<span class="text-danger">:message</span>') !!}
        </div>

        <!-- /.form group -->
        <div class="card-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-primary pull-right">Save</button>


            </div>
            <!-- /.card-footer -->

        </div>
        {!! Form::close() !!}


    </div>
    <!-- /.card-body -->
</div>