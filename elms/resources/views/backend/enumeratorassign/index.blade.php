@extends('backend.layouts.app')
@section('title')
    Enumerator Assign
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Enumerator Assign</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Enumerator Assign</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Organization Search</h3>

                        </div>
                        <div class="card-body">
                            {{-- {!! Form::open(['method'=>'post','url'=>'enumeratorassign','enctype'=>'multipart/form-data','file'=>true]) !!} --}}
                            {!! Form::open([
                                'method' => 'get',
                                route('enumeratorassign.index'),
                                'enctype' => 'multipart/form-data',
                                'file' => true,
                            ]) !!}

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('pradesh_id') ? 'has-error' : '' }}">
                                        <label>Pradesh: </label>
                                        {{ Form::select('pradesh_id', $pradeshes->pluck('pradesh_name', 'id'), Request::get('pradesh_id'), ['class' => 'form-control select2', 'id' => 'pradesh_id', 'name' => 'pradesh_id', 'placeholder' => 'Select Pradesh']) }}
                                        {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
                                        <label>District: </label>
                                        {{ Form::select('district_id', $districts->pluck('english_name', 'id'), Request::get('district_id'), ['class' => 'form-control select2', 'id' => 'district_id', 'name' => 'district_id', 'placeholder' => 'Select District']) }}
                                        {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>



                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('enumerator_id') ? 'has-error' : '' }}">
                                        <label>Enumerator: </label>
                                        {{ Form::select('enumerator_id', $emitters->pluck('name', 'id'), Request::get('enumerator_id'), ['class' => 'form-control select2', 'id' => 'enumerator_id', 'placeholder' => 'Select Enumerator']) }}
                                        {!! $errors->first('enumerator_id', '<span class="text-danger">:message</span>') !!}
                                    </div>



                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('survey_id') ? 'has-error' : '' }}">
                                        <label>Survey: </label>
                                        {{ Form::select('survey_id', $surveys->pluck('survey_name', 'id'), Request::get('survey_id'), ['class' => 'form-control select2', 'id' => 'survey_id', 'placeholder' => 'Select Survey']) }}
                                        {!! $errors->first('survey_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>


                            </div>
                            <div class="row mt-2">
                                <div class="offset-md-5 col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info mr-2" id="assign_button"><i
                                                class="fa fa-search"></i>Assign
                                        </button>
                                        <a href="{{ url('enumeratorassign/') }}" class="btn btn-warning "><i
                                                class="fa fa-refresh"></i> Refresh
                                        </a>
                                    </div>
                                </div>

                            </div>


                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>

            @if ($status == true)
                <div class="row">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-body">

                                {!! Form::open([
                                    'method' => 'post',
                                    'url' => 'enumeratorassign',
                                    'enctype' => 'multipart/form-data',
                                    'file' => true,
                                ]) !!}
                                {!! Form::hidden('enumerator_id', $enumerator_id, ['class' => 'form-control ']) !!}
                                {!! Form::hidden('survey_id', $survey_id, ['class' => 'form-control ']) !!}


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <table class="table table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Organization</th>
                                                        <th>Enumerator</th>
                                                        <th>Survey</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <?php $i = 1; ?>
                                                <tbody>

                                                    @foreach ($organizations as $key => $organization)
                                                        <tr id="sid{{ $organization->id }}">
                                                            <td><input type="checkbox" name="ids[]" class="checkItem"
                                                                    id="checkItem" value="{{ $organization->id }}"
                                                                    {{ array_key_exists($organization->id, $enumeratorAssigns) ? 'checked' : '' }}
                                                                    {{ $organization->disable($organization->id, $enumerator_id, $survey_id) ? 'disabled' : null }}>
                                                            </td>
                                                            <td>{{ $organization->org_name }}</td>
                                                            <td>{{ $organization->name }}</td>
                                                            <td>{{ $organization->survey_name }}</td>
                                                            <td>
                                                                @if ($organization->start_date == date('Y-m-d'))
                                                                    <span>Assigned</span>
                                                                @elseif($organization->start_date != null && $organization->finish_date != null)
                                                                    <span class="btn btn-primary">Completed</span>
                                                                @elseif($organization->start_date != null)
                                                                    <span class="btn btn-primary">On going</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <?php $i++; ?>
                                            </table>

                                        </div>

                                    </div>
                                </div>
                                <div class="form-group pull-right" style="display: none" id="enumeratorassignsave">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('app.save') }}
                                    </button>
                                </div>
                                {{ Form::close() }}


                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>


    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            function getDisByPradesh() {
                var district_option = '<option value="">Select District</option>';
                $('#district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{ url('/get/district/') }}/" + pradesh_id,

                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            flag = (district_id == value.id) ? "selected='selected'" : "";
                            district_option +=
                                `<option value="${value.id}" ${flag}> ${value.nepali_name}</option>`;
                        });
                        var select_group = $('#district_id');
                        select_group.empty().append(district_option);
                        $('#district_id').prop('disabled', false);
                    },
                });
            }

            function getMuniByDis() {
                var muni_option = '<option value="">Select Municipality</option>';
                $('#municipality_id').prop('disabled', true);
                $.ajax({
                    url: "{{ url('/get/municipality/') }}/" + district_id,

                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var is_selected = value.id == municipality_id ?
                                'selected="selected"' : "";
                            muni_option +=
                                `<option value="${value.id}" ${is_selected}>${value.muni_name}</option>`;
                        });
                        var select_group = $('#municipality_id');
                        select_group.empty().append(muni_option);
                        $('#municipality_id').prop('disabled', false);
                    },

                });
            }

            $('#pradesh_id').change(function() {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });

            $('#district_id').change(function() {
                district_id = $('#district_id').val();
                getMuniByDis();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#checkAll').click(function() {
                if ($(this).is(':checked')) {
                    $('.checkItem').prop("checked", true);
                } else {
                    $(".checkItem").prop("checked", false);
                }
            });

            // $('#enumerator_id,#survey_id').change(function(){
            //     var ans1= $('#enumerator_id').val();
            //     var ans2= $('#survey_id').val();
            //     if(ans1==null && ans2==null ){
            //         $('#enumeratorassignsave').hide();
            //     }else if(ans1!=null && ans2!=null ){
            //         console.log(ans1,ans2);
            //         $('#enumeratorassignsave').show();
            //
            //     }
            //     else
            //     {
            //         $('#enumeratorassignsave').hide();
            //     }
            // })
            $(document).ready(function() {
                $("#enumerator_id").change(function() {
                    $(this).find("option:selected").each(function() {
                        var optionValue = $(this).attr("value");
                        if (optionValue) {
                            $('#enumeratorassignsave').show();
                        } else {
                            $('#enumeratorassignsave').hide();
                        }
                    });
                }).change();
            });


            $(document).ready(function() {
                $("#pradesh_id").change(function() {
                    // $("#assign_button").html($(this).text()+' <span class="1"></span>');
                    $('#assign_button').html('Filter');
                });
                $("#district_id").change(function() {
                    // $("#assign_button").html($(this).text()+' <span class="1"></span>');
                    $('#assign_button').html('Filter');
                });
                $("#enumerator_id").change(function() {
                    // $("#assign_button").html($(this).text()+' <span class="1"></span>');
                    $('#assign_button').html('Assign');
                });
                $("#survey_id").change(function() {
                    // $("#assign_button").html($(this).text()+' <span class="1"></span>');
                    $('#assign_button').html('Assign');
                });



            });



            {{-- $("#enumeratorassignsave").click(function(e){ --}}
            {{-- e.preventDefault(); --}}
            {{-- var enumerator_id = $('#enumerator_id').val(); --}}
            {{-- var survey_id = $('#survey_id').val(); --}}
            {{-- var allids=[]; --}}
            {{-- $("input:checkbox[name=ids]:checked").each(function () { --}}
            {{-- allids.push($(this).val()); --}}
            {{-- console.log(allids,enumerator_id,survey_id) --}}
            {{-- }); --}}
            {{-- $.ajax({ --}}
            {{-- url: "{{route('enumeratorassign.add')}}", --}}
            {{-- type:"POST", --}}
            {{-- data:{ --}}
            {{-- _token:$("input[name=_token]").val(), --}}
            {{-- ids: allids,enumerator_id,survey_id --}}
            {{-- }, --}}
            {{-- // success:function (response) { --}}
            {{-- //     $.each(allids,function (key,val) { --}}
            {{-- //         $("#sid"+val).remove(); --}}
            {{-- //     }) --}}
            {{-- // } --}}
            {{-- }); --}}

            {{-- }) --}}

        });
    </script>
@endsection
