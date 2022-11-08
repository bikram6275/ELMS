@foreach ($recent_questions as $question)
{!! Form::hidden('qsn_id', $question->id, ['class' => 'form-control ']) !!}

@if ($question->ans_type == 'input')
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label>
        {!! Form::text('answer', $answer != null ? $answer->answer : null, ['class' => 'form-control', $question->required == 'yes' ? 'required' : null]) !!}
    </div>


@elseif($question->ans_type=="radio")
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12 form-check">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label><br>
        <ul class="list-group ">
            @foreach ($question->questionOption as $key => $value)

                <li class="mx-3 list-group-item border-0">
                    {{ Form::radio('answer', $value->id, $answer != null && $answer->qsn_opt_id == $value->id ? true : false, ['class' => 'form-check-input', 'id' => $value->option_name, $question->required == 'yes' ? 'required' : null, 'onClick' => "showOtherRadio('$value->option_type')"]) }}
                    {{ $value->option_name }}<br>
                </li>
                @if ($value->option_type == 'others')
                    <div class="form-group col-md-6"
                        style="display: {{ $answer != null && $answer->other_answer != null ? 'block' : 'none' }}"
                        id="other_value_radio">

                        {!! Form::text('other_answer', $answer != null ? $answer->other_answer : null, ['class' => 'form-control', 'id' => "other_answer_radio_$value->id"]) !!}
                    </div>
                @endif
            @endforeach
        </ul>
    </div>

@elseif($question->ans_type=="checkbox")
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <?php $result = $answer != null ? explode(',', $answer->answer) : null; ?>
    <div class="form-group col-md-12 form-check">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label><br>

        <ul class="list-group ">
            @foreach ($question->questionOption as $key => $value)

                <li class="mx-3 list-group-item border-0">
                    {{ Form::checkbox('answer[]', $value->id, $result != null && in_array($value->id, $result) ? 'checked' : '', ['class' => 'form-check-input', 'onClick' => "showOtherField($question->id,'$value->option_type',this)"]) }}
                    {{ $value->option_name }}
                </li>
                @if ($value->option_type == 'others')
                    <div class="form-group col-md-6"
                        style="display: {{ $answer != null && $answer->other_answer != null ? 'block' : 'none' }}"
                        id="other_value">
                        {!! Form::text('other_answer', $answer != null ? $answer->other_answer : null, ['class' => 'form-control', 'id' => 'other_answer']) !!}
                    </div>
                @endif

            @endforeach
        </ul>
    </div>
@elseif($question->ans_type=='multiple_input')
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <?php $result1 = $answer != null ? (array) json_decode($answer->answer) : null; ?>
    <div class="col-md-12">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label>
        <ul class="list-group">
            @foreach ($question->questionOption as $key => $value)
                <li class="mx-3 list-group-item border-0">
                    <label
                        class="{{ $question->qsn_number == 19 ? 'col-sm-6' : 'col-sm-1' }}">{{ $value->option_number }}.
                        {{ $value->option_name }}</label>
                    {!! Form::text("answer[$value->id]", $result1 != null ? $result1[$value->id] : null, ['class' => 'col-sm-4 ml-2']) !!}

                </li>
            @endforeach
        </ul>
    </div>
@elseif($question->ans_type=='sub_qsn')
    <div class="col-md-12 ">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label><br>
        @foreach ($question->children as $key => $sub_qsn)
            <label class="mx-3"> {{ $sub_qsn->qsn_number }}. {{ $sub_qsn->qsn_name }}</label><br>

            @if ($sub_qsn->ans_type == 'multiple_input')
                @foreach ($sub_qsn->questionOption as $key => $value)

                    <?php $result2 = $answer != null && isset($answer[$sub_qsn->id]) ? (array) json_decode($answer[$sub_qsn->id]->answer) : null; ?>
                    @if ($answer != null && isset($answer[$sub_qsn->id]))
                        {!! Form::hidden("answer[$sub_qsn->id][id]", $answer[$sub_qsn->id]->id, ['class' => 'form-control ']) !!}
                    @endif

                    <div class="form-group row mx-5 mt-3 ">
                        <label class="col-sm-6">{{ $value->option_number }}.
                            {{ $value->option_name }}</label>
                        {{ Form::text("answer[$sub_qsn->id][data][$value->id]", $result2 != null ? $result2[$value->id] : null, ['class' => 'form-control col-sm-6']) }}
                    </div>
                @endforeach
            @endif
        @endforeach

    </div>

@elseif($question->ans_type=='sector')
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label>

        {{ Form::select('answer', $sectors->pluck('sector_name', 'id'), $answer != null ? $answer->answer : null, ['class' => 'form-control select2', 'style' => 'width:100%;', 'id' => 'sector1', 'placeholder' => 'Select Sector', 'required']) }}

    </div>

@elseif($question->ans_type=="external_table" && $question->qsn_number=='5')
    <div class="form-group col-md-12">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label>
        @include('admin.formLayout.human_resource')
    </div>

@elseif($question->ans_type=="external_table" && $question->qsn_number=='6.a')
    <div class="form-group col-md-12" style="overflow-x:auto;">
        <label>{{ $question->qsn_number }}. {{ $question->qsn_name }}</label>
        @include('admin.formLayout.technical_HR')
    </div>
@elseif($question->ans_type=="external_table" && $question->qsn_number=='6.b')
    <div class="form-group col-md-12" style="overflow-x:auto;">
        <label>{{ $question->qsn_number }}. {{ $question->qsn_name }}</label>
        @include('admin.formLayout.occupation_status')
    </div>
@elseif($question->ans_type=="external_table" && $question->qsn_number=='13')
    <div class="form-group col-md-12" style="overflow-x:auto;">
        <label>{{ $question->qsn_number }}. {{ $question->qsn_name }}</label>
        @include('admin.formLayout.worker_skill_rating')
    </div>

@elseif($question->ans_type=="cond_radio")
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12">
        <label> {{ $question->qsn_number }}. {{ $question->qsn_name }}</label><br>
        <ul class="list-group ">
            @foreach ($question->questionOption as $key => $value)

                <li class="mx-3 list-group-item border-0">
                    {{ Form::radio('answer', $value->id, $answer != null && $answer->qsn_opt_id == $value->id ? true : false, ['class' => 'minimal-red', 'onChange' => "changeTable('$value->option_name',$question->qsn_number)"]) }}
                    {{ $value->option_name }}<br>
                </li>

            @endforeach
        </ul>

        @if ($question->qsn_number == 8)
            <div style="display:{{ $answer != null && $answer->qsn_opt_id == 38 ? 'block' : 'none' }}"
                id="other_table">
                @include('admin.formLayout.other_occupation')
            </div>

        @elseif($question->qsn_number==9)
            @if ($other_answer != null)
                {!! Form::hidden('sub_qsn_id', $other_answer->id, ['class' => 'form-control ']) !!}

            @endif
            @if ($question->children != null)
                <div id="optional"
                    style="display:{{ $answer != null && $answer->qsn_opt_id == 40 ? 'block' : 'none' }}">
                    @foreach ($question->children as $child)

                        <label class="text-left"> {{ $child->qsn_name }}</label><br>
                        {!! Form::text("optionalAnswer[$child->id]", $other_answer != null ? $other_answer->answer : null, ['class' => 'form-control col-md-6 ml-2']) !!}

                    @endforeach
                </div>
            @endif
        @elseif($question->qsn_number==12)
            @include('admin.formLayout.employment')
        @endif
    </div>

@endif

@endforeach
@push('custom-scripts')

<script>
    function changeTable(name, qsn_no, options = null) {
        if (qsn_no == 8 && name == 'Yes') {
            $('#other_table').show();
        } else {
            $('#other_table').hide();

        }
        if (qsn_no == 9 && name == 'Yes') {
            $('#optional').show();
        } else {
            $('#optional').hide();

        }
        if (qsn_no == 12 && name == 'Yes') {
            $('#employment').show();
        } else {
            $('#employment').hide();

        }
    }
</script>
<script>
    function showOtherRadio(option_type) {
        console.log(option_type);
        if (option_type == 'others') {
            $('#other_value_radio').show();

        } else {
            console.log('dsdf');
            $('#other_value_radio').hide();
           //  $('#other_answer_radio').val('');


        }

    }
</script>
<script>
    const temp = [];

    function showOtherField(qsn_no, option, checkedEle) {
        if (checkedEle.checked) {
            temp.push(option);

        } else {
            var index = temp.indexOf(option);
            temp.splice(index, 1);
        }

        if (temp.includes('others')) {
            $('#other_value').show();

        } else {
            $('#other_value').hide();
            $('#other_answer').val('');

        }
    }
</script>

@endpush
