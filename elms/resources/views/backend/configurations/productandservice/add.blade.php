<div class="card card-default">
    <div class="card-header with-border">
        <h3 class="card-title">Add Product And Services</h3>
    </div>
    <div class="card-body">
        {!! Form::open(['method' => 'post', route('product_and_service.store'), 'enctype' => 'multipart/form-data']) !!}
        {{ csrf_field() }}
        <div class="table-responsive">
            <table class="table table-borderless" id="dynamic_field">
                <tr>
                    <td>
                        <div class="form-group {{ $errors->has('sub_sector_id') ? 'has-error' : '' }}">
                            <label>Sub Sector</label>
                            {{ Form::select('sub_sector_id', $sub_sectors->pluck('sector_name', 'id'), Request::get('id'), ['class' => 'form-control select2', 'id' => 'designation_id', 'placeholder' => 'Select Sub Sector', 'required' => 'true']) }}
                            {!! $errors->first('sub_sector_id', '<span class="text-danger">:message</span>') !!}
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
                        <div class="form-group {{ $errors->has('product_and_services_name') ? 'has-error' : '' }}">
                            {!! Form::text('product_and_services_name[]', null, ['class' => 'form-control name_list', 'placeholder' => 'Product Name', 'required' => 'true']) !!}
                            {!! $errors->first('product_and_services_name', '<span class="text-danger">:message</span>') !!}
                        </div>
                    </td>
                    <td><button type="button" name="add" id="add_more_product"
                            class="btn btn-success add_more_product"><i class="fas fa-plus"></i></button></td>
                </tr>
            </table>
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

@section('js')
    <script>
        var i = 1;
        $('.add_more_product').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '" class="dynamic-added"><td><input type="text" name="product_and_services_name[]" placeholder="Product Name" class="form-control name_list" required /></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove"><i class="fas fa-trash"></i></button></td></tr>');
        });

        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    </script>
@endsection
