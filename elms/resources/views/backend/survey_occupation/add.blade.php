@extends('backend.layouts.app')
@section('title')
   Survey Organization Occupation
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Survey Occupation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Survey Occupation</li>
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

                        <div class="card-body">
                            {!! Form::open(['method'=>'get','url'=>'survey_occupation']) !!}


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group {{ ($errors->has('survey_id'))?'has-error':'' }}">
                                        {{Form::select('survey_id',$surveys->pluck('survey_name','id'),Request::get('survey_id'),['class'=>'form-control select2','id'=>'survey_id','name'=>'survey_id','placeholder'=>
                                        'Select Survey'])}}
                                        {!! $errors->first('survey_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info " ><i
                                            class="fa fa-search"></i>Search</button>

                                </div>

                            </div>


                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            @if($status)
            <div class="row">
                <div class="col-md-12" id="listing">
                    {!! Form::open(['method'=>'post','url'=>'survey_occupation']) !!}
                    <input type="hidden" name="survey_id" value="{{ $survey_id }}">
                    <div class="card card-default">
                        <div class="card-body">

                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll" class="ml-1"></th>
                                    <th>Occupations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($occupations as $key=>$val)
                                    <tr id="sid{{$val->id}}">
                                        <td>{{ Form::checkbox('occupation_id[]', $val->id, $survey_occupation != null && in_array($val->id, $survey_occupation) ? 'checked' : '', ['class' => 'form-check-input ml-2']) }}</td>
                                        <td>{{$val->occupation_name}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right" id="enumeratorassignsave">
                                {{trans('app.save')}}
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
@push('custom-scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#checkAll').click(function(){
            if($(this).is(':checked')){
                $('.checkItem').prop("checked",true);
            }else {
                $(".checkItem").prop("checked",false);
            }
        });
    });
    </script>
@endpush

