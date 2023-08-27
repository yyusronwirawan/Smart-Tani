@extends('layouts.app')

@section('title', $user->displayName)

@section('content')

<div id="title">
    <h1 id="heading">{{ __('profil') }}</h1>
    <div class="d-inline-flex">
        <div class="avatar rounded-circle bg-info">
            <span class="align-items-center h-100 d-flex font-weight-bold justify-content-center text-monospace text-primary w-100">{{ $initial }}</span>
        </div>
        <div class="d-inline-block ml-2 align-self-center">
            <p class="m-0 font-weight-bold text-primary">{{$user->displayName}}</p>
            <p class="m-0">{{ $user->email }}</p>
        </div>
    </div>
</div>
<div id="content" class="col-md-10 mt-3 content card-columns profile-card">
    @if(Session::has('success'))
        <x-alert>
            {{ Session::get('success') }}
        </x-alert>
    @endif
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Edit Profil') }}</h4>
            <form id="editProfileForm" method="POST" action="{{ route('user.update') }}">
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <div class="form-group">
                    <label for="first_name">{{ __('Nama Depan') }}</label>
                    <input type="text" name="first_name" id="firstName"
                class="form-control @error('first_name') is-invalid @enderror" value="{{old("first_name")}}" placeholder=""
                        autocomplete="given-name" autofocus aria-describedby="firstNameId">

                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="last_name">{{ __('Nama Belakang') }}</label>
                    <input type="text" name="last_name" id="lastName"
                class="form-control @error('last_name') is-invalid @enderror" value="{{ old("last_name") }}" placeholder=""
                        autocomplete="family-name" autofocus aria-describedby="lastNameId">

                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 mt-n3">
                    <small>Nama hanya dapat memuat 2 kata. Contoh: Bayu Wicaksono</small>
                </div>
                <button type="submit" class="btn btn-sm btn-info">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Edit Email') }}</h4>
            <form id="editProfileForm" method="POST" action="{{ route('email.update') }}" class="row">
                <input name="_method" type="hidden" value="PUT">
                @csrf
                <div class="form-group col-12">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror" value="{{ old("email") }}" placeholder=""
                        aria-describedby="emailId" autocomplete="email">
                    <small id="emailId" class="text-secondary">{{ __('Memperbarui email akan mengeluarkan akun dan anda harus melakukan login dengan email yang baru') }}</small>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group col-12">
                    <label for="password">{{__('Password')}}</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder=""
                        aria-describedby="passwordId">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-sm btn-info">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Perbarui Password') }}</h4>
            <form id="updatePasswordForm" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input name="_method" type="hidden" value="PUT">
                <div class="form-group">
                    <label for="current_password">{{ __('Password Lama') }}</label>
                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" required
                        autocomplete="current-password" name="current_password" placeholder="">
                    @error('current_password')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_new">{{ __('Password Baru') }}</label>
                    <input type="password" class="form-control @error('password_new') is-invalid @enderror" required
                        autocomplete="new-password" name="password_new" id="password_new" placeholder="">
                    @error('password_new')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">{{ __('Konfirmasi Password Baru') }}</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation" id="password-confirm" required autocomplete="new-password"
                        placeholder="">
                    @error('password_confirmation')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-sm btn-info">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{__('Hapus Akun')}}</h4>
            <form action="{{ route('user.delete') }}" method="post">
                @csrf
                <input name="_method" type="hidden" value="delete">
                <div class="form-group">
                    <label for="password_delete">{{__('Password')}}</label>
                    <input type="password" class="form-control @error('password_delete') is-invalid @enderror"
                        name="password_delete" required id="password_delete" placeholder="">
                    @error('password_delete')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <small class="mb-2 d-block text-secondary">
                    {{ __('Dengan memasukkan password dan menekan submit, akun ini dan data-data yang ada akan hilang') }}
                </small>
                <button type="submit" class="btn btn-sm btn-danger">{{__('Hapus Akun')}}</button>
            </form>
        </div>
    </div>
</div>
</section>
@endsection
