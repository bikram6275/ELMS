@extends('backend.layouts.app')
@section('title')
    Report
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Survey Status</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Survey Status</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            @include('backend.message.flash')
            <div class="row">
                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Survey Status</h3>
                        </div>
                        <div class="card-body">
                            {!! Form::open(['method' => 'get', route('survey_status.view'), 'enctype' => 'multipart/form-data', 'file' => true]) !!}

                            <div class="row">
                              
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('enumerator_id') ? 'has-error' : '' }}">
                                        <label>Enumerator Name: </label>
                                        {{ Form::select('enumerator_id', $enumerators->pluck('name', 'id'), Request::get('enumerator_id'), ['class' => 'form-control select2','id' => 'enumerator_id','name' => 'enumerator_id','placeholder' => 'Select Enumerator']) }}
                                        {!! $errors->first('enumerator_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info " id="search"><i
                                                class="fa fa-search"></i>Search
                                        </button>
                                        <a href="{{ url('/monitor') }}" class="btn btn-warning"><i
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
                <div class="col-md-12">
                    <div class="card card-primary card-outline" style="overflow-x: scroll">
                        <div class="card-header">
                            <h3 class="card-title">
                               Enumerator Survey Information
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @if (count($enumerator_details) > 0)
                            <div class="row  ml-3 mt-3">
                                <div class="col-md-6">
                                    <h6><strong>Enumerator name :</strong> {{ $enumerator_details[0]->emitter?$enumerator_details[0]->emitter->name:'-'}}</h6>
                                </div>
                                <div class="col-md-6">
                                   <h6> <strong>District :</strong> {{ $enumerator_details[0]->emitter?$enumerator_details[0]->emitter->district->english_name:'-' }} </h6>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6> <strong>Assigned Organization :</strong> {{ $enumerator_details->assigned_organizations }} </h6>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <h6> <strong> Completed Organization :</strong> {{ $enumerator_details->completed_organizations }} </h6>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Organization Name</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
    
                                    <tbody>
                                            @foreach ($enumerator_details as $key => $e)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $e->organization ? $e->organization->org_name : '-'}}</td>
                                                    <td>{{ $e->start_date }}</td>
                                                    <td>{{ $e->finish_date }}</td>
                                                </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($enumerator_details[0]->emitter)
                                <a class="btn btn-warning ml-4 mb-3" href="{{ route('enumerator-export',Request::get('enumerator_id')) }}">Export to PDF</a>
                            @endif
                            @else
                            <h5 class="text-center mt-4 mb-4">No Data Available</h5>
                            @endif
                        </div>

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
                                `<option value="${value.id}" ${flag}> ${value.english_name}</option>`;
                        });
                        var select_group = $('#district_id');
                        select_group.empty().append(district_option);
                        $('#district_id').prop('disabled', false);
                    },
                });
            }

            $('#pradesh_id').change(function() {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });
            $(document).ready(function() {
                pradesh_id = $('#pradesh_id').val();
                getDisByPradesh();
            });
        });
    </script>
@endsection
