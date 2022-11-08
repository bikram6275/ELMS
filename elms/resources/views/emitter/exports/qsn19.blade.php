<table>
    <thead>
        <tr>
            <th>Organization Id</th>
            <th>Trainees frequently visits our industry for work-place practices</th>
            <th>Trainees occasionally visits our industry for OJT as work-place practice</th>
            <th>Institutes invites me for curriculum development process.</th>
            <th>Institute occasionally invites me for policy level interactions.</th>
            <th> Institute coordinate our industry for assessors.</th>
            <th>Local TVET institute regularly contact me for rapid market appraisal (RMA)</th>
            <th>Business association co-ordinate with TVET</th>
            <th>None of the above</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($data as $key => $item)
           <tr>
            <td>{{ $key }}</td>
            <td>
                @isset($item->answer)
                    @if (in_array('75', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('76', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('77', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('78', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('97', explode(',', $item->answer)))
                        yes($item->other_answer)
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('98', explode(',', $item->answer)))
                        yes($item->other_answer)
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('107', explode(',', $item->answer)))
                        yes($item->other_answer)
                    @else
                        
                    @endif
                @endisset
            </td>
            <td>
                @isset($item->answer)
                    @if (in_array('108', explode(',', $item->answer)))
                        yes
                    @else
                        
                    @endif
                @endisset
            </td>
           </tr>
        @endforeach
    </tbody>
</table>
