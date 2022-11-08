@extends('backend.layouts.app')
@section('title')
    Organization
@endsection
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Organization</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Organization</a></li>
                            <li class="breadcrumb-item active">Organization</li>
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
                                <h3 class="card-title">Organization</h3>

                                <a href="{{url('organization/create')}}" class="pull-right boxTopButton" id="add"
                                   data-toggle="tooltip" title="Add New"><i class="fa fa-plus-circle fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{url('/organization')}}" class="pull-right boxTopButton" data-toggle="tooltip"
                                   title="View All"><i class="fa fa-list fa-2x" style="font-size: 20px;"></i></a>

                                <a href="{{URL::previous()}}" class="pull-right boxTopButton" data-toggle="tooltip"
                                   title="Go Back">
                                    <i class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="container-fluid ">
                                    @if($organization->org_image)
                                    <input class="profile-user-img img-responsive img-circle " src="{{asset('/storage/uploads/organization/images/organizationPic/'.$organization->org_image)}}" style="width:150px" alt="No Image">
                                    @else
                                        <img src="{{url('/uploads/images/dummyUser.gif')}}" class="dropdown-item dropdown-header text-center" alt="User Image" style="width: 100px;height: 90px;">
                                    @endif
                                </div>
                                <br>
                                <div class="box-header with-border">
                                    <h3 class="box-title"><strong>{{$organization->org_name}}</strong></h3>
{{--                                    <a href="{{url('feedback/'.$feedback->id .'/edit')}}"--}}
{{--                                       class="text-info btn btn-xs btn-default">--}}
{{--                                        <i class="fa fa-pencil-square-o"></i>--}}
{{--                                    </a>--}}
                                </div>
                                <div class="tab-content">
                                    <div class="active">
                                        <div class="box-body box-profile">

                                            <div class="post">
                                                <table class="table table-bordered table-responsive table-hover">
                                                    <tr>
                                                        <td>Sector:</td>
                                                        <td>
                                                            {{$organization->economicsector->sector_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pradesh Name</td>
                                                        <td>
                                                            {{$organization->pradesh->pradesh_name??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>District</td>
                                                        <td>{{$organization->district->english_name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Municipality</td>
                                                        <td>{{$organization->municipality->muni_name??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ward</td>
                                                        <td>{{$organization->ward_no??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tole</td>
                                                        <td>{{$organization->tole??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pan Number:</td>
                                                        <td>
                                                            {{$organization->pan_number??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Liscence Number:</td>
                                                        <td>
                                                            {{$organization->licensce_no??null}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone</td>
                                                        <td>{{$organization->phone_no??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Email</td>
                                                        <td>{{$organization->email??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fax</td>
                                                        <td>{{$organization->fax??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Website</td>
                                                        <td>{{$organization->website??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Establish Date</td>
                                                        <td>{{$organization->establish_date??null}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Detail</td>
                                                        <td>{{$organization->detail??null}}</td>
                                                    </tr>

                                                </table>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
