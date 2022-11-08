@extends('backend.layouts.app')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Logs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">Logs</li>
                            <li class="breadcrumb-item active">Login Fails</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
            @include('backend.message.flash')

            <div class="row">

                <div class="col-md-12" id="listing">
                    <div class="card card-default">
                        <div class="card-header with-border">
                            <h3 class="card-title">Login Fails</h3>

                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                                <thead>
                                <tr>
                                    <th style="width: 10px;">S.N</th>
                                    <th>Email</th>
                                    <th>IP</th>
                                    <th>Device</th>
                                    <th>Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i=1;?>
                                @forelse($failLogins as $failLogin)
                                    <tr>
                                        <th scope=row>{{$i}}</th>
                                        <td>{{$failLogin->user_name}}</td>
                                        <td>{{$failLogin->log_in_ip}}</td>
                                        <td>{{$failLogin->log_in_device}}</td>
                                        <td>{{$failLogin->created_at->diffForHumans()}}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @empty
                                @endforelse
                                </tbody>
                            </table>

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