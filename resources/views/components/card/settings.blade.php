<div id="editDevice" class="col-12 col-sm-5 col-md-7 col-xl-9 mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="card-title small">{{ __('Edit Device') }}</h4>
            <form action="{{ $updateUrl }}"
                method="POST">
                <input name="_method" type="hidden" value="PUT">
                @csrf
                @if(!empty($device['room']))
                    <div class="form-group">
                        <label for="room">{{__('Ruangan')}}</label>
                        <select data-room="{{$device['room']}}" data-url="{{route('room.list')}}" required placeholder="{{$device['room']}}" class="form-control" name="room" id="room">
                            <option disabled>{{__('--Pilih ruangan--')}}</option>
                        </select>
                    </div>
                @endif
                <div class="row">
                    <div class="form-group col-lg-6 col-12">
                        <label for="device_name">{{ __('Nama Perangkat') }}</label>
                            <input required type="text" name="device_name" id="device_name"
                                value="{{ $device['device_name'] }}"
                                class="form-control @error('device_name') is-invalid @enderror" placeholder=""
                                aria-describedby="device_nameId">
                            @error('device_name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    @if(!empty($device['ip_address']))
                        <div class="form-group col-lg-6 col-12">
                            <label for="ip_address">
                                {{ __('Alamat IP') }}
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input required type="text" class="form-control @error('ip_address') is-invalid @enderror"
                                value="{{ $device['ip_address'] }}" name="ip_address"
                                id="ip_address" aria-describedby="ipAddressHelp" placeholder="">
                            @error('ip_address')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if(!empty($device['wifi_ssid']))
                        <div class="form-group col-sm-6">
                            <label for="wifi_ssid">
                                {{ __('SSID') }}
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input required type="text" value="{{ $device['wifi_ssid'] }}"
                                class="form-control @error('wifi_ssid') is-invalid @enderror" name="wifi_ssid"
                                id="wifi_ssid" aria-describedby="wifi_ssidId" placeholder="">
                            @error('wifi_ssid')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                    @if(!empty($device['wifi_password']))
                        <div class="form-group col-sm-6">
                            <label for="wifi_password">{{ __('Password Wifi') }}</label>
                            <input required type="password" value="{{ $device['wifi_password'] }}"
                                class="form-control @error('wifi_password') is-invalid @enderror" name="wifi_password"
                                id="wifi_password" placeholder="">
                            @error('wifi_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @endif
                </div>
                @if(!empty($device['location']['lng']) && !empty($device['location']['lat']))
                <div class="row">
                    <div class="form-group col-12 col-md-6">
                      <label for="long">{{__('Longitude')}}</label>
                      <input required type="text" class="form-control @error("long") is-invalid @enderror" value="{{ $device['location']['lng'] }}" name="long" id="long" aria-describedby="longhelpId" placeholder="">
                        @error('long')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-12 col-md-6">
                        <label for="lat">{{__('Latitude')}}</label>
                        <input required type="text" class="form-control @error('lat') is-invalid @enderror" value="{{ $device['location']['lat'] }}" name="lat" id="lat" aria-describedby="lathelpId" placeholder="">
                        @error('lat')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button type="button" id="getLocation" class="d-flex col-12 mx-3 p-0 btn btn-sm btn-link">{{__('Isi otomatis dengan lokasi saya')}}</button>
                    <div class="col-12 mb-2">
                        <label for="map">{{__('Pratinjau')}}</label>
                        <button type="button" id="mapPreview" class="d-block px-0 btn btn-sm btn-link">{{('Lihat peta')}}</button>
                        <div id="map" class="map-container"></div>
                    </div>
                </div>
                @endif
                <button class="btn btn-sm btn-info"
                    type="submit">{{ __('Perbarui Perangkat') }}</button>
            </form>
        </div>
    </div>
</div>
