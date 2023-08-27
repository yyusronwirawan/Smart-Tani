<div class="col-12 col-sm-7 col-md-5 col-xl-3 mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="small card-title">{{ __('Hapus Perangkat') }}</h4>
            <div class="d-block">
                <form method="POST"
                    action="{{$deleteUrl}}">
                    <input name="_method" type="hidden" value="DELETE">
                    @csrf
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input required type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" id="password" autocomplete="current-password" placeholder="Password akun">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
