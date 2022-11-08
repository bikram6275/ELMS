<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="{{url('/dashboard')}}" class="brand-link">
        <img src="{{asset('/uploads/images/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> &nbsp;</span>
    </a>

    @php
        $current_user = Auth::guard('emitter')->user();
        $current_link = str_replace(url('/'),'',URL::current());

    @endphp
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">

                    <img src="{{url('/uploads/images/dummyUser.gif')}}" class="img-circle elevation-2" alt="User Image">

            </div>
            <div class="info">
                <a href="{{url('emitters/dashboard')}}" class="d-block">{{$current_user->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('/emitters/dashboard')}}" class="nav-link {{$current_link == '/emitters/dashboard' ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
            

{{--                <li class="nav-item">--}}
{{--                    <a href="{{url('/emitters/survey')}}" class="nav-link ">--}}
{{--                        <i class="fas fa-poll"></i>--}}
{{--                        <p>--}}
{{--                            Survey--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}



            </ul>
        </nav>


    </div>

</aside>




