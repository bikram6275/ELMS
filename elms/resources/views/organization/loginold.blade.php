@extends('layouts.app')

@section('content')

    <form method="POST" action="{{ route('orgs.signin') }}">
        {{ csrf_field() }}

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Login Email Address" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        @if ($errors->has('email'))
            <span class="help-block" style="color: red;">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
        @endif

        <div class="input-group mb-3">
            <input type="password" id="password-field" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        @if ($errors->has('password'))
            <span class="help-block" style="color: red;">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
        @endif
        <div class="row">
            <div class="col-xs-12 col-md-12">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember Me
                    </label>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>

            {{--<div class="col-xs-4">--}}
            {{--<button type="submit" class="btn btn-primary btn-block btn-flat" value="signIn">Sign In</button>--}}
            {{--</div>--}}
        </div>
    </form>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-6">
        </div>
    </div>

@endsection
