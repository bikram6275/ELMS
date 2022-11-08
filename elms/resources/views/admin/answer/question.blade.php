{!! Form::hidden('qsn_id', $recent_questions->id, ['class' => 'form-control ']) !!}

@if ($recent_questions->ans_type == 'input')
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
        @if ($recent_questions->qsn_number == 22)
            {!! Form::textarea('answer', $answer != null ? $answer->answer : null, ['class' => 'form-control', $recent_questions->required == 'yes' ? 'required' : null, 'rows' => 5]) !!}
        @else
            {!! Form::text('answer', $answer != null ? $answer->answer : null, ['class' => 'form-control', $recent_questions->required == 'yes' ? 'required' : null]) !!}
        @endif
    </div>


@elseif($recent_questions->ans_type=="radio")
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12 form-check">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label><br>
        <ul class="list-group ">
            @foreach ($recent_questions->questionOption as $key => $value)

                <li class="mx-3 list-group-item border-0">
                    {{ Form::radio('answer', $value->id, $answer != null && $answer->qsn_opt_id == $value->id ? true : false, ['class' => 'form-check-input', 'id' => $value->option_name, $recent_questions->required == 'yes' ? 'required' : null, 'onClick' => "showOtherRadio('$value->option_type')"]) }}
                    {{ $value->option_name }}<br>
                </li>
                @if ($recent_questions->qsn_number != 21 && $value->option_type == 'others')
                    <div class="form-group col-md-6"
                        style="display: {{ $answer != null && $answer->other_answer != null ? 'block' : 'none' }}"
                        id="other_value_radio">

                        {!! Form::text('other_answer', $answer != null ? $answer->other_answer : null, ['class' => 'form-control', 'id' => "other_answer_radio_$value->id"]) !!}
                    </div>

                @endif
            @endforeach
            @if ($recent_questions->qsn_number == 21)
                <div class="form-group col-md-6">

                    {!! Form::text('other_answer', $answer != null ? $answer->other_answer : null, ['class' => 'form-control']) !!}
                </div>
            @endif
        </ul>
    </div>

@elseif($recent_questions->ans_type=="checkbox")
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
   
    <?php $result = $answer != null ? explode(',', $answer->answer) : null; ?>
    <div class="form-group col-md-12 form-check">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label><br>

        <ul class="list-group ">
          
            @foreach ($recent_questions->questionOption as $key => $value)

                <li class="mx-3 list-group-item border-0">
                    {{ Form::checkbox('answer[]', $value->id, $result != null && in_array($value->id, $result) ? 'checked' : '', ['class' => 'form-check-input','id' => $value->option_name, 'class'=>'checkbox_option' , 'onClick' => "showOtherField($recent_questions->id,'$value->option_type',this)",'required'=>'required']) }}
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
@elseif($recent_questions->ans_type=='multiple_input')
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <?php $result1 = $answer != null ? (array) json_decode($answer->answer) : null; ?>
    <div class="col-md-12">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
        <ul class="list-group">
            @foreach ($recent_questions->questionOption as $key => $value)
                <li class="mx-3 list-group-item border-0">
                    <label
                        class="{{ $recent_questions->qsn_number == 20 || $recent_questions->qsn_number == 12 ? 'col-sm-6' : 'col-sm-1' }}">{{ $value->option_number }}.
                        {{ $value->option_name }}</label>
                    @if ($recent_questions->qsn_number == 12)
                        {!! Form::number("answer[$value->id]", $result1 != null ? $result1[$value->id] : null, ['class' => ' col-sm-4 ml-2 no_duplicate', 'min' => 1, 'max' => 4,'id'=>"duplicateinput-$loop->index"]) !!}
                    @elseif ($recent_questions->qsn_number == 20)
                        {!! Form::number("answer[$value->id]", $result1 != null && array_key_exists($value->id,$result1)? $result1[$value->id] : null, ['class' => ' col-sm-4 ml-2 no_duplicate','id'=>"duplicateinput-$loop->index"]) !!}
                    @else
                        {!! Form::text("answer[$value->id]", $result1 != null ? $result1[$value->id] : null, ['class' => ' col-sm-4 ml-2 no_duplicate']) !!}
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
@elseif($recent_questions->ans_type=='sub_qsn')
    <div class="col-md-12 ">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label><br>
        @foreach ($recent_questions->children as $key => $sub_qsn)
            <label class="mx-3"> {{ $sub_qsn->qsn_number }}. {{ $sub_qsn->qsn_name }}</label><br>

            @if ($sub_qsn->ans_type == 'multiple_input')
                @foreach ($sub_qsn->questionOption as $key => $value)

                    <?php $result2 = $answer != null && isset($answer[$sub_qsn->id]) ? (array) json_decode($answer[$sub_qsn->id]->answer) : null; 
                       $nepali_date = DB::table('nepali_years')->where('status','active')->get();
                    ?>
                    @if ($answer != null && isset($answer[$sub_qsn->id]))
                        {!! Form::hidden("answer[$sub_qsn->id][id]", $answer[$sub_qsn->id]->id, ['class' => 'form-control ']) !!}
                    @endif

                    <div class="form-group row mx-5 mt-3 ">
                        <label class="col-sm-6">{{ $value->option_number }}.
                            {{ $value->option_name }}</label>
                        {{-- {{ Form::text("answer[$sub_qsn->id][data][$value->id]", $result2 != null ? $result2[$value->id] : null, ['class' => 'form-control col-sm-6', 'id' => "$sub_qsn->qsn_name$value->option_name", 'onchange' => "checkMembership('$sub_qsn->qsn_name')"]) }} --}}
                        {{ Form::select("answer[$sub_qsn->id][data][$value->id]", $nepali_date->pluck('year', 'id'), $result2 != null ? $result2[$value->id] : null, ['class' => 'form-control select2 col-sm-5', 'id' => "$sub_qsn->qsn_name$value->option_name", 'placeholder' => 'Select Year']) }}

                    </div>
                @endforeach
            @endif
        @endforeach

    </div>

@elseif($recent_questions->ans_type=='sector')
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>

        {{ Form::select('answer', $sectors->pluck('sector_name', 'id'), $answer != null ? $answer->answer : null, ['class' => 'form-control select2', 'style' => 'width:100%;', 'id' => 'sector1', 'placeholder' => 'Select Sector', 'required']) }}

    </div>
@elseif($recent_questions->ans_type=='services')
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <?php $result = $answer != null ? explode(',', $answer->answer) : null; ?>
    <div class="form-group col-md-12">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
        @if ($serviceList != null)
            <ul class="list-group ">
                @foreach ($serviceList as $key => $value)

                    <li class="mx-3 list-group-item border-0">
                        {{ Form::checkbox('answer[]', $value->id, $result != null && in_array($value->id, $result) ? 'checked' : '', ['class' => 'form-check-input']) }}
                        {{ $value->product_and_services_name }}
                    </li>

                @endforeach
                <li class="mx-3 list-group-item border-0">
                   {{ Form::checkbox('others', 'others', $answer != null && $answer->other_answer ? 'checked' : '', ['class' => 'form-check-input','onClick' => "showOtherField($recent_questions->id,'others',this)"]) }}
                   Others
                </li>

                   <div class="form-group col-md-6"
                        style="display: {{ $answer != null && $answer->other_answer != null ? 'block' : 'none' }}"
                        id="other_value">
                        {!! Form::text('other_answer', $answer != null ? $answer->other_answer : null, ['class' => 'form-control', 'id' => 'other_answer']) !!}
                    </div>
            </ul>
        @endif

    </div>

@elseif($recent_questions->ans_type=="external_table" && ($recent_questions->qsn_number=='5.1'||$recent_questions->qsn_number=='5.2'||$recent_questions->qsn_number=='5.3'))
    <div class="form-group col-md-12">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
        @include('admin.formLayout.human_resource')
    </div>
{{-- @elseif($recent_questions->ans_type=="external_table" && $recent_questions->qsn_number=='5.2')
   <div class="form-group col-md-12">
       <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
       @include('admin.formLayout.human_resource')
   </div> --}}

@elseif($recent_questions->ans_type=="external_table" && $recent_questions->qsn_number=='6.a')
    <div class="form-group col-md-12 " style="overflow-x:auto;">
        <label>{{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
        @include('admin.formLayout.technical_HR')
    </div>
@elseif($recent_questions->ans_type=="external_table" && $recent_questions->qsn_number=='6.b')
    <div class="form-group col-md-12" style="overflow-x:auto;">
        <label>{{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
        @include('admin.formLayout.occupation_status')
    </div>
@elseif($recent_questions->ans_type=="external_table" && $recent_questions->qsn_number=='13')
    <div class="form-group col-md-12" style="overflow-x:auto;">
        <label>{{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label>
        @include('admin.formLayout.worker_skill_rating')
    </div>



@elseif($recent_questions->ans_type=="cond_radio")
    @if ($answer != null)
        {!! Form::hidden('id', $answer->id, ['class' => 'form-control ']) !!}
    @endif
    <div class="form-group col-md-12">
        <label> {{ $recent_questions->qsn_number }}. {{ $recent_questions->qsn_name }}</label><br>
        <ul class="list-group ">
            @foreach ($recent_questions->questionOption as $key => $value)

                <li class="mx-3 list-group-item border-0">
                    {{ Form::radio('answer', $value->id, $answer != null && $answer->qsn_opt_id == $value->id ? true : false, ['class' => 'minimal-red', 'onChange' => "changeTable('$value->option_type',$recent_questions->qsn_number)"]) }}
                    {{ $value->option_name }}<br>
                </li>

            @endforeach
        </ul>

        @if ($recent_questions->qsn_number == 8)
            <div style="display:{{ $answer != null && $answer->qsn_opt_id == 38 ? 'block' : 'none' }}"
                id="other_table">
                @include('admin.formLayout.other_occupation')
            </div>

        @elseif($recent_questions->qsn_number==9)
            @if ($other_answer != null)
                {!! Form::hidden('sub_qsn_id', $other_answer->id, ['class' => 'form-control ']) !!}

            @endif
            @if ($recent_questions->children != null)
                <div id="optional"
                    style="display:{{ $answer != null && $answer->qsn_opt_id == 41 ? 'block' : 'none' }}">
                    @foreach ($recent_questions->children as $child)

                        <label class="text-left"> {{ $child->qsn_name }}</label><br>
                        {!! Form::text("optionalAnswer[$child->id]", $other_answer != null ? $other_answer->answer : null, ['class' => 'form-control col-md-6 ml-2']) !!}

                    @endforeach
                </div>
            @endif
        @elseif($recent_questions->qsn_number==17)
            @if ($recent_questions->children != null)
                <div style="display:{{ $answer != null && $answer->qsn_opt_id == 73 ? 'block' : 'none' }}"
                    id="technology_table">
                    @foreach ($recent_questions->children as $child)

                        <label class="text-left"> {{ $child->qsn_name }}</label><br>
                        @include('admin.formLayout.technology')
                    @endforeach
                </div>
            @endif
        @elseif($recent_questions->qsn_number==18)

            <div style="display:{{ $answer != null && $answer->qsn_opt_id == 89 ? 'block' : 'none' }}"
                id="skilled">
                <div class="form-group col-md-12" style="overflow-x:auto;">
                    @include('admin.formLayout.skilled_workers')
                </div>
            </div>
        @endif
    </div>

@endif

@push('custom-scripts')

    <script>
        function changeTable(name, qsn_no, options = null) {
            if (qsn_no == 8 && name == 'cond_radio') {
                $('.occ-required').attr('required', 'required');
                $('#other_table').show();
            } else {
                $('.occ-required').removeAttr('required');
                $('#other_table').hide();

            }
            if (qsn_no == 9 && name == 'cond_radio') {
                $('#optional').show();
            } else {
                $('#optional').hide();

            }
            if (qsn_no == 17 && name == 'cond_radio') {
               $('.tech-required').attr('required', 'required');
                $('#technology_table').show();
            } else {
               $('.tech-required').removeAttr('required');
                $('#technology_table').hide();

            }
            if (qsn_no == 18 && name == 'cond_radio') {
                $('.add-required').attr('required', 'required');
                $('#skilled').show();
            } else {
                $('.add-required').removeAttr('required');

                $('#skilled').hide();

            }
        }
    </script>
    <script>
        function showOtherRadio(option_type) {
            if (option_type == 'others') {
                $('#other_value_radio').show();

            } else {
                $('#other_value_radio').hide();
                $('#other_answer_radio').val('');
            }
        }
    </script>
    <script>
        const temp = [];
        $(document).ready(function() {
            var question = {!! json_encode($recent_questions) !!};
            $('input[type="checkbox"]:checked').each(function() {
               $('.checkbox_option').removeAttr('required');

                for (const key in question.question_option) {
                    if ($(this).val() == question.question_option[key]['id']) {
                        temp.push(question.question_option[key]['option_type']);
                    }

                }
            });

        });

        function showOtherField(qsn_no, option, checkedEle) {
            if (checkedEle.checked) {
                temp.push(option);
                $('.checkbox_option').removeAttr('required');

            } else {

                var index = temp.indexOf(option);
                temp.splice(index, 1);
            }
            if (temp.includes('others')) {
                   $('#other_answer').attr('required','required');

                   $('#other_value').show();

            } else {
                   $('#other_answer').removeAttr('required');
                   $('#other_value').hide();
                   $('#other_answer').val('');
            }
        }
    </script>
    <script>
        $('#question_form').submit(function (evt) {

           var qsn_id= {{ $qsn_id }}
           var input=[];  
           var input1=[];  
           var input2=[];  
           $(".no_duplicate").each(function(i,j){

               if(qsn_id == 27)
               {
                   input1[i] = $('#trained-'+i).val()
                   
                   input2[i] = $('#untrained-'+i).val();

               }
               else{
                   input[i] = $('#duplicateinput-'+ i).val();

               }
               
           });
           let filterundefined = arr => arr.filter((item, index) => item !== undefined)
           
           input1 = filterundefined(input1);
           input2 = filterundefined(input2);

           let findDuplicates = arr => arr.filter((item, index) => arr.indexOf(item) != index)
           

           if(findDuplicates(input).length > 0){
               evt.preventDefault();
               alert('Duplicate rank ' +findDuplicates(input) + '. No duplicates are allowed');
           } 
           if(findDuplicates(input1).length > 0){
               evt.preventDefault();
               alert('Duplicate rank ' +findDuplicates(input1) + ' in trained . No duplicates are allowed');
           } 
           if(findDuplicates(input2).length > 0){
               evt.preventDefault();
               alert('Duplicate rank ' +findDuplicates(input2) + ' in untrained. No duplicates are allowed');
           } 
       });
   </script>

@endpush
