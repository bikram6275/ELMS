<table>
    <thead>
        <tr>
            <th>Organization Name</th>
            <th>Aspects</th>
            <th>Trained and Inexperienced</th>
            <th>Untrained and Experienced</th>
        </tr>
    </thead>
    <tbody>
        @foreach($skills as $s)
        @foreach ($s['data'] as $org_key => $data)
            @if (count($data) > 0)
                @foreach ($s['skills'] as $key => $skill)
                    <tr>

                        <th>{{ $org_key }}</th>
                        <th>{{ $skill }}</th>
                        <td>{{ $data[$key][0]['formally_trained'] }}</td>
                        <td>{{ $data[$key][0]['formally_untrained'] }}</td>

                    </tr>
                @endforeach

            @endif
        @endforeach
        @endforeach
    </tbody>



</table>
