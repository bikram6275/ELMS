<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{url('/dashboard')}}" class="brand-link">
        <img src="{{asset('/uploads/images/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> &nbsp;</span>
    </a>

@php
    $current_user = Auth::guard('orgs')->user();
    $current_link = str_replace(url('/'),'',URL::current());

@endphp
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if($current_user->org_image!=null)
                    <img src="{{asset('/storage/uploads/organization/images/organizationPic/'.$current_user->org_image)}}"
                         class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{url('/uploads/images/dummyUser.gif')}}" class="img-circle elevation-2" alt="User Image">
                @endif

            </div>
            <div class="info">
                <a href="{{url('orgs/dashboard')}}" class="d-block">{{$current_user->org_name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('/orgs/dashboard')}}" class="nav-link {{$current_link == '/orgs/dashboard' ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" data-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="setting">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        <span class="menu-title">Employee</span>
                        <i class="fas fa-angle-left right"></i>
                    </a>
                    <div class="collapse" id="setting">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('/orgs/employeeRecord')}}"><i class="fa fa-users" aria-hidden="true"></i> Employee Record</a></li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('/orgs/employee/award')}}"><i class="fa fa-users" aria-hidden="true"></i> Award</a></li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('/orgs/employee/leave')}}"><i class="fa fa-users" aria-hidden="true"></i> Leave</a></li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('/orgs/employee/punishment')}}"><i class="fa fa-users" aria-hidden="true"></i> Punishment</a></li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('orgs/employee/experience')}}"><i class="fa fa-users" aria-hidden="true"></i> Experience</a></li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('orgs/employee/training')}}"><i class="fa fa-users" aria-hidden="true"></i> Trainings</a></li>
                        </ul>
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{url('orgs/employee/responsibility')}}"><i class="fa fa-users" aria-hidden="true"></i> Responsibility</a></li>
                        </ul>

                    </div>
                </li>
            </ul>
        </nav>
    </div>

</aside>




