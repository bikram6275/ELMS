@inject('serviceHelper', 'App\Helpers\ServiceHelper')
<table>
    <thead>
        <tr>
            <td>Organization ID</td>
           <td colspan="5">Product and Services</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['answer'] as $key => $answer)
        <tr>
            <td>{{ $key }}</td>
            @isset($answer->answer)
            @foreach(explode(',',$answer->answer) as $a)
                <td>{{ $serviceHelper->value($a) }}</td>
            @endforeach
            @endisset
            @isset($answer->other_answer)
                <td>{{ $answer->other_answer }}</td>
            @endisset
        </tr>
        @endforeach
    </tbody>
</table>
