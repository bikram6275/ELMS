<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: rgb(14, 13, 13)">

    <!-- Brand Logo -->
    <a href="{{url('/dashboard')}}" class="brand-link">
        <img src="{{asset('/uploads/images/logo.png')}}" alt="AdminLTE Logo" class="brand-image elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"> &nbsp;</span>
    </a>

    @php
        $current_user = Auth::user();
        $current_link = str_replace(url('/'),'',URL::current());
    @endphp
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if($current_user->user_image!=null)
                    <img src="{{asset('/storage/uploads/users/images/profilePic/'.$current_user->user_image)}}"
                         class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{url('/uploads/images/dummyUser.gif')}}" class="img-circle elevation-2" alt="User Image">
                @endif

            </div>
            <div class="info">
                <a href="{{url('dashboard')}}" class="d-block">{{$current_user->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('/dashboard')}}" class="nav-link {{$current_link == '/dashboard' ? 'active' : ''}}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @foreach ($sidebar_menus as $parent_menus)
                    @if(count($parent_menus->children))
                    <li class="nav-item has-treeview" id="menu_{{$parent_menus->id}}">
                        <a href="#" class="nav-link ">
                           {!! $parent_menus->menu_icon !!}
                            <p>
                                {{$parent_menus->menu_name}}
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @foreach ($parent_menus->children as $child_menu)
                                 <li class="nav-item has-parent">
                                    <a href="{{url("$child_menu->menu_link")}}"
                                        class="nav-link {{$current_link == $child_menu->menu_link ? 'active' : ''}}">
                                         &nbsp;&nbsp;&nbsp;&nbsp;{!! $child_menu->menu_icon !!}
                                        <p>{{$child_menu->menu_name}}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{url($parent_menus->menu_link)}}"
                            class="nav-link {{$current_link == $parent_menus->menu_link ? 'active' : ''}}">
                            {!! $parent_menus->menu_icon !!}
                            <p>
                                {{$parent_menus->menu_name}}
                            </p>
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        </nav>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            console.log('DOM is ready.')
            let active_ele = document.querySelector('.active').parentElement;
            if(active_ele.classList.contains('has-parent')){
                active_ele.parentElement.style.display='block';
                active_ele.parentElement.parentElement.classList.add('menu-open');
            }
        });
    </script>
</aside>
