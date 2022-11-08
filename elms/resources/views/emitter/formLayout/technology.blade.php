<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Sector</th>
            <th>Technology</th>
        </tr>

    </thead>
    <tbody>
        <tr>
            {!! Form::hidden("technology[id]", $other_answer!=null?$other_answer->id:null, ['class' => 'form-control ']) !!}
            <td>{{Form::select('technology[sector_id]',$parentSector->pluck('sector_name','id'),$other_answer!=null?$other_answer->sector->id:null,['class'=>'form-control select2 tech-required','id'=>'sector_id','style'=>'width:100%;','placeholder'=>
                ' Select Sector'])}}
                {!! $errors->first('technology.sector_id', '<span class="text-danger">:message</span>') !!}

            </td>
            
            <td>{!! Form::text('technology[technology]',$other_answer!=null?$other_answer->technology:null, ['class' => 'form-control tech-required'])!!}
                {!! $errors->first('technology.technology', '<span class="text-danger">:message</span>') !!}
            </td>

        </tr>

    </tbody>
</table>


