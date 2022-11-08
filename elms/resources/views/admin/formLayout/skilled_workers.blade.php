
<table class="table table-bordered" id=skilledTable>
    <thead>
        <tr>
            <th style="width: 20%;">Sector</th>
            <th style="width: 20%;">Proposed Occupation</th>
            <th style="width: 20%;">Skilled Level</th>
            <th style="width: 20%;">Required Number</th>
            <th style="width: 20%;">Possibility to incorporate green skills components/occupations</th>
            <th style="width: 20%;">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (count($other_answer) > 0)
            @foreach ($other_answer as $key => $value)
                <tr>

                    {!! Form::hidden("skilled[$key][id]", $value->id, ['class' => 'form-control ']) !!}


                    <td>{!! Form::select("skilled[$key][sector_id]",$parentSector->pluck('sector_name','id'), $value->sector_id, ['class' => 'form-control add-required select2 ','id'=>"sector_id_$key",'placeholder'=>'Select Sector','onChange'=>'changeOccupation()']) !!}
                        {!! $errors->first("skilled.$key.sector_id", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{{Form::select("skilled[$key][occupation_id]",$occupations[$value->sector_id]->pluck('occupation_name','id'),$value->occupation_id!=null?$value->occupation_id:null,['class'=>'form-control select2','id'=>"occupation_$key",'placeholder'=>
                        ' Select Occupation'])}}

                        {!! $errors->first("skilled.$key.occupation_id", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{!! Form::text("skilled[$key][level]", $value->level, ['class' => 'form-control add-required']) !!}
                        {!! $errors->first("skilled.$key.level", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{!! Form::number("skilled[$key][required_number]", $value->required_number, ['class' => 'form-control add-required', 'min' => 0]) !!}
                        {!! $errors->first("skilled.$key.required_number", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{!! Form::text("skilled[$key][incorporate_possible]", $value->incorporate_possible, ['class' => 'form-control add-required ']) !!}
                        {!! $errors->first("skilled.$key.incorporate_possible", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>
                        @if ($loop->first)
                            <button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i
                                    class="fas fa-plus"></i></button>
                        @else
                            <a type="button" href="{{ url('emitters/skilled/deleteOption', $value->id) }}"
                                class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></a>
                    </td>
            @endif

            </tr>
        @endforeach
    @else
        <tr>

            <td>{!! Form::select('skilled[0][sector_id]', $parentSector->pluck('sector_name','id'), null, ['class' => 'form-control add-required select2 ','id'=>'sector_id_0','placeholder'=>'Select Sector','onChange'=>'changeOccupation()']) !!}
                {!! $errors->first('skilled.0.sector_id', '<span class="text-danger">:message</span>') !!}
            </td>
            <td>
            <select name="skilled[0][occupation_id]" id="occupation_0" class="form-control select2">
                <option value=""> Select Occupation</option>
            </select>
                {!! $errors->first('skilled.0.occupation_id', '<span class="text-danger">:message</span>') !!}
            </td>
            <td>{!! Form::text('skilled[0][level]', null, ['class' => 'form-control add-required']) !!}
                {!! $errors->first('skilled.0.level', '<span class="text-danger">:message</span>') !!}
            </td>
            <td>{!! Form::number('skilled[0][required_number]', 0, ['class' => 'form-control add-required', 'min' => 0]) !!}
                {!! $errors->first('skilled.0.required_number', '<span class="text-danger">:message</span>') !!}
            </td>
            <td>{!! Form::text('skilled[0][incorporate_possible]', null, ['class' => 'form-control add-required']) !!}
                {!! $errors->first('skilled.0.incorporate_possible', '<span class="text-danger">:message</span>') !!}
            </td>
            <td><button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i
                        class="fas fa-plus"></i></button></td>
                    </tr>
                    @endif
    </tbody>
</table>
@push('custom-scripts')


    <script>
        var details = {!! json_encode($other_answer) !!};
        var row_count = details == null ? 0 : details.length;
        // var row_count = 0;
        $('#add1').click(function() {
            ++row_count;
            $("#skilledTable").append(
                ` <tr>

             <td>{!! Form::select('skilled[${row_count}][sector_id]', $parentSector->pluck('sector_name','id'), null, ['class' => 'form-control add-required select2 ','id'=>'sector_id_${row_count}','placeholder'=>'Select Sector','onChange'=>'changeOccupation()']) !!}

            <td>
                <select name='skilled[${row_count}][occupation_id]' id='occupation_${row_count}' class="form-control select2" >
                    <option value=""> Select Occupation</option>
                </select>
            </td>
            <td>{!! Form::text('skilled[${row_count}][level]', null, ['class' => 'form-control add-required']) !!}</td>
            <td>{!! Form::number('skilled[${row_count}][required_number]', 0, ['class' => 'form-control add-required', 'min' => 0]) !!}</td>
            <td>{!! Form::text('skilled[${row_count}][incorporate_possible]', null, ['class' => 'form-control add-required']) !!}</td>
         <td><button type="button" class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button></td></tr>`
            );
            $('.select2').select2();
            $('.add-required').attr('required', 'required');
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
<script>
    var occupations= <?php echo json_encode($occupations); ?>;

  function changeOccupation(){

var type_id= event.target.id.split('-');
      var type = $('#'+type_id[1]).val();
      var index=type_id[1].split('_');
      $('#occupation_'+index[2]).html('');
          var collection = occupations[type];
          $('#occupation_'+index[2]).append(`<option value="0" selected disabled>Select Occupation</option>`);
          for (var key in collection) {
              $('#occupation_'+index[2]).append(`<option value="${collection[key]['id']}">${collection[key]['occupation_name']}</option>`);
          }

  }
</script>
@endpush
