<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .nepali {
            font-family: 'freesans', sans-serif;

        }

        table {
            border-collapse: collapse;
            margin-top: 25px;
        }
        th{
padding: 10px
        }
td{
    padding: 10px;
}
    </style>
</head>

<body>
    <h1> Enumerator Survey Organizations</h1>

    <strong> Enumerator Name :</strong> {{ $enumerator[0]->emitter->name }}<br>
    <strong>Disrict : </strong> {{ $enumerator[0]->emitter->district->english_name }} <br>
    <strong>Assigned Organizations : </strong> {{ $enumerator->assigned_organizations }}<br>
    <strong> Completed Organizations :</strong> {{ $enumerator->completed_organizations }} <br>

    <table border="1" >
        <thead>
            <tr>
                <th> S.N</th>
                <th>Organization Name</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($enumerator as $key => $e)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="nepali" style="width:450px">{{ isset($e->organization )? $e->organization->org_name : '-' }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>

    <div style="margin-top: 20px">
        <strong>Supervised By : </strong>
        {{ $enumerator[0]->emitter ? $enumerator[0]->emitter->supervisor->name : '-' }} <br>
        <strong>Approved By : </strong>
        {{ $enumerator[0]->emitter ? $enumerator[0]->emitter->supervisor->supervisor->coordinator->name : '-' }}
    </div>
</body>

</html>
