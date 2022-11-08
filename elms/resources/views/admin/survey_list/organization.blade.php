@extends('backend.layouts.app')
@section('title')
    Assigned Organization
@endsection

@section('content')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Assigned Organization</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">{{trans('app.dashboard')}}</a></li>
                            <li class="breadcrumb-item active">Assigned Organization</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                Filter
                            </div>
                            <div class="card-body">
                                {{-- {!! Form::open(['method'=>'post','url'=>'enumeratorassign','enctype'=>'multipart/form-data','file'=>true]) !!} --}}
                                {!! Form::open(['method' => 'get', route('organization.index'), 'enctype' => 'multipart/form-data', 'file' => true]) !!}
    
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('pradesh_id') ? 'has-error' : '' }}">
                                            {{ Form::select('pradesh_id',$pradeshs->pluck('pradesh_name','id'), Request::get('pradesh_id'), ['class' => 'form-control select2','id' => 'pradesh_id','name' => 'pradesh_id','placeholder' => 'Select Pradesh']) }}
                                            {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
                                            {{ Form::select('district_id', $districts->pluck('english_name','id'), Request::get('district_id'), ['class' => 'form-control select2','id' => 'district_id','name' => 'district_id','placeholder' => 'Select District']) }}
                                            {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-info " id="assign_button"><i
                                                    class="fa fa-search"></i>Filter
                                            </button>
                                            <a href="{{ route('survey.orgs.show',Request::route('id')) }}" class="btn btn-warning "><i
                                                    class="fa fa-refresh"></i> Refresh
                                            </a>
                                        </div>
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
                    <div class="col-md-12" id="listing">
                        <div class="card card-default">
                            <div class="card-header with-border">
                                <h3 class="card-title">Assigned Organization</h3>
                                @if(count($assignOrganization)>0)
                                {{-- <a  href="{{ url('report/organizationReport/'.$assignOrganization[0]->survey_id) }}" class="btn btn-default pull-right">Export  <i class="fas fa-file-excel"></i></a> --}}
                                <a href="{{ route('export.list.index',$assignOrganization[0]->survey_id) }}" class="btn btn-default pull-right">Export  <i class="fas fa-file-excel ml-1"></i></a>
                                @endif
                            </div>
                            <div class="card-body">
                                    <div class="col-md-12 topFilter">
                                        <table id="example2"
                                               class="table table-striped table-bordered table-hover table-responsive">
                                            <thead>
                                            <tr>
                                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                                <th> Assigned Organization</th>
                                                <th>Start Date</th>
                                                <th>Finish Date</th>
                                                <th>Status</th>
                                                <th style="width: 100px !important" ;
                                                    class="text-right">Action</th>
                                            </tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = 1; ?>
                                            @foreach($assignOrganization as $key=>$data)
                                                <tr>
                                                    <td scope=row>{{$i}}</td>
                                                   <td>{{ $data->organization?$data->organization->org_name:'-'}}</td>
                                                   <td>{{Carbon\Carbon::parse($data->start_date)->format('Y-m-d')}}</td>
                                                   <td>{{ Carbon\Carbon::parse($data->finish_date)->format('Y-m-d')}}</td>

                                                   <td><span class="badge {{ $data->finish_date!=null?'badge-danger':'badge-primary' }}">{{ ($data->finish_date!=null)?'Complete':(($data->start_date!=null)?'Started':null)}}</span></td>
                                                    <td>
                                                        @if($data->respondent_name!=null)
                                                        <a href="{{ url('survey/orgs/'.$data->id) }}" class="btn btn-xs btn-primary"><strong> Survey Start</strong> </a>
                                                        @else
                                                        <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#respondent_{{$data->pivot_id}}"><strong> Survey Start</strong></button>
                                                         @include('admin.formLayout.respondentModel')
                                                        @endif
                                                    <a href="{{ url('survey/view/'.$data->id) }}"  class=" btn btn-xs btn-danger">
                                                       <strong> View</strong> </a>
                                                       <a href="{{ route('return.coordinator',$data->id) }}" class="btn btn-xs btn-warning"> Return Back</a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>


                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
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
@endsection