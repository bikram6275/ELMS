@foreach ($human_resource['data'] as $org_key => $data)
    @if (count($data) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th colspan="5" style="vertical-align: middle">{{ $org_key }}</th>
                </tr>
                <tr>
                    <th rowspan="2" style="vertical-align: middle">S.N</th>
                    <th colspan="2" rowspan="2" style="vertical-align: middle">Nature of Human Resources</th>
                    <th colspan="3">Gender</th>
                    <th colspan="3">Nationality</th>
                    <th rowspan="2" style="vertical-align: middle">Total Staff</th>
                </tr>
                <tr>
                    <th>Male</th>
                    <th>Female</th>
                    <th>Sexual Minority</th>
                    <th>Nepali</th>
                    <th>Neighboring Countries</th>
                    <th>Foreigner</th>

                </tr>
            </thead>
            <tbody>
                @php $i=1; @endphp

                @foreach ($human_resource['humanResources'] as $key => $humanResource)
                    @foreach ($human_resource['workers'] as $key1 => $worker)
                        <tr>

                            <td>{{ $i++ }}</td>
                            @if ($loop->first)
                                <td rowspan="{{ count($human_resource['workers']) }}" style="vertical-align: middle">
                                    {{ $humanResource }}</td>
                            @endif
                            <td>{{ $worker }}</td>
                            <td> {{ $data[$key][$key1][0]->male_count }}</td>
                            <td> {{ $data[$key][$key1][0]->female_count }}</td>
                            <td> {{ $data[$key][$key1][0]->minority_count }}</td>
                            <td> {{ $data[$key][$key1][0]->nepali_count }}</td>
                            <td> {{ $data[$key][$key1][0]->neighboring_count }}</td>
                            <td> {{ $data[$key][$key1][0]->foreigner_count }}</td>
                            <td> {{ $data[$key][$key1][0]->total }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif
@endforeach
