<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>Aspects</th>
            <th>Trained and Inexperienced</th>
            <th>Untrained and Experienced</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($skills as $key => $skill)
            <tr>
                {!! Form::hidden("skill[$key][id]", $answer != null && isset($answer[$key]) ? $answer[$key][0]['id'] : 0, ['class' => 'form-control ']) !!}

                <th>{{ $skill }}</th>
                <td>
                    {!! Form::number("skill[$key][formally_trained]", $answer != null && isset($answer[$key]) ? $answer[$key][0]['formally_trained'] : null, ['class' => 'form-control no_duplicate', 'min' => 1, 'max' => 5,'id'=>"trained-$loop->index"]) !!}
                    {!! $errors->first("skill.$key.formally_trained", '<span class="text-danger">:message</span>') !!}

                </td>
                <td>
                    {!! Form::number("skill[$key][formally_untrained]", $answer != null && isset($answer[$key]) ? $answer[$key][0]['formally_untrained'] : null, ['class' => 'form-control no_duplicate', 'min' => 1, 'max' => 5,'id'=>"untrained-$loop->index"]) !!}
                    {!! $errors->first("skill.$key.formally_untrained", '<span class="text-danger">:message</span>') !!}
                </td>

            </tr>
        @endforeach

    </tbody>


</table>
