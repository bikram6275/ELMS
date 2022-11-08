<table>
    <tr>
        <th colspan="5"><h1>Enumerator Wise Organization Survey Status</h1></th>
    </tr>
</table>
<table>
    <thead>
    <tr>
        <th>S.N</th>
        <th>Organization Name</th>
        <th>Survey Status</th>
        <th>Survey Start Date</th>
        <th>Survey End Date</th>

    </tr>
    </thead>
    <tbody>
    @foreach($enumerators as $row)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{$row->organization->org_name}}</td>
        <td>{{ ($row->finish_date != null)?'Completed':(($row->start_date!=null && $row->finish_date=null)?'Started':"Not Started") }}</td>
        <td>{{ $row->start_date }}</td>
        <td>{{ $row->finish_date }}</td>


    </tr>
    @endforeach
    </tbody>
</table>