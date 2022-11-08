<table>
    <thead>
        <tr>
            <th>Organization Id</th>
            <th>FNCCI</th>
            <th>FNCSI</th>
            <th>CNI</th>
            <th>FCAN</th>
            <th>HAN</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $items)
            <tr>
                <td>{{ $key }}</td>
                <td>
                    @isset($items[9])
                    {{ json_decode($items[9]->answer,true)[19] }}
                    @endisset
                </td>
                <td>
                    @isset($items[10])
                    {{ json_decode($items[10]->answer,true)[21] }}
                    @endisset
                </td>
                <td>
                    @isset($items[11])
                    {{ json_decode($items[11]->answer,true)[23] }}
                    @endisset
                </td>
                <td>
                    @isset($items[12])
                    {{ json_decode($items[12]->answer,true)[25] }}
                    @endisset
                </td>
                <td>
                    @isset($items[13])
                    {{ json_decode($items[13]->answer,true)[27] }}
                    @endisset
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
