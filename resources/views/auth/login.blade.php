@extends('layouts.admin.login')

@section('content')

    <div class="login-box-body">
        <p class="login-box-msg"><h3>Login</h3></p>

        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            @if ($errors->has('email'))
                <div class="help-block" style="text-align: left; color: #800000; width: 100%">
                    <label>{{ $errors->first('email') }}</label>
                </div>
            @endif
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @if ($errors->has('password'))
                <div class="help-block" style="text-align: left; color: #800000; width: 100%">
                    <label>{{ $errors->first('password') }}</label>
                </div>
            @endif
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> Manter-me conectado
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-block btn-flat" style="background-color: #800000; color: #fff; font-weight: bold">Entrar</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <a href="{{ route('password.request') }}">Esquecí minha senha</a><br>
    </div>
@endsection
