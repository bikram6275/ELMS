<table>
    <thead>
        <tr>
            <th>Organization Number</th>
            @foreach ($answer['question'] as $question)
                @if ($question->parent_id == 0)
                    <th>{{ $question->qsn_number }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($answer['answer'] as $org_id => $answer1)
            <tr>
                <td>{{ $org_id }}</td>
                @foreach ($answer1 as $ans)
                    @if ($ans->answer != null && count($ans->answer) > 0)
                        @if ($ans->ans_type == 'input')
                            <td>{{ $ans->answer[0]->answer }}</td>
                        @elseif($ans->ans_type == 'checkbox')
                            <?php $result = explode(',', $ans->answer[0]->answer); ?>
                            <td>
                                @if ($ans->id == 23)
                                    {
                                    {{ dd($ans->questionOption) }}
                                    }
                                @endif
                                @foreach ($ans->questionOption as $option)
                                    @foreach ($result as $res)
                                        @if ($res == $option->id)
                                            {{ $option->option_name }},
                                            {{ $option->option_name == 'Others' ? $ans->answer[0]->other_answer : null }}
                                        @endif
                                    @endforeach
                                @endforeach
                            </td>
                        @elseif($ans->ans_type == 'radio')
                            <td>
                                @foreach ($ans->questionOption as $option)
                                    @if ($ans->answer[0]->qsn_opt_id == $option->id)
                                        @if ($ans->qsn_number == 21)
                                            {{ $option->option_name }} - {{ $ans->answer[0]->other_answer }}
                                        @elseif($ans->qsn_number == 10)
                                            {{ $option->option_name }} 
                                                @if ($option->option_name == 'Others')
                                                    ({{ $ans->answer[0]->other_answer  }})
                                                @endif
                                        @else
                                            {{ $option->option_name }}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                        @elseif ($ans->ans_type == 'multiple_input')
                            <td>
                                <?php $result3 = (array) json_decode($ans->answer[0]->answer); ?>

                                @foreach ($ans->questionOption as $key => $val)
                                    {{ $val->option_number }} -
                                    <strong>{{ array_key_exists($value->id, $result3) ? $result3[$value->id] : null }}</strong>,
                                @endforeach
                            </td>
                        @elseif($ans->ans_type == 'sub_qsn')
                            <td>
                                @foreach ($ans->children as $key => $value)
                                    <?php $result2 = count($value->answer) > 0 ? (array) json_decode($value->answer[0]->answer) : null; ?>
                                    <b>{{ $value->qsn_name }} :-</b> &nbsp;&nbsp;
                                    @foreach ($value->questionOption as $option)
                                        {{ $option->option_name }} :&nbsp;&nbsp;
                                        {{ $result2 != null ? $result2[$option->id] : '' }};&nbsp;&nbsp;
                                    @endforeach
                                @endforeach
                            </td>
                        @elseif($ans->ans_type == 'sector')
                            <td>{{ $answer['sectors'][$ans->answer[0]->answer] }}</td>
                        @elseif($ans->ans_type == 'cond_radio')
                            <td>

                                @foreach ($ans->questionOption as $option)
                                    @if ($option->option_name == 'No' && $ans->qsn_number == 9)
                                        @if ($ans->answer[0]->qsn_opt_id == $option->id)
                                            {{ $option->option_name }} -
                                        @endif
                                        @if ($ans->children != null)
                                            @foreach ($ans->children as $child)
                                                @if (count($child->answer) > 0)
                                                    {!! $child->answer[0]->answer !!}
                                                @endif
                                            @endforeach
                                        @endif
                                    @elseif($option->option_name == 'Yes' && $ans->qsn_number == 12)
                                        @if ($ans->answer[0]->qsn_opt_id == $option->id)
                                            {{ $option->option_name }} -
                                        @endif
                                        @if ($ans->children != null)
                                            @foreach ($ans->children as $child)
                                                @foreach ($child->questionOption as $key => $value)
                                                    @if ($child->answer[0]->qsn_opt_id == $value->id)
                                                        {{ $value->option_name }}
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endif
                                    @else
                                        @if ($ans->answer[0]->qsn_opt_id == $option->id)
                                            {{ $option->option_name }}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                        @else
                            <td></td>
                        @endif
                    @elseif($ans->ans_type == 'sub_qsn')
                        <td>
                            @foreach ($ans->children as $key => $value)
                                <?php $result2 = count($value->answer) > 0 ? (array) json_decode($value->answer[0]->answer) : null; ?>
                                <b>{{ $value->qsn_name }} :-</b> &nbsp;&nbsp;
                                @foreach ($value->questionOption as $option)
                                    {{ $option->option_name }} :&nbsp;&nbsp;
                                    {{ $result2 != null ? $result2[$option->id] : '' }};&nbsp;&nbsp;
                                @endforeach
                            @endforeach
                        </td>
                    @else
                        <td></td>
                    @endif
                @endforeach

            </tr>
        @endforeach
    </tbody>
</table>
