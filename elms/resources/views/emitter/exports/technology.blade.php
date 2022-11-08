<table class="table table-bordered ">
    <thead>
        <tr>
            <th>Organization Name</th>
            <th>Sector</th>
            <th>Technology</th>
        </tr>

    </thead>
    <tbody>
        @foreach($technology as $t)
@foreach ($t['data'] as $org_key => $data)
            @if ($data != null)
                <tr>
                    <td>{{ $org_key }}</td>
                    <td>{{ $data->sector->sector_name }}</td>
                    <td>{{ $data->technology }}</td>

                </tr>

            @endif
        @endforeach
        @endforeach
    </tbody>
</table>
