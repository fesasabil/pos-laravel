@extends('Layouts.auth')

@section('title')
    <title>Login</title>
@endsection

@section('content')
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign In</p>
    
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach            
            </ul>
        </div> 
    @endif
<form method="POST" action="{{ route('login') }}">
@csrf
    <div class="form-group has-feedback">
        <input type="email" name="email" class="form-control" placeholder="{{ __('E-mail Address')}}" value="{{ old('email')}}">
        <span class="fa fa-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="{{ __('Password')}}" value="{{ old('password')}}">
        <span class="fa fa-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <div class="col-8">
            <div class="checkbox icheck">
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                </label>
            </div>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
    </div>
</form>

<div class="social-auth-links text-center mb-3">
    <p>- OR -</p>
    <a href="#" class="btn btn-block btn-primary">
        <i class="fa fa-facebook mr-2"></i> Sign in using Facebook
    </a>
    <a href="#" class="btn btn-block btn-danger">
        <i class="fa fa-google-plus mr-2"></i> Sign in using Google
    </a>
</div>

    <p class="mb-1">
        <a href="#">I forgot my password</a>
    </p>
    <p class="mb-0">
        <a href="#" class="text-center">Register a new membership</a>
    </p>
    </div>
</div>
@endsection
