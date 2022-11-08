<table class="table table-bordered" id="occupationTable">
    <thead>
        <tr>
            <th>Name of Occupations </th>
            <th>Present demand </th>
            <th>Estimated demand for next two years </th>
            <th>Estimated demand for next five years</th>
            <th>Action</th>
        </tr>

    </thead>
    <tbody>
        @if(Request::old('occu')!=null)
        @foreach (Request::old('occu') as $key => $value)
        <tr>
            {!! Form::hidden("occu[$key][id]", isset($value['id'])?$value['id']:0, ['class' => 'form-control ','style'=>'width:100%;']) !!}

            <td>{!! Form::select("occu[$key][occupation_id]", $occupations->pluck('occupation_name', 'id'), $value['occupation_id'], ['class' => 'form-control  select2 occ-required', 'style' => 'width:100%;', 'id' => "occupation_$key", 'placeholder' => 'Select Occupation','onChange' => 'otherOccupation(this)']) !!}
                {!! $errors->first("occu.$key.occupation_id", '<span class="text-danger">:message</span>') !!}
                @if ($value->other_value != null)
                {!! Form::text("technical[$key][other_value]", $value->other_value, ['class' => "form-control mt-2 other_$key", 'placeholder' => 'Enter Other Occupation']) !!}
                @endif
            </td>
            <td>{!! Form::number("occu[$key][present_demand]", $value['present_demand'], ['class' => 'form-control .occ-required', 'min' => 0]) !!}
                {!! $errors->first("occu.$key.present_demand", '<span class="text-danger">:message</span>') !!}
            </td>
            <td>{!! Form::number("occu[$key][demand_two_year]", $value['demand_two_year'], ['class' => 'form-control .occ-required', 'min' => 0]) !!}
                {!! $errors->first("occu.$key.demand_two_year", '<span class="text-danger">:message</span>') !!}
            </td>
            <td>{!! Form::number("occu[$key][demand_five_year]", $value['demand_five_year'], ['class' => 'form-control .occ-required', 'min' => 0]) !!}
                {!! $errors->first("occu.$key.demand_five_year", '<span class="text-danger">:message</span>') !!}
            </td>
            <td>
                @if ($loop->first)
                    <button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i
                            class="fas fa-plus"></i></button>
                @else
               <button type="button" class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button>


                @endif
            </td>

        </tr>

    @endforeach
        @elseif ($other_answer != null && count($other_answer) > 0)
            @foreach ($other_answer as $key => $value)
                <tr>
                    {!! Form::hidden("occu[$key][id]", $value->id, ['class' => 'form-control ']) !!}

                    <td>{!! Form::select("occu[$key][occupation_id]", $occupations->pluck('occupation_name', 'id'), $value->occupation_id, ['class' => 'form-control  select2 occ-required', 'style' => 'width:100%;', 'id' => "occupation_$key", 'placeholder' => 'Select Occupation','onChange' => 'otherOccupation(this)']) !!}
                        {!! $errors->first("occu.$key.occupation_id", '<span class="text-danger">:message</span>') !!}
                        @if ($value->other_value != null)
                        {!! Form::text("occu[$key][other_value]", $value->other_value, ['class' => "form-control mt-2 other_occupation_$key", 'placeholder' => 'Enter Other Occupation']) !!}
                        @endif
                    </td>
                    <td>{!! Form::number("occu[$key][present_demand]", $value->present_demand, ['class' => 'form-control occ-required', 'min' => 0]) !!}
                        {!! $errors->first("occu.$key.present_demand", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{!! Form::number("occu[$key][demand_two_year]", $value->demand_two_year, ['class' => 'form-control occ-required', 'min' => 0]) !!}
                        {!! $errors->first("occu.$key.demand_two_year", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{!! Form::number("occu[$key][demand_five_year]", $value->demand_five_year, ['class' => 'form-control occ-required ', 'min' => 0]) !!}
                        {!! $errors->first("occu.$key.demand_five_year", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>
                        @if ($loop->first)
                            <button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i
                                    class="fas fa-plus"></i></button>
                        @else
                            <a type="button" href="{{ url('emitters/other_occupation/deleteOption', $value->id) }}"
                                class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></a>

                        @endif
                    </td>

                </tr>

            @endforeach
        @else
            <tr>
                <td>{!! Form::select('occu[0][occupation_id]', $occupations->pluck('occupation_name', 'id'), null, ['class' => 'form-control  select2 occ-required ', 'style' => 'width:100%;', 'id' => 'occupation_0', 'placeholder' => 'Select Occupation','onChange' => 'otherOccupation(this)']) !!}
                    {!! $errors->first('occu.0.occupation_id', '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{!! Form::number('occu[0][present_demand]', null, ['class' => 'form-control occ-required', 'min' => 0]) !!}
                    {!! $errors->first('occu.0.present_demand', '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{!! Form::number('occu[0][demand_two_year]', null, ['class' => 'form-control occ-required ', 'min' => 0]) !!}
                    {!! $errors->first('occu.0.demand_two_year', '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{!! Form::number('occu[0][demand_five_year]', null, ['class' => 'form-control  occ-required ', 'min' => 0]) !!}
                    {!! $errors->first('occu.0.demand_five_year', '<span class="text-danger">:message</span>') !!}
                </td>
                <td><button type="button" name="occupa_add" id="add1" class="btn btn-sm btn-success"><i
                            class="fas fa-plus"></i></button></td>

            </tr>
        @endif
    </tbody>

</table>
@push('custom-scripts')

    <script>
        var details = {!! json_encode($other_answer) !!};
        var row_count = details == null ? 0 : details.length;
        $('#add1').click(function() {
            ++row_count;
            $("#occupationTable").append(
                ` <tr>
            <td>{!! Form::select('occu[${row_count}][occupation_id]', $occupations->pluck('occupation_name', 'id'), null, ['class' => 'form-control  select2 occ-required', 'id' => 'occupation_0', 'placeholder' => 'Select Occupation', 'style' => 'width:100%;','onChange' => 'otherOccupation(this)']) !!}</td>
            <td>{!! Form::number('occu[${row_count}][present_demand]', null, ['class' => 'form-control occ-required', 'min' => 0]) !!}</td>
            <td>{!! Form::number('occu[${row_count}][demand_two_year]', null, ['class' => 'form-control occ-required', 'min' => 0]) !!}</td>
            <td>{!! Form::number('occu[${row_count}][demand_five_year]', null, ['class' => 'form-control occ-required', 'min' => 0]) !!}</td>

         <td><button type="button" class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button></td></tr>`
                );
            $('.select2').select2();
            $('.occ-required').attr('required', 'required');

        });
        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
    <script>
        function otherOccupation(el) {
            if ($(el).find('option:selected').text() === 'Others') {
                var ik = el.id
                var count = ik.split('_')[1];
                $(el).parents('td').append(`{!! Form::text('occu[${count}][other_value]', null, ['class' => 'form-control mt-2 other_${ik}', 'placeholder' => 'Enter Other Occupation']) !!}`);
            } else {
                var ik = el.id
                $(`.other_${ik}`).remove();
            }
        }
    </script>

@endpush
