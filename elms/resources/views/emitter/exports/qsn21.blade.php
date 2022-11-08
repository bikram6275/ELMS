<table>
    <thead>
        <tr>
           <th>Organization ID</th>
           <th>Hire Women To Work</th>
            <th>If Yes Occupation Name</th>
            <th>Unfair competition among enterprisers</th>
            <th>Problems of skilled human sresources</th>
            <th>Political Instability</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($data as $key => $item)
        
            <tr>
                <td>{{ $key }}</td>
                <td>
                   {{ $item?$item->questionOption->option_name:'null'}}
                </td>
                <td>
                    {{ $item?$item->other_answer:'null' }}
                </td>
               
            </tr>
        @endforeach
    </tbody>
</table>
