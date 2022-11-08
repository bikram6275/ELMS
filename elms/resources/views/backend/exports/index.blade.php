@extends('backend.layouts.app')
@section('title')
    Export List
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Export List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Export List</li>
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
                                <h3 class="card-title"><strong><i class="fa fa-list"></i> Export List</strong></h3>
                                <a href="{{url('/emitter/create')}}" class="pull-right cardTopButton" id="add" data-toggle="tooltip"
                                   title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{url('/emitter')}}" class="pull-right cardTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size:20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right cardTopButton" data-toggle="tooltip" title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size:20px;"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th style="width: 10px;">{{trans('app.sn')}}</th>
                                <th>
                                    Report Name
                                </th>
                            
                                <th style="width: 10px" ;
                                    class="text-right">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Organizations Export</td>
                                        <td><a href="{{ route('org.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Questions Export</td>
                                        <td><a href=" {{ route('question.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Answers Export</td>
                                        <td><a href="{{ route('answer.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Question 1.3 Export(Registered With)</td>
                                        <td><a href="{{ route('registeredwith.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Question 2 Export</td>
                                        <td><a href="{{ route('qsn2.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Question 4 Export</td>
                                        <td><a href="{{ route('qsn4.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>Human Resource Export (Question no 5)</td>
                                        <td><a href="{{ route('qsn5.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>8</td>
                                        <td>Human Resource Export (Question no 5.1, 5.2, 5.3)</td>
                                        <td><a href="{{ route('human_resource.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>

                                    <tr>
                                        <td>9</td>
                                        <td>Technical Human Resource Export (Question no 6.a)</td>
                                        <td><a href="{{ route('technical_human_resource.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>

                                    <tr>
                                        <td>10</td>
                                        <td>Employee Status Export (Question no 6.b)</td>
                                        <td><a href="{{ route('emp_status.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>

                                    <tr>
                                        <td>11</td>
                                        <td>Question no 12 Export</td>
                                        <td><a href="{{ route('qsn12.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>

                                    <tr>
                                        <td>12</td>
                                        <td>Woker Skills Export(Question no 13)</td>
                                        <td><a href="{{ route('worker_skills.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>13</td>
                                        <td>Other Occupation Export(Question no 8)</td>
                                        <td><a href="{{ route('other_occupation.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>Technology Export(Question no 17)</td>
                                        <td><a href="{{ route('technology.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>15</td>
                                        <td>Business Plan Export(Question no 18)</td>
                                        <td><a href="{{ route('business_plan.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>16</td>
                                        <td>Question no 19 Export</td>
                                        <td><a href="{{ route('qsn19.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>17</td>
                                        <td>Question no 20 Export</td>
                                        <td><a href="{{ route('qsn20.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>18</td>
                                        <td>Question no 21 Export</td>
                                        <td><a href="{{ route('qsn21.export',request()->route('id')) }}" class="btn btn-sm btn-success"><i class="fas fa-file-download"></i></i></a></td>
                                    </tr>
                            </tbody>
                        </table>

                    </div>
          
                </div>
                <!-- /.card -->
            </div>
        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->

@endsection
