<table>
    <thead>
        <tr>
            <th>Organization Name</th>
            <th>Sector</th>
            <th>Proposed Occupation</th>
            <th>Skilled Level</th>
            <th>Required Number</th>
            <th>Possibility to incorporate green skills components/occupations</th>
        </tr>
    </thead>
    <tbody>
        @foreach($business_plan as $b)
        @foreach ($b as $org_key => $data)
            @if (count($data) > 0)
                @foreach ($data as $key => $value)
                    <tr>
                        <td>{{ $org_key }}</td>
                        <td>{{ $value->sector->sector_name }}</td>
                        <td>{{ $value->occupation->occupation_name }}{{ $value->occupation_id == '279' ? "(". $value->other_occupation_value .")": "" }}</td>
                        <td>{{ $value->level }}</td>
                        <td>{{ $value->required_number }}</td>
                        <td>{{ $value->incorporate_possible }}</td>
                    </tr>
                @endforeach

            @endif
        @endforeach
        @endforeach
    </tbody>
</table>
