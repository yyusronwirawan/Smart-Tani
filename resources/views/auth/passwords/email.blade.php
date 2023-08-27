@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row vh-100">
        <div class="col-lg-4 col m-auto">
            <small id="heading">{{ __('Dashboard')}}</small>
            <h1 class="font-weight-bold text-primary">{{ __('Forgot Password?') }}</h1>
            <p class="text-secondary">{{ __('Input your email that has been registered to the account') }}</p>
            <div class="card shadow-lg">
                <div class="card-body">
                    <small id="heading">{{ __('Reset Password') }}</small>
                    <form method="POST" action="{{ route('user.reset') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{ __('Email')}}</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-describedby="emailHelpId" placeholder="">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div><button type="submit" class="btn btn-info">{{__('Submit')}}</button></div>
                        <div class="text-center small mt-4">
                            <p class="text-secondary">{{__('Not registered?')}} <a href="{{ url('register') }}">{{__('Sign up')}}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6 d-lg-block d-none text-center m-auto">
            <img class="img-fluid" src="{{asset('images/undraw_Login_re_4vu2.svg')}}">
        </div>
    </div>
</div>
@endsection
