@extends('backend.layouts.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="#"> <i class="fa fa-dashboard"></i>{{trans('app.dashboard')}}</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
           <center><div class="error-page">
                <h2 class="text-yellow" style="font-size: 50px;"> 404</h2>
            </div>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> SORRY </h3>
                    <p>
                        We could not find the page you were looking for.<br>
                        Meanwhile, you may <a href="{{url('/dashboard')}}">return to dashboard</a>
                    </p>
                </div>
            <div>
            </div>
           </center>
        </section>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $('#mdal').modal('show');
    </script>
@endsection
