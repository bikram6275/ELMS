<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
        {{-- <a href="index3.html" class="nav-link">Home</a> --}}
        {{-- </li> --}}
        {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
        {{-- <a href="#" class="nav-link">Contact</a> --}}
        {{-- </li> --}}
    </ul>
    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3"> --}}
    {{-- <div class="input-group input-group-sm"> --}}
    {{-- <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"> --}}
    {{-- <div class="input-group-append"> --}}
    {{-- <button class="btn btn-navbar" type="submit"> --}}
    {{-- <i class="fas fa-search"></i> --}}
    {{-- </button> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </form> --}}

    <!-- Right navbar links -->


    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right ">

                <?php $name = Auth::guard('web')->user()->name ?? (Auth::guard('orgs')->user()->org_name ?? Auth::guard('emitter')->user()->name); ?>
                <span class="dropdown-item dropdown-header" style="    display: flex;
                flex-direction: column;
                align-items: center;">
                    @if (Auth::guard('web')->check() && Auth::guard('web')->user()->user_image != null)
                        <img src="{{ asset('/storage/uploads/users/images/profilePic/' . Auth::user()->user_image) }}"
                            class="img-circle elevation-2" alt="User Image" style="width: 100px;height: 90px;">
                        <a href="{{ url('dashboard') }}" class="d-block">{{ $name }}</a>
                    @elseif(Auth::guard('orgs')->check() && Auth::guard('orgs')->user()->org_image != null)
                        <img src="{{ asset('/storage/uploads/organization/images/organizationPic/' . Auth::guard('orgs')->user()->org_image) }}"
                            class="img-circle elevation-2" alt="User Image" style="width: 100px;height: 90px;">
                        <a href="{{ url('/orgs/dashboard') }}" class="d-block">{{ $name }}</a>
                    @elseif(Auth::guard('emitter')->check() && Auth::guard('emitter')->user()->name != null)
                        <img src="{{ url('/uploads/images/dummyUser.gif') }}"
                            class="dropdown-item dropdown-header text-center" alt="User Image"
                            style="width: 100px;height: 90px;">
                        <a href="{{ url('/dashboard') }}" class="d-block">{{ $name }}</a>
                    @else
                        <img src="{{ url('/uploads/images/dummyUser.gif') }}"
                            class="dropdown-item dropdown-header text-center" alt="User Image"
                            style="width: 100px;height: 90px;">
                        <a href="{{ url('/dashboard') }}" class="d-block">{{ $name }}</a>
                    @endif

                    Settings
                </span>
                <div class="dropdown-divider"></div>
                @if (Auth::guard('web')->check())
                    <a href="{{ url('profile') }}" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> View Profile
                    </a>
                @elseif(Auth::guard('emitter')->check())
                    <a href="{{ url('emitters/profile') }}" class="dropdown-item"
                        onclick="myprofile('#custom-content-above-profile')">
                        <i class="fas fa-user mr-2"></i> View Profile
                    </a>
                @else
                    <a href="{{ url('orgs/profile') }}" class="dropdown-item"
                        onclick="myprofile('#custom-content-above-profile')">
                        <i class="fas fa-user mr-2"></i> View Profile
                    </a>
                @endif

                <div class="dropdown-divider"></div>
                @if (Auth::guard('web')->check())
                    <a href="{{ url('/profile') }}" class="dropdown-item">
                        <i class="fas fa-cogs mr-2"></i> Change Password
                    </a>
                @elseif(Auth::guard('emitter')->check())
                    <a href="{{ url('/emitters/profile') }}" class="dropdown-item"
                        onclick="changepassword('#custom-content-above-home')">
                        <i class="fas fa-cogs mr-2"></i> Change Password
                    </a>
                @else
                    <a href="{{ url('/orgs/profile') }}" class="dropdown-item"
                        onclick="changepassword('#custom-content-above-home')">
                        <i class="fas fa-cogs mr-2"></i> Change Password
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                @if (Auth::guard('web')->check())
                    <a href="{{ url('/questionnaire') }}" class="dropdown-item">
                        <i class="fas fa-download mr-2"></i> Download Questionnaire
                    </a>
                @elseif(Auth::guard('emitter')->check())
                    <a href="{{ url('/questionnaire') }}" class="dropdown-item">
                        <i class="fas fa-download mr-2"></i> Download Questionnaire
                    </a>
                @else
                    <a href="{{ url('/questionnaire') }}" class="dropdown-item">
                        <i class="fas fa-download mr-2"></i> Download Questionnaire
                    </a>
                @endif
                <div class="dropdown-divider"></div>
                @php
                    if (Auth::guard('web')->check() == true) {
                        $logout = 'logout';
                    } elseif (Auth::guard('orgs')->check() == true) {
                        $logout = 'orgs.logout';
                    } elseif (Auth::guard('emitter')->check() == true) {
                        $logout = 'emitter.logout';
                    }
                @endphp
                <a href="{{ route($logout) }}" class="dropdown-item" onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>

                <form id="logout-form" action="{{ route($logout) }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

                <div class="dropdown-divider"></div>
            </div>
        </li>

        {{-- <li class="nav-item"> --}}
        {{-- <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"> --}}
        {{-- <i class="fas fa-th-large"></i> --}}
        {{-- </a> --}}
        {{-- </li> --}}
    </ul>
</nav>
<!-- /.navbar -->
