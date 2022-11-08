<table class="table table-bordered" id=resourceTable>
    <thead class="text-center">
        <tr>
            <th rowspan="2" style="vertical-align: middle;">Employee Name</th>
            <th rowspan="2" style="vertical-align: middle;">Gender</th>
            <th rowspan="2" style="vertical-align: middle; ">Occupations</th>
            <th rowspan="2" style="vertical-align: middle ; ">Working Hours</th>
            <th rowspan="2" style="vertical-align: middle ;">Nature of Work</th>
            <th rowspan="2" style="vertical-align: middle ;">Training</th>
            <th rowspan="2" style="vertical-align: middle ; ">OJT/Apprentice</th>
            <th rowspan="2" style="vertical-align: middle ;">Educational Qualification General</th>
            <th rowspan="2" style="vertical-align: middle ;">Educational Qualification TVET</th>
            <th colspan="2">Work Experience(In Years)</th>
            <th rowspan="2" style="vertical-align: middle">Action</th>
        </tr>
        <tr>
            <th>In present position</th>
            <th>In this Occupation</th>
        </tr>
    </thead>
    <tbody>

        @if (Request::old('technical') != null)
            @foreach (Request::old('technical') as $key => $value)
                <tr>
                    {!! Form::hidden("technical[$key][id]", isset($value['id']) ? $value['id'] : 0, ['class' => 'form-control ', 'style' => 'width:100%;']) !!}
                    <td>{!! Form::text("technical[$key][emp_name]", $value['emp_name'], ['class' => 'form-control ']) !!}
                        {!! $errors->first("technical.$key.emp_name", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{{ Form::select(
                        "technical[$key][gender]",
                        ['male' => 'Male', 'female' => 'Female', 'sexual_minority' => 'Sexual Minority'],
                        $value['gender'],
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "gender_$key",
                            'placeholder' => 'Select Gender',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.gender", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{!! Form::select("technical[$key][occupation_id]", $occupations->pluck('occupation_name', 'id'), $value['occupation_id'], ['class' => 'form-control  select2 occupation', 'style' => 'width:100%;', 'id' => "occupation_$key", 'placeholder' => 'Select Occupation', 'onChange' => 'otherOccupation(this)']) !!}

                        {!! $errors->first("technical.$key.occupation_id", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{{ Form::select(
                        "technical[$key][working_time]",
                        ['full' => 'Full Time', 'part' => 'Part Time'],
                        $value['working_time'],
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "working_time_$key",
                            'placeholder' => 'Select Working Time',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.working_time", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{{ Form::select(
                        "technical[$key][work_nature]",
                        ['regular' => 'Regular', 'seasonal' => 'Seasonal'],
                        $value['work_nature'],
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "work_nature_$key",
                            'placeholder' => 'Select Work Nature',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.work_nature", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{{ Form::select(
                        "technical[$key][training]",
                        ['trained' => 'Trained', 'untrained' => 'Untrained'],
                        $value['training'],
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "training_$key",
                            'placeholder' => 'Select Training',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.training", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{!! Form::select("technical[$key][ojt_apprentice]", ['ojt' => 'OJT', 'apprentice' => 'Apprentice', 'none' => 'None'], $value['ojt_apprentice'], ['class' => 'form-control ', 'placeholder' => 'Select One']) !!}
                        {!! $errors->first("technical.$key.ojt_apprentice", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{{ Form::select(
                        "technical[$key][edu_qua_general]",
                        $educations['general']->pluck('name', 'id'),
                        $value['edu_qua_general'],
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "type_$key",
                            'placeholder' => 'Select Education Type',
                            'onChange' => 'changeEducation()',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.edu_qua_general", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{{ Form::select(
                        "technical[$key][edu_qua_tvet]",
                        $educations['tvet']->pluck('name', 'id'),
                        $value['edu_qua_tvet'] != null ? $value['edu_qua_tvet'] : null,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "edu_$key",
                            'placeholder' => ' Select Educational Qualification',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.edu_qua_tvet", '<span class="text-danger">:message</span>') !!}
                    </td>

                    <td>{!! Form::text("technical[$key][work_exp1]", $value['work_exp1'], ['class' => 'form-control ']) !!}
                        {!! $errors->first("technical.$key.work_exp1", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{!! Form::text("technical[$key][work_exp2]", $value['work_exp2'], ['class' => 'form-control ']) !!}
                        {!! $errors->first("technical.$key.work_exp2", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>
                        @if ($loop->first)
                            <button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i
                                    class="fas fa-plus"></i></button>
                        @else
                            <button class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button>
                        @endif
                    </td>

                </tr>
            @endforeach
        @elseif(count($answer) > 0)
            @foreach ($answer as $key => $value)
                {{-- {{ dd($answer) }} --}}
                <tr>
                    {!! Form::hidden("technical[$key][id]", $value->id, ['class' => 'form-control ', 'style' => 'width:100%;']) !!}
                    <td>{!! Form::text("technical[$key][emp_name]", $value->emp_name, ['class' => 'form-control ']) !!}
                        {!! $errors->first("technical.$key.emp_name", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{{ Form::select(
                        "technical[$key][gender]",
                        ['male' => 'Male', 'female' => 'Female', 'sexual_minority' => 'Sexual Minority'],
                        $value->gender,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "gender_$key",
                            'placeholder' => 'Select Gender',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.gender", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{!! Form::select("technical[$key][occupation_id]", $occupations->pluck('occupation_name', 'id'), $value->occupation_id, ['class' => 'form-control  select2 occupation', 'style' => 'width:100%;', 'id' => "occupation_$key", 'placeholder' => 'Select Occupation', 'onChange' => 'otherOccupation(this)']) !!}

                        {!! $errors->first("technical.$key.occupation_id", '<span class="text-danger">:message</span>') !!}
                        @if ($value->other_occupation_value != null)
                            {!! Form::text("technical[$key][other_occupation_value]", $value->other_occupation_value, ['class' => "form-control mt-2 other_occupation_$key", 'placeholder' => 'Enter Other Occupation']) !!}
                        @endif
                    </td>
                    <td>{{ Form::select(
                        "technical[$key][working_time]",
                        ['full' => 'Full Time', 'part' => 'Part Time'],
                        $value->working_time,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "working_time_$key",
                            'placeholder' => 'Select Working Time',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.working_time", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{{ Form::select(
                        "technical[$key][work_nature]",
                        ['regular' => 'Regular', 'seasonal' => 'Seasonal'],
                        $value->work_nature,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "work_nature_$key",
                            'placeholder' => 'Select Work Nature',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.work_nature", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{{ Form::select(
                        "technical[$key][training]",
                        ['trained' => 'Trained', 'untrained' => 'Untrained'],
                        $value->training,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "training_$key",
                            'placeholder' => 'Select Training',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.training", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{!! Form::select("technical[$key][ojt_apprentice]", ['ojt' => 'OJT', 'apprentice' => 'Apprentice', 'none' => 'None'], $value->ojt_apprentice, ['class' => 'form-control ', 'placeholder' => 'Select One']) !!}
                        {!! $errors->first("technical.$key.ojt_apprentice", '<span class="text-danger">:message</span>') !!}
                    </td>

                    <td>{{ Form::select(
                        "technical[$key][edu_qua_general]",
                        $educations['general']->pluck('name', 'id'),
                        $value->edu_qua_general,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "type_$key",
                            'placeholder' => 'Select Education Type',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.edu_qua_general", '<span class="text-danger">:message</span>') !!}

                    </td>
                    <td>{{ Form::select(
                        "technical[$key][edu_qua_tvet]",
                        $educations['tvet']->pluck('name', 'id'),
                        $value->edu_qua_tvet,
                        [
                            'class' => 'form-control select2',
                            'style' => 'width:100%;',
                            'id' => "edu_$key",
                            'placeholder' => ' Select Educational Qualification',
                        ],
                    ) }}
                        {!! $errors->first("technical.$key.edu_qua_tvet", '<span class="text-danger">:message</span>') !!}

                    </td>

                    <td>{!! Form::text("technical[$key][work_exp1]", $value->work_exp1, ['class' => 'form-control ']) !!}
                        {!! $errors->first("technical.$key.work_exp1", '<span class="text-danger">:message</span>') !!}
                    </td>
                    <td>{!! Form::text("technical[$key][work_exp2]", $value->work_exp2, ['class' => 'form-control ']) !!}
                        {!! $errors->first("technical.$key.work_exp2", '<span class="text-danger">:message</span>') !!}
                    </td>

                    <td>
                        @if ($loop->first)
                            <button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i
                                    class="fas fa-plus"></i></button>
                        @else
                            <a type="button" href="{{ url('emitters/human_resource/deleteOption', $value->id) }}"
                                class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>{!! Form::text('technical[0][emp_name]', null, ['class' => 'form-control ']) !!}
                    {!! $errors->first('technical.0.emp_name', '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{{ Form::select(
                    'technical[0][gender]',
                    ['male' => 'Male', 'female' => 'Female', 'sexual_minority' => 'Sexual Minority'],
                    Request::get('gender'),
                    ['class' => 'form-control select2', 'style' => 'width:100%;', 'id' => 'gender_0', 'placeholder' => 'Select Gender'],
                ) }}
                    {!! $errors->first('technical.0.gender', '<span class="text-danger">:message</span>') !!}

                </td>
                <td>{!! Form::select('technical[0][occupation_id]', $occupations->pluck('occupation_name', 'id'), null, ['class' => 'form-control  select2 occupation', 'style' => 'width:100%;', 'id' => 'occupation_0', 'placeholder' => 'Select Occupation', 'onChange' => 'otherOccupation(this)']) !!}

                    {!! $errors->first('technical.0.occupation_id', '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{{ Form::select(
                    'technical[0][working_time]',
                    ['full' => 'Full Time', 'part' => 'Part Time'],
                    Request::get('working_time'),
                    [
                        'class' => 'form-control select2',
                        'style' => 'width:100%;',
                        'id' => 'working_time_0',
                        'placeholder' => 'Select Working Time',
                    ],
                ) }}
                    {!! $errors->first('technical.0.working_time', '<span class="text-danger">:message</span>') !!}

                </td>
                <td>{{ Form::select(
                    'technical[0][work_nature]',
                    ['regular' => 'Regular', 'seasonal' => 'Seasonal'],
                    Request::get('work_nature'),
                    [
                        'class' => 'form-control select2',
                        'style' => 'width:100%;',
                        'id' => 'work_nature_0',
                        'placeholder' => 'Select Work Nature',
                    ],
                ) }}
                    {!! $errors->first('technical.0.work_nature', '<span class="text-danger">:message</span>') !!}

                </td>
                <td>{{ Form::select(
                    'technical[0][training]',
                    ['trained' => 'Trained', 'untrained' => 'Untrained'],
                    Request::get('training'),
                    [
                        'class' => 'form-control select2',
                        'style' => 'width:100%;',
                        'id' => 'training_0',
                        'placeholder' => 'Select Training',
                    ],
                ) }}
                    {!! $errors->first('technical.0.training', '<span class="text-danger">:message</span>') !!}

                </td>
                <td>{!! Form::select('technical[0][ojt_apprentice]', ['ojt' => 'OJT', 'apprentice' => 'Apprentice', 'none' => 'None'], Request::get('ojt_apprentice'), ['class' => 'form-control select2']) !!}
                    {!! $errors->first('technical.0.ojt_apprentice', '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{{ Form::select('technical[0][edu_qua_general]', $educations['general']->pluck('name', 'id'), null, [
                    'class' => 'form-control select2',
                    'style' => 'width:100%;',
                    'id' => 'general_0',
                    'placeholder' => 'Select Education',
                ]) }}
                    {!! $errors->first('technical.0.edu_qua_general', '<span class="text-danger">:message</span>') !!}

                </td>
                <td>{{ Form::select('technical[0][edu_qua_tvet]', $educations['tvet']->pluck('name', 'id'), null, [
                    'class' => 'form-control select2',
                    'style' => 'width:100%;',
                    'id' => 'tvet_0',
                    'placeholder' => 'Select Education ',
                ]) }}
                    {!! $errors->first('technical.0.edu_qua_tvet', '<span class="text-danger">:message</span>') !!}
                </td>

                <td>{!! Form::text('technical[0][work_exp1]', null, ['class' => 'form-control ']) !!}
                    {!! $errors->first('technical.0.work_exp1', '<span class="text-danger">:message</span>') !!}
                </td>
                <td>{!! Form::text('technical[0][work_exp2]', null, ['class' => 'form-control ']) !!}
                    {!! $errors->first('technical.0.work_exp2', '<span class="text-danger">:message</span>') !!}
                </td>

                <td><button type="button" name="add" id="add1" class="btn btn-sm btn-success"><i
                            class="fas fa-plus"></i></button></td>

            </tr>
        @endif

    </tbody>
</table>
@push('custom-scripts')
    {{-- <script>
    $(document).ready(function(){
    $('#question_form').on('submit', function(e){
        e.preventDefault();
        var rowCount = $('#resourceTable >tbody >tr').length;
        var total = {{ $total_technical }}
        if( rowCount != total){
            alert('You need to enter ' + total + ' number of data');
        }
        
    });
});
    </script> --}}

    <script>
        var details = {!! json_encode($answer) !!};
        var technical = <?php echo json_encode(Request::old('technical')); ?>;
        var row_count = 0;
        if (technical != null) {
            row_count = technical.length;
        } else if (details != null) {
            row_count = details.length;
        }
        if (details.length == 0) {
            row_count = 1;
        }
        $('#add1').click(function() {
            $("#resourceTable").append(
                ` <tr>
                <td>{!! Form::text('technical[${row_count}][emp_name]', null, ['class' => 'form-control ']) !!}</td>
            <td>{{ Form::select(
                'technical[${row_count}][gender]',
                ['male' => 'Male', 'female' => 'Female'],
                Request::get('gender'),
                ['class' => 'form-control select2', 'style' => 'width:100%;', 'id' => 'gender_0', 'placeholder' => 'Select Gender'],
            ) }}

            </td>
            <td>{!! Form::select('technical[${row_count}][occupation_id]', $occupations->pluck('occupation_name', 'id'), null, ['class' => 'form-control  select2 occupation', 'id' => 'occupation_0', 'placeholder' => 'Select Occupation', 'onChange' => 'otherOccupation(this)']) !!}
            </td>
            <td>{{ Form::select(
                'technical[${row_count}][working_time]',
                ['full' => 'Full Time', 'part' => 'Part Time'],
                Request::get('working_time'),
                [
                    'class' => 'form-control select2',
                    'style' => 'width:100%;',
                    'id' => 'working_time',
                    'placeholder' => 'Select Working Time',
                ],
            ) }}
            </td>
            <td>{{ Form::select(
                'technical[${row_count}][work_nature]',
                ['regular' => 'Regular', 'seasonal' => 'Seasonal'],
                Request::get('work_nature'),
                [
                    'class' => 'form-control select2',
                    'style' => 'width:100%;',
                    'id' => 'work_nature_${row_count}',
                    'placeholder' => 'Select Work Nature',
                ],
            ) }}
            </td>
            <td>{{ Form::select(
                'technical[${row_count}][training]',
                ['trained' => 'Trained', 'untrained' => 'Untrained'],
                Request::get('training'),
                [
                    'class' => 'form-control select2',
                    'style' => 'width:100%;',
                    'id' => 'training${row_count}',
                    'placeholder' => 'Select Training',
                ],
            ) }}
            </td>
            <td>{!! Form::select('technical[${row_count}][ojt_apprentice]', ['ojt' => 'OJT', 'apprentice' => 'Apprentice', 'none' => 'None'], null, ['class' => 'form-control ', 'placeholder' => 'Select One']) !!}
        </td>
            <td>{{ Form::select('technical[${row_count}][edu_qua_general]', $educations['general']->pluck('name', 'id'), null, [
                'class' => 'form-control select2',
                'style' => 'width:100%;',
                'id' => 'general_${row_count}',
                'placeholder' => 'Select Education',
            ]) }}
                {!! $errors->first('technical.0.edu_qua_general', '<span class="text-danger">:message</span>') !!}

            </td>
            <td>{{ Form::select('technical[${row_count}][edu_qua_tvet]', $educations['tvet']->pluck('name', 'id'), null, [
                'class' => 'form-control select2',
                'style' => 'width:100%;',
                'id' => 'tvet_${row_count}',
                'placeholder' => 'Select Education',
            ]) }}
                {!! $errors->first('technical.0.edu_qua_tvet', '<span class="text-danger">:message</span>') !!}

            </td>
            <td>{!! Form::text('technical[${row_count}][work_exp1]', null, ['class' => 'form-control ']) !!}</td>
            <td>{!! Form::text('technical[${row_count}][work_exp2]', null, ['class' => 'form-control ']) !!}
            </td>
         <td><button type="button" class="btn btn-sm btn-danger remove-tr"><i class="fas fa-trash"></i></button></td></tr>`);
            $('.select2').select2();
            row_count++;
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });
    </script>
    <script>
        var educations = <?php echo json_encode($educations); ?>;

        function changeEducation() {
            var type_id = event.target.id.split('-');
            var type = $('#' + type_id[1]).val();
            var index = type_id[1].split('_');
            $('#edu_' + index[1]).html('');
            var collection = educations[type];
            $('#edu_' + index[1]).append(`<option value="0" selected disabled>Select Educational Qualification</option>`);
            for (var key in collection) {
                $('#edu_' + index[1]).append(
                `<option value="${collection[key]['id']}">${collection[key]['name']}</option>`);
            }

        }
    </script>

    <script>
        function otherOccupation(el) {

            if ($(el).find('option:selected').text() === 'Others') {
                var ik = el.id
                var count = ik.split('_')[1];
                $(el).parents('td').append(`{!! Form::text('technical[${count}][other_occupation_value]', null, ['class' => 'form-control mt-2 ${ik}_other', 'placeholder' => 'Enter Other Occupation']) !!}`);
            } else {
                var ik = el.id
                $(`.other_${ik}`).remove();
            }
        }
    </script>
@endpush
