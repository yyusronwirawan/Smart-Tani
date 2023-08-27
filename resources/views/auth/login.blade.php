@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row vh-100">
        <div class="col-lg-4 col m-auto">
            <small id="heading">{{ __('DASHBOARD') }}</small>
            <h1 class="font-weight-bold text-primary">{{ __('Login') }}</h1>
            <p class="text-secondary">
                {{ __('Input the email and password that you have been registered') }}
            </p>
            <div class="card shadow-lg">
                <div class="card-body">
                    @if(Session::has('message'))
                    <x-alert>
                        {!! Session::get('message') !!}
                    </x-alert>
                    @endif
                    @if(Session::has('success'))
                        <x-alert>
                            {!! Session::get('success') !!}
                        </x-alert>
                    @endif
                    <form method="POST" action="{{ route('user.login', ['redirect' => Request::get('redirect')]) }}" id="formLogin">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                value="{{ old('email') }}" name="email" required autocomplete="email"
                                autofocus aria-describedby="emailHelp">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" required
                                autocomplete="current-password" name="password" id="password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="form-check">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        {{ __('Remember Me') }}
                        </label>
                </div> --}}
                <input type="hidden" id="_token" name="_token" value="{{ Session::token() }}">
                <button type="submit" class="btn btn-info btn-block">{{ __('Login') }}</button>
                </form>
                <div class="text-center small mt-4">
                    <p class="text-secondary">{{ __('Not registered?') }} <a
                            href="{{ route('register') }}">{{ __('Sign Up') }}</a>
                        <br>
                        @if(Route::has('user.forgot'))
                            <a
                                href="{{ route('user.forgot') }}">{{ __('Forgot Your Password?') }}</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 d-lg-block d-none text-center m-auto">
        <img class="img-fluid" src="{{ asset('images/undraw_Login_re_4vu2.svg') }}">
    </div>
</div>
</div>
@endsection
