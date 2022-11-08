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
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
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
                            <a href="{{url('/enumeratorassign/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                               title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size: 20px;"></i></a>

                            <a href="{{url('/enumeratorassign')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                               title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                            <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                        </div>
                        <div class="card-body">
                            {{--                            {!! Form::open(['method'=>'post','url'=>'enumeratorassign','enctype'=>'multipart/form-data','file'=>true]) !!}--}}
                            {!! Form::open(['method'=>'get',route('enumeratorassign.create'),'enctype'=>'multipart/form-data','file'=>true]) !!}

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('pradesh_id'))?'has-error':'' }}">
                                        {{--                                        <label>Pradesh: </label>--}}
                                        {{Form::select('pradesh_id',$pradeshes->pluck('pradesh_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'pradesh_id','name'=>'pradesh_id','placeholder'=>
                                        'Select Pradesh'])}}
                                        {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('district_id'))?'has-error':'' }}">
                                        {{--                                        <label>District: </label>--}}
                                        {{Form::select('district_id',$districts->pluck('english_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'district_id','name'=>'district_id','placeholder'=>
                                        'Select District'])}}
                                        {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('muni_id'))?'has-error':'' }}">
                                        {{--                                        <label>Municipality: </label>--}}
                                        {{Form::select('muni_id',$municipalities->pluck('muni_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'municipality_id','placeholder'=>
                                        'Select Municipality'])}}
                                        {!! $errors->first('muni_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>



                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('enumerator_id'))?'has-error':'' }}">
                                        {{--                                        <label>Enumerator: </label>--}}
                                        {{Form::select('enumerator_id',$emitters->pluck('name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'enumerator_id','name'=>'enumerator_id','placeholder'=>
                                        'Select Enumerator'])}}
                                        {!! $errors->first('enumerator_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('survey_id'))?'has-error':'' }}">
                                        {{--                                        <label>Survey: </label>--}}
                                        {{Form::select('survey_id',$surveys->pluck('survey_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'survey_id','name'=>'survey_id','placeholder'=>
                                        'Select Survey'])}}
                                        {!! $errors->first('survey_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info " ><i
                                                class="fa fa-search"></i>Search</button>
                                        <a href="{{url('/enumeratorassign/create')}}"
                                           class="btn btn-warning"><i
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




            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-body">

                            {!! Form::open(['method'=>'post','url'=>'enumeratorassign','enctype'=>'multipart/form-data','file'=>true]) !!}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('enumerator_id'))?'has-error':'' }}">
                                        {{--                                        <label>Enumerator: </label>--}}
                                        {{Form::select('enumerator_id',$emitters->pluck('name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'enumerator_id','name'=>'enumerator_id','placeholder'=>
                                        'Select Enumerator'])}}
                                        {!! $errors->first('enumerator_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('survey_id'))?'has-error':'' }}">
                                        {{--                                        <label>Survey: </label>--}}
                                        {{Form::select('survey_id',$surveys->pluck('survey_name','id'),Request::get('id'),['class'=>'form-control select2','id'=>'survey_id','name'=>'survey_id','placeholder'=>
                                        'Select Survey'])}}
                                        {!! $errors->first('survey_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <table class="table table-responsive">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" id="checkAll"></th>
                                                <th>Organization</th>


                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1;?>
                                            @foreach($organizations as $key=>$organization)
                                                <tr id="sid{{$organization->id}}">
                                                    <td><input type="checkbox" name="ids[]" class="checkItem" id="checkItem" value="{{$organization->id}}"
                                                               @foreach($enumeratorAssigns as $enumeratorAssign)
                                                               @if($enumeratorAssign->organization_id == $organization->id)
                                                               disabled="true"
                                                            @endif
                                                            @endforeach
                                                        ></td>
                                                    <td>{{$organization->org_name}}</td>

                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="enumeratorassignsave">
                                    {{trans('app.save')}}
                                </button>
                            </div>
                            {{ Form::close() }}


                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>

@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            function getDisByPradesh(){
                var district_option =  '<option value="">Select District</option>';
                $('#district_id').prop('disabled', true);
                var flag = "";
                $.ajax({
                    url: "{{  url('/get/district/') }}/"+pradesh_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            flag = (district_id == value.id) ? "selected='selected'" : "";
                            district_option += `<option value="${value.id}" ${flag}> ${value.nepali_name}</option>`;
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
                    url: "{{  url('/get/municipality/') }}/"+district_id,

                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            var is_selected = value.id == municipality_id ?  'selected="selected"' : "";
                            muni_option += `<option value="${value.id}" ${is_selected}>${value.muni_name}</option>`;
                        });
                        var select_group = $('#municipality_id');
                        select_group.empty().append(muni_option);
                        $('#municipality_id').prop('disabled', false);
                    },

                });
            }

            $('#pradesh_id').change(function () {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });

            $('#district_id').change(function () {
                district_id = $('#district_id').val();
                getMuniByDis();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#checkAll').click(function(){
                if($(this).is(':checked')){
                    $('.checkItem').prop("checked",true);
                }else {
                    $(".checkItem").prop("checked",false);
                }
            });



            {{--$("#enumeratorassignsave").click(function(e){--}}
            {{--    e.preventDefault();--}}
            {{--     var enumerator_id = $('#enumerator_id').val();--}}
            {{--    var survey_id = $('#survey_id').val();--}}
            {{--    var allids=[];--}}
            {{--    $("input:checkbox[name=ids]:checked").each(function () {--}}
            {{--        allids.push($(this).val());--}}
            {{--        console.log(allids,enumerator_id,survey_id)--}}
            {{--    });--}}
            {{--    $.ajax({--}}
            {{--        url: "{{route('enumeratorassign.add')}}",--}}
            {{--        type:"POST",--}}
            {{--        data:{--}}
            {{--            _token:$("input[name=_token]").val(),--}}
            {{--            ids: allids,enumerator_id,survey_id--}}
            {{--        },--}}
            {{--        // success:function (response) {--}}
            {{--        //     $.each(allids,function (key,val) {--}}
            {{--        //         $("#sid"+val).remove();--}}
            {{--        //     })--}}
            {{--        // }--}}
            {{--    });--}}

            {{--})--}}

        });





    </script>
@endsection
