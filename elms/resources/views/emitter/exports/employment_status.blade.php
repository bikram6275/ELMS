
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Occupation Name</th>
            <th>Sector</th>
            <th>Occupation</th>
            <th>Currently working numbers</th>
            <th>Currently Required Number</th>
            <th>Estimated Required For next two Years</th>
            <th>Estimated Required For next five Years</th>

        </tr>
    </thead>
    <tbody>
@foreach ($employment as $e)
@foreach ($e['data'] as $org_key=>$data )

@if(count($data)>0)
   
        @foreach ($e['occupation'][$org_key] as $occupation)
            <tr>
                <td>{{ $org_key}}</td>
                <td>{{ $occupation->sector_name }}</td>
                <td>{{ $occupation->occupation_name }}</td>
                <td>{!! isset($data[$occupation->occupation_id]) ? $data[$occupation->occupation_id][0]->working_number : 0 !!}</td>
                <td>{!! isset($data[$occupation->occupation_id]) ? $data[$occupation->occupation_id][0]->required_number : 0 !!}</td>
                <td>{!! isset($data[$occupation->occupation_id]) ? $data[$occupation->occupation_id][0]->for_two_years : 0 !!}</td>
                <td>{!! isset($data[$occupation->occupation_id]) ? $data[$occupation->occupation_id][0]->for_five_years : 0 !!}</td>
            </tr>
        @endforeach
        @endif
        @endforeach
@endforeach
    </tbody>
</table>
