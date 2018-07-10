@extends('layouts.admin.login')

@section('content')
    <div class="login-box-body">
        <p class="login-box-msg"><h3>Login</h3></p>

        <form action="{{ route('password.request') }}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            @if ($errors->has('email'))
                <div class="help-block" style="text-align: left; color: #800000; width: 100%">
                    <label>{{ $errors->first('email') }}</label>
                </div>
            @endif


            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @if ($errors->has('password'))
                <div class="help-block" style="text-align: left; color: #800000; width: 100%">
                    <label>{{ $errors->first('password') }}</label>
                </div>
            @endif

            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @if ($errors->has('password_confirmation'))
                <div class="help-block" style="text-align: left; color: #800000; width: 100%">
                    <label>{{ $errors->first('password_confirmation') }}</label>
                </div>
            @endif

            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <button type="submit" class="btn btn-block btn-flat" style="background-color: #9C27B0; color: #fff; font-weight: bold">Reset Password</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <div class="row" style="margin-top: 20px;">
            <a href="/login">Login</a>
        </div>
    </div>
@endsection
