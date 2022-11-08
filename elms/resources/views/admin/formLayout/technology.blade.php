<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Sector</th>
            <th>Sub-Sector</th>
            <th>Tachnology</th>
        </tr>

    </thead>
    <tbody>
        <tr>
            {!! Form::hidden("technology[id]", $other_answer!=null?$other_answer->id:null, ['class' => 'form-control ']) !!}
            <td>{{Form::select('technology[sector_id]',$parentSector->pluck('sector_name','id'),$other_answer!=null?$other_answer->sector->parent_id:null,['class'=>'form-control select2 tech-required','id'=>'sector_id','style'=>'width:100%;','placeholder'=>
                ' Select Sector','onchange=changeSubSector()'])}}
                {!! $errors->first('technology.sector_id', '<span class="text-danger">:message</span>') !!}

            </td>
            <td>
                @if($other_answer!=null)
                {{Form::select('technology[sub_sector_id]',$subSectorSector[$other_answer->sector->parent_id]->pluck('sector_name','id'),$other_answer->sector->id,['class'=>'form-control select2 tech-required','id'=>'sub_sector_id','style'=>'width:100%;','placeholder'=>
                ' Select Sub-Sector'])}}
                @else
                <select class=" form-control select2 tech-required" id="sub_sector_id" name="technology[sub_sector_id]" style="width: 100%" >
                    <option value="">Select Sub-Sector</option>
                </select>
                @endif
                {!! $errors->first('technology.sub_sector_id', '<span class="text-danger">:message</span>') !!}

            </td>
            <td>{!! Form::text('technology[technology]',$other_answer!=null?$other_answer->technology:null, ['class' => 'form-control tech-required'])!!}
                {!! $errors->first('technology.technology', '<span class="text-danger">:message</span>') !!}
            </td>

        </tr>

    </tbody>
</table>

@push('custom-scripts')
<script>
       var sub_sector= <?php echo json_encode($subSectorSector); ?>;

       function changeSubSector(){

         var sub_sector_val = $('#sector_id').val();
            $('#sub_sector_id').html('');
            var collection = sub_sector[sub_sector_val];
            $('#sub_sector_id').append(`<option value="" selected disabled>Select Sub-Sector</option>`);
            for (var key in collection) {
                $('#sub_sector_id').append(
                    `<option value="${collection[key]['id']}">${collection[key]['sector_name']}</option>`);
            }
    }
    </script>

@endpush
