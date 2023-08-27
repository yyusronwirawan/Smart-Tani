@extends('components.modal.modal')

@section('modal.title', 'Tambah Perangkat')

@section('modal.content')
@if($errors->any())
    <x-alert>
        {{ __('Sepertinya ada input yang tidak valid') }}
    </x-alert>
@endif
    <form action="{{ route('arduino.create') }}" method="post">
        @csrf
        <div id="addDevice" data-interval="false" data-wrap="false" class="carousel">
            <ol class="carousel-indicators d-flex justify-content-around step font-weight-bolder">
                <li data-target="#addDevice" data-slide-to="0" class="active align-items-center d-flex justify-content-center rounded-circle active">1</li>
                <li data-target="#addDevice" class="align-items-center d-flex justify-content-center rounded-circle" data-slide-to="1">2</li>
                <li data-target="#addDevice" class="align-items-center d-flex justify-content-center rounded-circle" data-slide-to="2">3</li>
                <li data-target="#addDevice" class="align-items-center d-flex justify-content-center rounded-circle" data-slide-to="3">4</li>
            </ol>
            <div class="row align-items-baseline" role="listbox">
                <div class="carousel-item active">
                    <label class="col-12 text-purple mb-2 font-weight-bold modal-subtitle py-2"
                    for="device">{{ __('Perangkat') }}</label>
                <div class="col-12">
                    <label for="device_type">{{ __('Pilih perangkat') }}</label>
                    <div id="tiles"
                        class="px-0 row no-gutters justify-content-between btn-group-toggle"
                        data-toggle="buttons">
                        <label class="shadow-sm btn p-0 btn-outline-primary my-2 col-md-4 col-6 @if(old('device_type')=="
                            garden") active @else @endif ">
                            <input type="radio" name="device_type" value="garden" autocomplete="off" @if(old('device_type')=="garden" ) checked @else @endif>
                            <x-icons.garden/>
                            <p>Taman</p>
                        </label>
                        <label
                            class="shadow-sm btn p-0 btn-outline-primary my-2 col-md-4 col-6 @if(old('device_type')=="
                            house") active @else @endif">
                            <input type="radio" name="device_type" value="house" autocomplete="off"
                                @if(old('device_type')=="house" ) checked @else @endif>
                                <x-icons.house/>
                                <p>{{ __('Rumah') }}</p>
                        </label>
                        <label
                            class="shadow-sm btn p-0 btn-outline-primary my-2 col-md-4 col-6 @if(old('device_type')=="
                            door") active @else @endif">
                            <input type="radio" name="device_type" value="door" autocomplete="off"
                                @if(old('device_type')=="door" ) checked @else @endif>
                            <x-icons.door/>
                            <p>Pintu</p>
                        </label>
                    </div>
                    @error('device_type')
                        <span class="text-danger">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                </div>
                <div class="carousel-item">
                    <label class="col-12 text-purple mb-2 font-weight-bold modal-subtitle py-2"
                    for="device">{{ __('Info Perangkat') }}</label>
                    <div id="formDevice" class="form-group col-12">
                        <label for="device_name">Nama Perangkat</label>
                        <input type="text" required name="device_name"
                            value="{{ old('device_name') }}" id="device_name"
                            class="form-control @error("device_name") is-invalid @enderror"
                            aria-describedby="deviceNameHelpId">
                        @error('device_name')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div id="formRooms" class="form-group col-12">
                        <label for="room">Ruangan</label>
                        <select data-url="{{route('room.list')}}" class="form-control @error('room') is-invalid @enderror" name="room" id="room">
                            <option @if(old('room')) @else selected @endif disabled>--Pilih ruangan--
                            </option>
                        </select>
                        @error('room')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="carousel-item">
                    <div id="formConfig">
                        <label class="col-12 mb-2 text-purple font-weight-bold modal-subtitle py-2"
                            for="config">{{ __('Konfigurasi') }}</label>
                        <div class="form-group col-12">
                            <label for="ip_address">
                                Alamat IP
                                <svg width="1em" height="1em" viewBox="0 0 16 16"
                                    class="bi bi-info-circle-fill" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input type="text"
                                class="form-control @error('ip_address') is-invalid @enderror"
                                value="{{ old("ip_address") }}" name="ip_address"
                                id="ip_address" aria-describedby="ipAddressHelp" placeholder="">
                            @error('ip_address')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-12">
                            <label for="wifi_ssid">
                                SSID WiFi
                                <svg width="1em" height="1em" viewBox="0 0 16 16"
                                    class="bi bi-info-circle-fill" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input value="{{ old("wifi_ssid") }}" type="text"
                                class="form-control" name="wifi_ssid" id="wifi_ssid"
                                aria-describedby="ssidWifiId" placeholder="">
                        </div>
                        <div class="form-group col-12">
                            <label for="wifi_password">Password WiFi</label>
                            <input value="{{ old('wifi_password') }}"
                                type="password"
                                class="form-control @error('wifi_password') is-invalid @enderror"
                                name="wifi_password" id="wifi_password" placeholder="">
                            @error('wifi_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div id="formLocation" class="carousel-item">
                    <div>
                        <label class="col-12 mb-2 text-purple font-weight-bold modal-subtitle py-2"
                            for="location">Lokasi</label>
                        <button type="button" id="getLocation"
                            class="d-flex col-12 mx-3 p-0 btn btn-sm btn-link">Isi dengan lokasi saya</button>
                        <div class="form-group col-12">
                            <label for="long">Longitude</label>
                            <input required type="text" class="form-control @error("long") is-invalid
                                @enderror" value="{{ old("long") }}" name="long"
                                id="long" aria-describedby="longhelpId" placeholder="">
                            @error('long')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small id="longHelpId"
                                class="form-text text-muted">{{ __('Example: -7.068723') }}</small>
                        </div>
                        <div class="form-group col-12">
                            <label for="lat">Latitude</label>
                            <input required type="text"
                                class="form-control @error('lat') is-invalid @enderror"
                                value="{{ old('lat') }}" name="lat" id="lat"
                                aria-describedby="lathelpId" placeholder="">
                            @error('lat')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <small id="latHelpId"
                                class="form-text text-muted">{{ __('Example: 110.437096') }}</small>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="map">Pratinjau</label>
                            <button type="button" id="mapPreview"
                                class="d-block px-0 btn btn-sm btn-link">Lihat Peta</button>
                            <div id="map" class="map-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Add Device Step" class="justify-content-between d-flex">
            <a name="prevButton" id="prevButton" role="button" data-slide="prev" class="btn btn-info btn-sm" href="#addDevice" role="button">Sebelumnya</a>
            <a name="nextButton" id="nextButton" role="button" data-slide="next" class="btn btn-info btn-sm" href="#addDevice" role="button">Selanjutnya</a>
            <button type="submit" class="d-none btn btn-info btn-sm">Tambah Perangkat</button>
        </nav>
    </form>
@push('scripts')
<script src="{{asset('js/gmaps.js')}}"></script>
<script>
    $(document).ready(function () {
        //Form

        $("#addDevice.carousel").on('slid.bs.carousel', function onslide(ev) {
            if (ev.relatedTarget.id == "formLocation") {
                if ($('#nextButton').hasClass('d-none') == false) {
                    $('#nextButton').addClass('d-none')
                }
                if ($("button[type='submit']").hasClass('d-none')) {
                    $("button[type=submit]").removeClass('d-none')
                }
            } else {
                if ($('#nextButton').hasClass('d-none')) {
                    $('#nextButton').removeClass('d-none')
                }
                if ($("button[type='submit']").hasClass('d-none') == false) {
                    $("button[type=submit]").addClass('d-none')
                }
            }
        })

        function houseSelected() {
            if ($("[value='house']").is(':checked')) {
                $('#formRooms').toggleClass('d-none')
                // if ($('#formRooms').hasClass('d-none') == false) {
                //     $('#formRooms').addClass('d-none')
                // }
            } else {
                $('#formRooms').removeClass('d-none');
                // if ($('#formRooms').hasClass('d-none') == true) {
                //     $('#formRooms').removeClass('d-none')
                // }
            }
        }

        houseSelected();

        $('[type="radio"]').on('click', function () {
            if ($(this).val() == "house") {
                if ($('#formRooms').hasClass('d-none') == false) {
                    $('#formRooms').addClass('d-none')
                }
            } else {
                if ($('#formRooms').hasClass('d-none') == true) {
                    $('#formRooms').removeClass('d-none')
                }
            }
        })
    })

</script>

@endpush
@endsection
