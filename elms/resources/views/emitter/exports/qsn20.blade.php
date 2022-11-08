<table>
    <thead>
        <tr>
            <th>Organization Id</th>
           <th>No Problem</th>
           <th>Rules/Regulations of the government</th>
            <th>Bureaucratic/admininstrative hurdles</th>
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
                    @isset($item->answer)
                        @php
                            $answer= json_decode($item->answer,true);
                        @endphp
                        {{ $answer['79']}}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp
                        {{ $answer['80'] }}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp
                        {{ $answer['81'] }}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp
                        {{ $answer['82'] }}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp
                        {{ $answer['83'] }}
                    @endisset
                </td>
                <td>
                    @isset($item->answer)
                        @php
                            $answer = json_decode($item->answer,true);
                        @endphp

                        {{ isset($answer['84']) ? $answer['84']:"" }}
                    @endisset
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
