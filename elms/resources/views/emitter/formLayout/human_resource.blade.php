<table class="table table-bordered">
    <thead class="text-center ">
        <tr>
            <th rowspan="2" style="vertical-align: middle">S.N</th>
            <th colspan="2" rowspan="2" style="vertical-align: middle">Nature of Human Resources</th>
            <th colspan="3">Gender</th>
            <th colspan="3">Nationality</th>
            <th rowspan="2" style="vertical-align: middle">Total Staff</th>
        </tr>
        <tr>
            <th>Male</th>
            <th>Female</th>
            <th>Sexual Minority</th>
            <th>Nepali</th>
            <th>Neighboring Countries</th>
            <th>Foreigner</th>

        </tr>
    </thead>
    <tbody>
        @php $i=1; @endphp

        @php
            if($recent_questions->qsn_number!='5.3')
            {
                unset($workers['assisting']);

            }
            
        @endphp
        @foreach ($workers as $key1 => $worker)
            <tr>
                {!! Form::hidden("human_resource[$key1][id]", $answer != null && (isset($answer) && isset($answer[$key1])) ? $answer[$key1][0]['id'] : 0, ['class' => 'form-control ']) !!}

                <td>{{ $i++ }}</td>
              
                <td colspan="2">{{ $worker }}</td>
                <td>
                    {{-- {{ dd($answer[$key1]) }} --}}
                    {!! Form::number("human_resource[$key1][male_count]", $answer != null && (isset($answer[$key1]) && isset($answer[$key1])) ? $answer[$key1][0]['male_count'] : 0, ['class' => 'form-control male ', 'min' => 0, 'id' => "male_$key1", 'onblur' => "generalTotal('$key1','male')"]) !!}
                    {!! $errors->first("human_resource.$key.$key1.male_count", '<span class="text-danger">:message</span>') !!}

                </td>
                <td>
                    {!! Form::number("human_resource[$key1][female_count]", $answer != null && (isset($answer[$key1]) && isset($answer[$key1])) ? $answer[$key1][0]['female_count'] : 0, ['class' => 'form-control ', 'min' => 0, 'id' => "female_$key1", 'onblur' => "generalTotal('$key1','female')"]) !!}
                    {!! $errors->first("human_resource.$key.$key1.female_count", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>
                    {!! Form::number("human_resource[$key1][minority_count]", $answer != null && (isset($answer[$key1]) && isset($answer[$key1])) ? $answer[$key1][0]['minority_count'] : 0, ['class' => 'form-control', 'min' => 0, 'id' => "minority_$key1", 'onblur' => "generalTotal('$key1','minority')"]) !!}
                    {!! $errors->first("human_resource.$key.$key1.minority_count", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>
                    {!! Form::number("human_resource[$key1][nepali_count]", $answer != null && (isset($answer[$key1]) && isset($answer[$key1])) ? $answer[$key1][0]['nepali_count'] : 0, ['class' => 'form-control', 'min' => 0, 'id' => "nepali_$key1", 'onblur' => "generalTotal('$key1','nepali')"]) !!}
                    {!! $errors->first("human_resource.$key.$key1.nepali_count", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>
                    {!! Form::number("human_resource[$key1][neighboring_count]", $answer != null && (isset($answer[$key1]) && isset($answer[$key1])) ? $answer[$key1][0]['neighboring_count'] : 0, ['class' => 'form-control', 'min' => 0, 'id' => "neighboring_$key1", 'onblur' => "generalTotal('$key1','neighboring')"]) !!}
                    {!! $errors->first("human_resource.$key.$key1.neighboring_count", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>
                    {!! Form::number("human_resource[$key1][foreigner_count]", $answer != null && (isset($answer[$key1]) && isset($answer[$key1])) ? $answer[$key1][0]['foreigner_count'] : 0, ['class' => 'form-control', 'min' => 0, 'id' => "foreigner_$key1", 'onblur' => "generalTotal('$key1','foreigner')"]) !!}
                    {!! $errors->first("human_resource.$key.$key1.foreigner_count", '<span class="text-danger">:message</span>') !!}
                </td>
                <td>
                    {!! Form::number("human_resource[$key1][total]", $answer != null && (isset($answer[$key1]) && isset($answer[$key1])) ? $answer[$key1][0]['total'] : 0, ['class' => 'form-control ', 'readonly', 'id' => "total_$key1"]) !!}
                    {!! $errors->first("human_resource.$key.$key1.total", '<span class="text-danger">:message</span>') !!}
                </td>
            </tr>
        @endforeach
        {{-- @endforeach --}}
        <tr>
            <td colspan="3" style="text-align: center">Total</td>
            <td>{!! Form::number('total_male', 0, ['class' => 'form-control ', 'readonly', 'id' => 'male_total']) !!}</td>
            <td>{!! Form::number('total_female', 0, ['class' => 'form-control ', 'readonly', 'id' => 'female_total']) !!}</td>
            <td>{!! Form::number('total_minority', 0, ['class' => 'form-control ', 'readonly', 'id' => 'minority_total']) !!}</td>
            <td>{!! Form::number('total_nepali', 0, ['class' => 'form-control ', 'readonly', 'id' => 'nepali_total']) !!}</td>
            <td>{!! Form::number('total_neighboring', 0, ['class' => 'form-control ', 'readonly', 'id' => 'neighboring_total']) !!}</td>
            <td>{!! Form::number('total_foreigner', 0, ['class' => 'form-control ', 'readonly', 'id' => 'foreigner_total']) !!}</td>
            <td>{!! Form::number('grand_total1', 0, ['class' => 'form-control ', 'readonly', 'id' => 'grand_total']) !!}</td>

        </tr>

    </tbody>
</table>
@push('custom-scripts')
    <script>
        var humanresources = {!! json_encode($humanResources) !!};
        var workers = {!! json_encode($workers) !!};
        var $qsn = {!! $recent_questions->qsn_number !!}
        var names = ['male', 'female', 'minority', 'nepali', 'neighboring', 'foreigner', ];
        $(document).ready(function() {
            if($qsn!='5.3')
            {
                delete workers.assisting;

            }
            for (const key2 in workers) {
                for (const key3 in names) {
                    generalTotal(key2, names[key3]);
                }
            }

            grandTotal();
        });

        function grandTotal() {
            var total = 0
            if($qsn!='5.3')
            {
                delete workers.assisting;

            }
            for (const key2 in workers) {
                total += parseInt($('#total_' + key2).val());
                $('#grand_total').val(total);

            }

        }

        function checkStatus(key2) {

            var nepali_count = parseInt($('#nepali_' + key2).val());
            var neighboring_count = parseInt($('#neighboring_' + key2).val());
            var foreigner_count = parseInt($('#foreigner_' + key2).val());

            var male_count = parseInt($('#male_' + key2).val());
            var female_count = parseInt($('#female_' + key2).val());
            var minority_count = parseInt($('#minority_' + key2).val());

            var total_nationality = nepali_count + neighboring_count + foreigner_count;
            var total_gender = male_count + female_count + minority_count;

            if (total_nationality != total_gender) {
                $('#nepali_' + key2).css('border-color', 'red');
                $('#neighboring_' + key2).css('border-color', 'red');
                $('#foreigner_' + key2).css('border-color', 'red');
                $('#male_' + key2).css('border-color', 'red');
                $('#female_' + key2).css('border-color', 'red');
                $('#minority_' + key2).css('border-color', 'red');
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#nepali_' + key2).css('border-color', '');
                $('#neighboring_' + key2).css('border-color', '');
                $('#foreigner_' + key2).css('border-color', '');
                $('#male_' + key2).css('border-color', '');
                $('#female_' + key2).css('border-color', '');
                $('#minority_' + key2).css('border-color', '');
                $('#submitBtn').prop('disabled', false);

            }


        }

        function totalStaff(key2) {
            var nepali_count = $('#nepali_' + key2).val();
            var neighboring_count = $('#neighboring_' + key2).val();
            var foreigner_count = $('#foreigner_' + key2).val();
            total = parseInt(neighboring_count) + parseInt(nepali_count) + parseInt(foreigner_count);
            $('#total_' + key2).val(total);

            checkStatus(key2);

        }

        function generalTotal(key2, name) {
            totalStaff(key2);
            var total = 0
            if($qsn!='5.3')
            {
                delete workers.assisting;

            }

            for (const key2 in workers) {
                total += parseInt($('#' + name + '_' + key2).val());
                $('#' + name + '_total').val(total);
            }

            grandTotal();
        }
    </script>
@endpush
