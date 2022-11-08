<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Add Product And Services</h3>
    </div>
    <div class="card-body">
        {!! Form::open(['method' => 'PUT', 'route'=>['product_and_service.update',$edits->id] ,'enctype' => 'multipart/form-data']) !!}
        {{ csrf_field() }}
        <div class="table-responsive">
            <table class="table table-borderless" id="dynamic_field">
                <tr>
                    <td>
                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                            <label>Sub Sector</label>
                            {{ Form::select('sub_sector_id', $sub_sectors->pluck('sector_name', 'id'), $edits->sub_sector_id, ['class' => 'form-control select2', 'id' => 'designation_id', 'placeholder' => 'Select Sub Sector']) }}
                            {!! $errors->first('parent_id', '<span class="text-danger">:message</span>') !!}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Product and Services</label>

                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                            {!! Form::text('product_and_services_name', $edits->product_and_services_name, ['class' => 'form-control name_list', 'placeholder' => 'Product Name']) !!}
                            {!! $errors->first('product_and_services_name', '<span class="text-danger">:message</span>') !!}
                        </div>
                    <td>
                   
                </tr>
            </table>
        </div>

        <!-- /.form group -->
        <div class="card-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <button type="submit"  class="btn btn-primary">Update</button>
            </div>
        </div>
        {!! Form::close() !!}


    </div>
    <!-- /.box-body -->
</div>


