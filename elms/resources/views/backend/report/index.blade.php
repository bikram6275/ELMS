@extends('backend.layouts.app')
@section('title')
Enumerator Report
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Enumerator Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                        {{-- <li class="breadcrumb-item">{{trans('app.configuration')}}</li>--}}
                        <li class="breadcrumb-item active">Enumerator Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            @include('backend.message.flash')


            <div class="card card-default">
                <div class="card-header with-border">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title"><strong><i class="fa fa-list"></i> Enumerator Report</strong></h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                        <div class="row">
                            {!!Form::open(['method'=>'get',route('enumeratorreport.index'),'enctype'=>'multipart/form-data'])
                            !!}


                            <div class="col-md-4 form-group">
                                {{ Form::select('survey_id', $surveys->pluck('survey_name', 'id'),
                                Request::get('survey_id'), ['class' => 'form-control select2', 'id' => 'survey_id',
                                'placeholder' => 'Select Survey']) }}
                            </div>
                            <div class="col-md-2 ">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <thead>
                            <tr>
                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                {{-- <th>Parent</th>--}}
                                <th>Enumerator Name</th>
                                <th>Assigned</th>
                                <th>Inprogress</th>
                                <th>Complete</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;?>
                            @foreach($enumeratorassigns as $key=>$enumeratorassign)
                            <tr>
                                <th scope=row>{{$i}}</th>
                                <td>{{$enumeratorassign?$enumeratorassign->name:'-'}}</td>
                                <td>{{ $enumeratorassign?$enumeratorassign->assigned($enumeratorassign->id):'-'}}</td>
                                <td>{{ $enumeratorassign?$enumeratorassign->inProgress($enumeratorassign->id):'-' }}</td>
                                <td>{{ $enumeratorassign?$enumeratorassign->complete($enumeratorassign->id):'-' }}</td>


                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
            <!-- /.card -->
        </div>
    </section>
</div>

</div>
</section>
<!-- /.content -->
</div>

<!-- /.content-wrapper -->

@endsection
