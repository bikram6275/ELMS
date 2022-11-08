<table>
    <thead>
        <tr>
            <th>Organization Id</th>
            <th>Trained and Experinced</th>
            <th>Trained and Inexperienced</th>
            <th>Untrained and Experienced</th>
            <th>Untrained and Inexperienced</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
            <tr>
                <td>{{ $key }}</td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer= json_decode($item->answer,true);
                        @endphp
                        {{ $answer['55']}}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp
                        {{ $answer['56'] }}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp
                        {{ $answer['87'] }}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp
                        {{ $answer['88'] }}
                    @endisset
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
