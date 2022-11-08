<table class="table table-bordered">
    <thead class="text-center">
        <tr>
            <th>Organization Number</th>
            <th>Nature of Human Resources</th>
            <th>Male</th>
            <th>Female</th>
            <th>Sexual Minority</th>
            <th>Nepali</th>
            <th>Neighboring Countries</th>
            <th>Foreigner</th>
            <th>Total Staff</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1; @endphp
        @foreach ($human_resource as $key => $hr)
        @foreach ($hr as $key1 => $worker)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $key1 }}</td>
                @foreach ($worker as $w)
                        <td>{{ isset($w) ? $w['male_count'] : 0 }}</td>
                        <td>{{ isset($w) ? $w['female_count'] : 0 }}</td>
                        <td>{{ isset($w) ? $w['minority_count'] : 0 }}</td>
                        <td>{{ isset($w) ? $w['nepali_count'] : 0 }}</td>
                        <td>{{ isset($w) ? $w['neighboring_count'] : 0 }}</td>
                        <td>{{ isset($w) ? $w['foreigner_count'] : 0 }}</td>
                        <td>{{ isset($w) ? $w['total'] : 0 }}</td>
                        @endforeach
                    </tr>
                        @endforeach
                        @endforeach
    </tbody>
</table>
