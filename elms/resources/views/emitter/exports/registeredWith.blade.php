<table>
    <thead>
        <tr>
            <th>Organization Id</th>
            <th>Office of Company Registar</th>
            <th>Cottage and Small Industry Office</th>
            <th>Department of Industry</th>
            <th>Local Government (Municipality/R. Municipality)</th>
            <th> Others</th>
            <th>Political Instability</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($data as $key => $item)
           <tr>
            <td>{{ $key }}</td>
            <td>
                @isset($item->answer)
                    @if (in_array('1', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('2', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('3', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('4', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('6', explode(',', $item->answer)))
                        yes({{ $item->other_answer }})
                    @else
                        
                    @endif
                @endisset
            </td>
           </tr>
        @endforeach
    </tbody>
</table>
