@if ($other_answer != null)
    {!! Form::hidden('sub_qsn_id', $other_answer->id, ['class' => 'form-control ']) !!}
@endif
@if ($question->children != null)
    <div id="employment" style="display:{{ $answer != null && $answer->qsn_opt_id == 55 ? 'block' : 'none' }}">
        @foreach ($question->children as $child)
            <label class="text-left"> {{ $child->qsn_name }}</label><br>
            @foreach ($child->questionOption as $key => $value)
                <ul class="list-group">

                    <li class="mx-3 list-group-item border-0">
                        {{ Form::radio("optionalAnswer[$child->id]", $value->id, $other_answer != null && $value->id == $other_answer->qsn_opt_id ? true : false, ['class' => 'form-check-input', 'id' => $value->option_name]) }}
                        {{ $value->option_name }}

                    </li>
                </ul>
            @endforeach
        @endforeach
    </div>
@endif
