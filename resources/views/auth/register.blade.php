@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row vh-100">
        <div class="col-lg-4 col m-auto">
            <div class="card shadow-lg">
                <div class="card-body">
                    <small id="heading">{{ __('Register') }}</small>
                    <form action="{{ route('user.create') }}" method="POST" id="registerForm"
                        class="row">
                        @csrf
                        <div class="form-group col-md-6 col-12">
                            <label for="first_name">{{ __('First Name') }}</label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                name="first_name" value="{{ old('first_name') }}" id="first_name"
                                required autocomplete="given-name" autofocus>

                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label for="last_name">{{ __('Last Name') }}</label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                name="last_name" value="{{ old ('last_name') }}" id="last_name"
                                autocomplete="family-name">

                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mt-n3 col">
                            <small>Name only contains maximum of 2 words. Example: John Smith</small>
                        </div>
                        <div class="form-group col-12">
                            <label for="email">{{ __('email') }}</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder=""
                                aria-describedby="emailHelp" value="{{ old('email') }}" required
                                autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label for="password">{{ __('password') }}</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder=""
                                aria-describedby="passwordHelp" value="{{ old('password') }}" required
                                autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label for="password-confirm">{{ __('confirm password') }}</label>
                            <input type="password" name="password_confirmation" id="password-confirm"
                                class="form-control @error('password_confirmation') is-invalid @enderror" placeholder=""
                                aria-describedby="passwordHelp" required autocomplete="new-password">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col"><button type="submit"
                                class="btn btn-info btn-block">{{ __('Register') }}</button></div>
                    </form>
                    <div class="text-center small mt-4">
                        <p class="text-secondary">{{ __('Already registered?') }} <a
                                href="{{ route('login') }}">{{ __('Login') }}</a>
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
