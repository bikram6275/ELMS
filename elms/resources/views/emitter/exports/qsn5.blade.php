<table>
    <thead>
        <tr>
            <th>Organization Id</th>
            <th>Employer</th>
            <th>Contributing Family Members</th>
            <th>Employees</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
        
            <tr>
                <td>{{ $key }}</td>
                <td>
                    @isset($item->answer)
                     @if(in_array('99',explode(',',$item->answer)))
                        yes
                     @else
                        no
                     @endif
                     @endisset
                </td>
                <td>
                    @isset($item->answer)
                    @if(in_array('100',explode(',',$item->answer)))
                       yes
                    @else
                       no
                    @endif
                    @endisset
               </td>
               <td>
                @isset($item->answer)

                @if(in_array('101',explode(',',$item->answer)))
                   yes
                @else
                   no
                @endif
                @endisset
           </td>
            </tr>
        @endforeach
    </tbody>
</table>
