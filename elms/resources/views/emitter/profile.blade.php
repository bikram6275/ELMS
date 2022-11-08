@extends('backend.layouts.app')
@section('title','User-Profile')
@section('content')
    <!-- Content Wrapper. Contains page content -->

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{'Profile'}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('emitters/dashboard')}}">Dashboard</a></li>
                            <li class="breadcrumb-item">{{'Emitter'}}</li>
                            <li class="breadcrumb-item active">{{'Profile'}}</li>
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
                        <a href="{{url('/emitters/dashboard')}}" class="pull-right" data-toggle="tooltip" title="Go Back"><i
                                class="fa fa-arrow-circle-left fa-2x" style="font-size: 20px;"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Profile Image -->
                                <div class="card card-primary">
                                    <div class="card-body   ">
                                        <a data-toggle="modal" data-target="#myModal ">

                                                <img class="profile-user-img img-responsive img-circle"
                                                     src="{{url('/uploads/images/dummyUser.gif')}}"
                                                     alt="User Image" style="margin-left: 50px;">

                                        </a>
                                        <!-- Modal -->
{{--                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
{{--                                            <div class="modal-dialog" role="document">--}}
{{--                                                <div class="modal-content">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
{{--                                                        <h4 class="modal-title" id="myModalLabel">Profile Picture</h4>--}}
{{--                                                    </div>--}}
{{--                                                    <form action="{{url('/orgs/profile/profilePic')}}" method="post" enctype="multipart/form-data">--}}
{{--                                                        <div class="modal-body">--}}
{{--                                                            <input type="file" name="org_image" id="profile-img" ><br>--}}
{{--                                                            <img src="" id="profile-img-tag" width="300px" />--}}
{{--                                                            {{csrf_field()}}--}}
{{--                                                        </div>--}}
{{--                                                        <div class="modal-footer">--}}
{{--                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
{{--                                                            <button type="submit" class="btn btn-primary">Save</button>--}}
{{--                                                        </div>--}}
{{--                                                    </form>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

                                        <h3 class="profile-username text-center">{{$user->name}}</h3>

                                        {{--                                        <p class="text-muted text-center">{{$user->designation->designation_name}}</p>--}}

                                    </div>
                                </div>
                                <!-- /.card -->

                                <!-- About Me Box -->
                                <div class="card card-primary">
                                    <div class="card-header with-border">
                                        <h3 class="card-title">About Me</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <strong><i class="fa fa-envelope margin-r-5"></i> Email</strong>
                                        <p class="text-muted">
                                            {{$user->email}}
                                        </p>
                                        <hr>
                                        <strong><i class="fa fa-envelope margin-r-5"></i> Phone</strong>
                                        <p class="text-muted">
                                            <a href="">{{$user->phone_no}}</a>
                                        </p>

                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-9">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Profile</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Change Password</a>
                                        </li>

{{--                                        <li class="nav-item">--}}
{{--                                            <a class="nav-link" id="custom-content-above-activity-tab" data-toggle="pill" href="#custom-content-above-activity" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Activity</a>--}}
{{--                                        </li>--}}

                                    </ul>

                                    <div class="tab-content" id="custom-content-above-tabContent">

                                        <div class="tab-pane fade show active" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab" style="padding-top: 20px;">
                                            <div class="row border py-3" style="background-color: #F5F5F5">
                                                <div class="col-md-12">
                                                    <h4>Basic Information</h4>
                                                    <hr>
                                                </div>
                                                <br>
                                                <div class="col-md-5">

                                                    <label> Emitter Name : </label>
                                                    {{ $user->name }}
                                                </div>
                                                <div class="col-md-5">
                                                    <label> Pradesh : </label>
                                                    {{ $user->pradesh->pradesh_name }}
                                                </div>
                                                <div class="col-md-5">
                                                    <label> District :</label>
                                                    {{ $user->district->english_name }}
                                                </div>
                                                <div class="col-md-5">
                                                    <label> Municipality :</label>
                                                    {{ $user->municipality->muni_name }}
                                                </div>
                                                <div class="col-md-5">
                                                    <label> Ward :</label>
                                                    {{ $user->ward_no }}
                                                </div>
                                                <div class="col-md-5">
                                                    <label> Phone :</label>
                                                    {{ $user->phone_no }}

                                                </div>
                                                <div class="col-md-5">
                                                    <label> Email :</label>
                                                    {{ $user->email }}
                                                </div>
{{--                                                <div class="col-md-5">--}}
{{--                                                    <label> Fax :</label>--}}
{{--                                                    {{ $user->fax }}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-5">--}}
{{--                                                    <label> Website :</label>--}}
{{--                                                    {{ $user->website }}--}}
{{--                                                </div>--}}
{{--                                                <div class="col-md-5">--}}
{{--                                                    <label> Established Date :</label>--}}
{{--                                                    {{ $user->establish_date }}--}}
{{--                                                </div>--}}

                                            </div>



                                        </div>
                                        <div class="tab-pane fade show " id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab" style="padding-top: 20px;">

                                            <form id="myform" class="form-horizontal" action="{{url('/emitters/profile/password')}}" method="post">
                                                <div class="form-group {{ ($errors->has('old'))?'has-error':''}}">

                                                    <label for="old" class="col-sm-3 control-label">Old password</label>
                                                    <div class="col-sm-6">
                                                        <input type="password" name="old" class="form-control" id="old"
                                                               placeholder="Enter old password">
                                                        {!! $errors->first('old', '<span class="text-danger">:message</span>') !!}

                                                    </div>
                                                </div>
                                                <div class="form-group {{ ($errors->has('password'))?'has-error':''}}">
                                                    <label for="new" class="col-sm-3 control-label">New password</label>

                                                    <div class="col-sm-6">
                                                        <input name="password" type="password" class="form-control" id="new"
                                                               placeholder="Enter new Password">
                                                        {!! $errors->first('password', '<span class="text-danger">:message</span>') !!}

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="confirm" class="col-sm-3 control-label">Confirm password</label>

                                                    <div class="col-sm-6">
                                                        <input name="password_confirmation" type="password" class="form-control" id="confirm"
                                                               placeholder="Confirm Password">
                                                    </div>
                                                </div>
                                                {{csrf_field()}}

                                                <div class="form-group">
                                                    <div class="col-sm-offset-3 col-sm-10">
                                                        <button type="submit" class="btn btn-danger">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade show" id="custom-content-above-activity" role="tabpanel" aria-labelledby="custom-content-above-activity-tab" style="padding-top: 20px;">

                                            {{--                                            @if(sizeof($loginDetails) > 0)--}}

                                            {{--                                                @foreach($loginDetails as $detail)--}}
                                            {{--                                                    <div class="timeline">--}}
                                            {{--                                                        <!-- timeline time label -->--}}
                                            {{--                                                        <div class="time-label">--}}
                                            {{--                                                            <span class="bg-red">{{$detail->log_in_date}}</span>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <!-- /.timeline-label -->--}}

                                            {{--                                                        <!-- timeline item -->--}}
                                            {{--                                                        <div>--}}
                                            {{--                                                            <i class="fas fa-user bg-green"></i>--}}
                                            {{--                                                            <div class="timeline-item">--}}
                                            {{--                                                                <h3 class="timeline-header no-border">You logged in from {{$detail->log_in_device}}</h3>--}}
                                            {{--                                                            </div>--}}
                                            {{--                                                        </div>--}}
                                            {{--                                                        <!-- END timeline item -->--}}

                                            {{--                                                    </div>--}}

                                            {{--                                                @endforeach--}}

                                            {{--                                            @endif--}}

                                        </div>

                                    </div>

                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </div>
                            <!-- /.col -->
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')

    <script>
        $(document).ready(function(){
            $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#custom-content-above-tab a[href="' + activeTab + '"]').tab('show');
            }
        });

        // Check if url hash is not empty
        if(window.location.hash)
        {
            var hash = window.location.hash;
            localStorage.setItem('activeTab', hash);
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#custom-content-above-profile-tab a[href="' + activeTab + '"]').tab('show');
            }
        }
        else
        {
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab == '#custom-content-above-home-tab')
            {

                $('#custom-content-above-home-tab a[href="' + activeTab + '"]').tab('show');
            }
            else
            {
                var profileTab = '#custom-content-above-home-tab';
                $('#custom-content-above-home-tab a[href="' + profileTab + '"]').tab('show');
            }
        }






    </script>
@endsection
