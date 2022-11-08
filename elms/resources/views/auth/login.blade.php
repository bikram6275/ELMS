<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ELMS | Log in</title>
    <link rel="stylesheet" href="{{ asset('css/loginStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/bootstrap/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('uploads/images/fav-ico.png') }}" type="image/x-icon">
</head>

<body>

    @include('backend.message.flash')
    <div class="wrapper">
        <div class="title-text">
            <div class="title login">
                <img src="{{ asset('/uploads/images/logo.png') }}" class="login-can-logo" alt="">
            </div>
        </div>
        <div class="form-container">

            <div class="slide-controls">
                <label for="signup" class="slide signup" style="color: white;font-weight: 600;">ELMS Login</label>
            </div>


            <div class="form-inner">
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="field">
                        <input type="email" name="email" required placeholder="Email Address" />
                        @if ($errors->has('email'))
                            <span class="help-block" style="color: red;">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="field">
                        <input type="password" name="password" placeholder="Password" />
                        @if ($errors->has('password'))
                            <span class="help-block" style="color: red;">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="pass-link">
                        <a href="{{ route('password.request') }}">Forgot Password ?</a><br>
                    </div>
                    <div class="field btn">
                        <div class="btn-layer"></div>
                        <input type="submit" value="Login">
                    </div>

                </form>

            </div>

        </div>

        
    </div>
  
    {{-- <footer class="footer">
        <div class="container">
            <div class="col-sm-12 text-center" style="color: #ffffff">
                <span>Copyright © 2021 | All rights
                    reserved </span>
                <span> | Powered by <a href="https://www.youngminds.com.np/" target="_blank"
                        style="color: #47b99a"><strong>Young
                            Minds</strong></a></span>
            </div>

        </div>
    </footer> --}}
    <!-- jQuery -->
    <script src="{{ url('plugins/jquery/jquery.min.js') }}"></script>
</body>

</html>
