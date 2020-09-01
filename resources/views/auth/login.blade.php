@extends('admin.layouts.auth')

@section('content')
<form class="form-signin" action="{{ route('login') }}" method="POST">
    @csrf

    <h2 class="form-signin-heading">{{ __('sign in now') }}</h2>
    <div class="login-wrap">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="text" class="form-control" name="email" placeholder="Email Address" autofocus>
        
        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
        <input type="password" class="form-control" name="password" placeholder="Password">
        

        <label class="checkbox">
            <input type="checkbox" value="remember-me"> Remember me
            <span class="pull-right">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                    </a>
                @endif
            </span>
        </label>
        <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
        <div class="registration">
            Don't have an account yet?
            <a class="" href="">
                Create an account
            </a>
        </div>

    </div>
  </form>
@endsection
