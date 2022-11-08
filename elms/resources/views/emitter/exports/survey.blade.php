@if(isset($organizations))
<table>
    <thead>
        <tr>
            <th>Org Number</th>
            <th>Organization</th>
            <th>Province</th>
            <th>District</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($organizations as $val )
        <tr>
            <td>{{ $val->organization_id }}
            <td>{{$val->organization->org_name}}</td>
            <td>{{ $val->organization->pradesh->pradesh_name }}</td>
            <td>{{ $val->organization->district->nepali_name }}</td>
        </tr>

        @endforeach
    </tbody>
</table>
@elseif(isset($questions))
<table>
    <thead>
        <tr>
            <th>Qsn Number</th>
            <th>Question Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $val )
        <tr>
            <td>{{ $val->qsn_number }}
            <td>{{$val->qsn_name}}</td>

        </tr>

        @endforeach
    </tbody>
</table>
@elseif(isset($answer))
@include('emitter.exports.answer')
@endif
