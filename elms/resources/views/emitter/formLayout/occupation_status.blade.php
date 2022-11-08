<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sector</th>
            <th>Occupation</th>
            <th>Currently working numbers</th>
            <th>Currently Required Number</th>
            <th>Estimated Required For next two Years</th>
            <th>Estimated Required For next five Years</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($occupations as $occupation)

            <tr>
                {!! Form::hidden("occupation_status[$occupation->occupation_id][id]", $answer != null && isset($answer[$occupation->occupation_id]) ? $answer[$occupation->occupation_id][0]->id : 0, ['class' => 'form-control ']) !!}
                <td>{{ $occupation->sector_name }}</td>
                <td>{{ $occupation->occupation_name }}</td>
                <td>{!! Form::number("occupation_status[$occupation->occupation_id][working_number]", $answer != null && isset($answer[$occupation->occupation_id]) ? $answer[$occupation->occupation_id][0]->working_number : 0, ['class' => 'form-control', 'min' => 0]) !!}
                    {!! $errors->first("occupation_status.$occupation->occupation_id.working_number", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{!! Form::number("occupation_status[$occupation->occupation_id][required_number]", $answer != null && isset($answer[$occupation->occupation_id]) ? $answer[$occupation->occupation_id][0]->required_number : 0, ['class' => 'form-control', 'min' => 0]) !!}
                    {!! $errors->first("occupation_status.$occupation->occupation_id.required_number", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{!! Form::number("occupation_status[$occupation->occupation_id][for_two_years]", $answer != null && isset($answer[$occupation->occupation_id]) ? $answer[$occupation->occupation_id][0]->for_two_years : 0, ['class' => 'form-control', 'min' => 0]) !!}
                    {!! $errors->first("occupation_status.$occupation->occupation_id.for_two_years", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{!! Form::number("occupation_status[$occupation->occupation_id][for_five_years]", $answer != null && isset($answer[$occupation->occupation_id]) ? $answer[$occupation->occupation_id][0]->for_five_years : 0, ['class' => 'form-control', 'min' => 0]) !!}
                    {!! $errors->first("occupation_status.$occupation->occupation_id.for_five_years", '<span class="text-danger">:message</span>') !!}
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
