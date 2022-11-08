<table class="table table-bordered">
    <thead>
        <tr>
            <th>Organization Name</th>
            @foreach ($human_resource as $key => $hr)
            @foreach($hr['humanResources'] as $h)
                @foreach ($hr['workers'] as $key1 => $worker)
                    <th>{{ $h }} {{ $worker }} Male</th>
                    <th>{{ $h }} {{ $worker }} Female</th>
                    <th>{{ $h }} {{ $worker }} Sexual Minority</th>
                    <th>{{ $h }} {{ $worker }} Nepali</th>
                    <th>{{ $h }} {{ $worker }} Neighboring Countries</th>
                    <th>{{ $h }} {{ $worker }} Foreigner</th>
                    <th>{{ $h }} {{ $worker }} Total</th>
                @endforeach
            @endforeach
            @endforeach


        </tr>
    </thead>
    <tbody>
        @php $i=1; @endphp
        @foreach($human_resource as $a)
        @foreach ($a['data'] as $org_key => $data)
            @if (count($data) > 0)

                <tr>
                    <td>{{ $org_key }}</td>
                    @foreach($human_resource as $s)
                    @foreach ($s['humanResources'] as $key => $humanResource)
                        @foreach ($s['workers'] as $key1 => $worker)
                            <td> {{ isset($data[$key]) && isset($data[$key][$key1])?$data[$key][$key1][0]->male_count:0 }}</td>
                            <td> {{ isset($data[$key]) && isset($data[$key][$key1])?$data[$key][$key1][0]->female_count:0 }}</td>
                            <td> {{ isset($data[$key]) && isset($data[$key][$key1])?$data[$key][$key1][0]->minority_count:0 }}</td>
                            <td> {{ isset($data[$key]) && isset($data[$key][$key1])?$data[$key][$key1][0]->nepali_count:0 }}</td>
                            <td> {{ isset($data[$key]) && isset($data[$key][$key1])?$data[$key][$key1][0]->neighboring_count:0 }}</td>
                            <td> {{ isset($data[$key]) && isset($data[$key][$key1])?$data[$key][$key1][0]->foreigner_count:0 }}</td>
                            <td> {{ isset($data[$key]) && isset($data[$key][$key1])?$data[$key][$key1][0]->total:0 }}</td>
                        @endforeach
                    @endforeach
                    @endforeach
                </tr>
            @endif
        @endforeach
@endforeach 


    </tbody>
</table>
