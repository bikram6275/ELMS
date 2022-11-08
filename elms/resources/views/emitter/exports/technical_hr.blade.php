
<table>
    <thead >
        {{-- <tr ><th colspan="10" style="vertical-align: middle" >{{ $org_key }}</th></tr> --}}
        <tr>
            <th rowspan="2" style="vertical-align: middle">Occupation Name</th>
            <th rowspan="2" style="vertical-align: middle">Gender</th>
            <th rowspan="2" style="vertical-align: middle">Occupations</th>
            <th rowspan="2" style="vertical-align: middle">Working Hours</th>
            <th rowspan="2" style="vertical-align: middle">Nature of Work</th>
            <th rowspan="2" style="vertical-align: middle">Training</th>
            <th rowspan="2" style="vertical-align: middle">OJT/Apprentice</th>
            <th rowspan="2" style="vertical-align: middle">Educational Qualification(TVET)</th>
            <th rowspan="2" style="vertical-align: middle">Educational Qualification(General)</th>
            <th colspan="2">Work Experience(In Years)</th>
        </tr>
        <tr>
            <th>In present position</th>
            <th>In this Occupation</th>
        </tr>
    </thead>
    <tbody>
        @foreach($technical_data as $t)
        @foreach($t as $org_key=>$data)
@if(count($data)>0)
    @foreach($data as $key => $val)
    <tr>
        <td>{{ $org_key}}</td>
        <td>{{ $val->gender=='male'?'Male':'Female' }}</td>
        <td>{{ $val->occupation->occupation_name }}{{ $val->occupation_id == '279' ? "(". $val->other_occupation_value .")": "" }}</td>
        <td>{{ $val->working_time=='full'?'Full Time' :'Part Time'}}</td>
        <td>{{ $val->work_nature=='regular'?'Regular':'Seasonal' }}</td>
        <td>{{ $val->training=='trained'?'Trained':'Untrained' }}</td>
        <td>{{ $val->ojt_apprentice }}</td>
        <td>{{ $val->tvetEducation->name }}</td>
        <td>{{ $val->generalEducation->name }}</td>
        <td>{{ $val->work_exp1 }}</td>
        <td>{{ $val->work_exp2 }}</td>


    </tr>

    @endforeach
    @endif
    @endforeach
@endforeach
    </tbody>
</table>
