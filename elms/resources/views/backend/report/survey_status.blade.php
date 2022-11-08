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
                                    <div class="form-group {{ $errors->has('pradesh_id') ? 'has-error' : '' }}">
                                        <label>Pradesh: </label>
                                        {{ Form::select('pradesh_id', $pradeshes->pluck('pradesh_name', 'id'), Request::get('pradesh_id'), ['class' => 'form-control select2','id' => 'pradesh_id','name' => 'pradesh_id','placeholder' => 'Select Pradesh']) }}
                                        {!! $errors->first('pradesh_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('district_id') ? 'has-error' : '' }}">
                                        <label>District: </label>
                                        {{ Form::select('district_id', $districts->pluck('english_name', 'id'), Request::get('district_id'), ['class' => 'form-control select2','id' => 'district_id','name' => 'district_id','placeholder' => 'Select District']) }}
                                        {!! $errors->first('district_id', '<span class="text-danger">:message</span>') !!}
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info " id="search"><i
                                                class="fa fa-search"></i>Search
                                        </button>
                                        <a href="{{ url('/report/reportbyquestions/') }}" class="btn btn-warning"><i
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
                                Survey Status
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
                            <div class="row mt-4 mx-2">
                                <div class="col-md-3">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['total'] }}</h3>
                                            <p>Total Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-list"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['complete'] }}</h3>
                                            <p>Completed Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3>{{ $status['overall']['inprogress'] }}</h3>
                                            <p>In Progress Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-spinner"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            @if(Request::get('pradesh_id') == null && Request::get('district_id') == null)
                                            <h3>{{ 3000- $status['overall']['complete'] - $status['overall']['inprogress'] }}

                                            @else
                                            <h3>{{ $status['overall']['total'] - $status['overall']['complete'] - $status['overall']['inprogress'] }}
                                            @endif
                                            </h3>
                                            <p>In Completed Survey</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-exclamation"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                Survey Complete Organization
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
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Organization Name</th>
                                        <th>Enumerator</th>
                                        <th>Supervised By</th>
                                        <th>Approved By</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @if (count($completeList) > 0)
                                        @foreach ($completeList as $key => $val)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $val->organization->org_name }}</td>
                                                <td>{{ $val->emitter ? $val->emitter->name : '-' }}</td>
                                                <td>{{ $val->emitter ? $val->emitter->supervisor->name : '-' }}</td>
                                                <td>{{ $val->emitter ? $val->emitter->supervisor->supervisor->coordinator->name : '-' }}
                                                </td>
                                                <td>{{ $val->start_date }}</td>
                                                <td>{{ $val->finish_date }}</td>

                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center"> Data Not Available</td>

                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                            {{ $completeList->appends($_GET)->links() }}
                        </div>
                        @if (count($completeList) >= 11)
                            <div class="card-footer clearfix">
                                <a href="{{ url('/complete_survey') }}" class="btn btn-sm btn-secondary float-right">View
                                    All </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                Survey Complete Organization
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
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Coordinator Name</th>
                                        <th>Survey Number</th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($coordinatorSurvey as $key => $val)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $key }}</td>
                                            <td>{{ count($val) }}</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
