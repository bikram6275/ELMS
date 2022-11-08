<table class="table table-bordered" id="occupationTable">
    <thead>
        <tr>
            <th>Organization Name </th>
            <th>Name of Occupations </th>
            <th>Present demand </th>
            <th>Estimated demand for next two years </th>
            <th>Estimated demand for next five years</th>
        </tr>

    </thead>
    <tbody>
        
        @foreach($other_occupation as $o)
        @foreach ($o as $org_key => $data)

            @if (count($data) > 0)
                @foreach ($data as $key => $value)

                    <tr>
                        <td>{{ $org_key }}</td>
                        <td>{{ $value->occupation?$value->occupation->occupation_name : "No occupation" }}{{ $value->occupation_id == '279' ? "(". $value->other_value .")": "" }}</td>
                        <td>{{ $value->present_demand }}</td>
                        <td>{{ $value->demand_two_year }}</td>
                        <td>{{ $value->demand_five_year }}</td>

                    </tr>
                @endforeach
            @endif
        @endforeach
        @endforeach
    </tbody>

</table>
