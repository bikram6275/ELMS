
<!DOCTYPE html>
<html>
<head>
    <<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Setup | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{url('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('dist/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition login-page">

<div class="login-box">

    <div class="login-logo" style="background-color: #ecf0f5; padding: 20px;">
        <span class="loginSystem"><b>Login Credentials</b></span>
    </div>

{{--<div class="login-logo">--}}
{{--<a href="../../index2.html"><b>Admin</b>LTE</a>--}}
{{--</div>--}}
<!-- /.login-logo -->

</div>

<div class="row">
    <div class="card">
        <div class="card-body login-card-body">
            <div class="login-logo" style="background-color: #ecf0f5; padding: 20px;">
                <span class="loginSystem"><b>Login Credentials</b></span>
            </div>

            @yield('content')
            <br>

            <div class="pdasost text-muted well well-sm no-shadow">
                <p class="warning">
                    Please input username and password,if
                    you are authorized to this
                    software. Unauthorized access is
                    punishable.
                </p>
            </div>

        </div>
    </div>
    <div class="col-md-4 col-md-offset-4" style="margin-top: 90px;">
        <div class="login-box-body" style="border-radius: 5px">
            <div class="login-logo" style="background-color: #ecf0f5; padding: 20px;">
                <span class="loginSystem"><b>Login Credentials</b></span>
            </div>
            @yield('content')
            <br>
            <div class="pdasost text-muted well well-sm no-shadow">
                <p class="warning">
                    Please input username and password,if
                    you are authorized to this
                    software. Unauthorized access is
                    punishable.
                </p>
            </div>
        </div>
    </div>
    <div style="position: fixed; bottom: 0; right: 0;">
        Developed By : <a href="http://www.youngminds.com.np/" target="_blank">YoungMinds</a><br>
    </div>
</div>

<script src="{{url('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('dist/js/adminlte.min.js')}}"></script>

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
<script>
    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>
</body>
</html>