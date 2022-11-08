<div class="modal fade" id="respondent_{{ $data->pivot_id }}">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Respondent’s Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post', 'url' => '/emitters/repondent_information', 'autocomplete' => 'off', 'role' => 'form']) !!}

                <div class="row ">
                    <input type="hidden" value="{{ $data->pivot_id }}" name="id">
                    <div class="form-group col-md-12 ">
                        <label>Name</label> <br>
                        {!! Form::text('respondent_name', null, ['class' => 'form-control', 'required']) !!}
                    </div>
                    <div class="form-group col-md-12 ">
                        <label>Designation</label> <br>
                        {!! Form::text('designation', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-md-12 ">
                        <label>Interview Date</label> <br>
                        {!! Form::date('interview_date', null, ['class' => 'form-control', 'required']) !!}
                    </div>

                </div>
            </div>
            <!-- /.form group -->

            <div class="modal-footer  pull-right">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-body -->
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
