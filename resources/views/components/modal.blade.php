<div>
    <div class="modal animate__animated animate__fadeIn" id="modelAddDeviceId" tabindex="-1" role="dialog"
        aria-labelledby="modelAddDeviceTitleId" aria-hidden="true">
        <div class="modal-dialog animate__animated animate__fadeIn modal-dialog-centered" role="document">
            <div class="modal-content card shadow-sm">
                <div class="content-body">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="card-title">
                                <h4 class="heading d-inline-flex small card-title">
                                    {{ __('Tambah Perangkat') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('arduino.create') }}" method="post">
                                @csrf
                                <div class="row align-items-lg-baseline">
                                    <div class="row col-12 col-lg-6">
                                        <label class="col-12 text-purple mb-2 font-weight-bold modal-subtitle py-2"
                                            for="device">{{ __('Device Info') }}</label>
                                        <div class="col-12">
                                            <label for="device_type">Device Type</label>
                                            <div id="tiles"
                                                class="px-0 row no-gutters justify-content-between btn-group-toggle"
                                                data-toggle="buttons">
                                                <label
                                                    class="shadow-sm btn p-0 btn-outline-primary my-2 col-md-4 col-6 @if(old('device_type')=="
                                                    garden") active @else @endif ">
                                            <input type=" radio" name="device_type" value="garden" autocomplete="off"
                                                    <blade
                                                    if|(old(%26%2339%3Bdevice_type%26%2339%3B)%3D%3D%26%2334%3Bgarden%26%2334%3B%20)%20checked%20%40else%20%40endif%3E>
                                                    <svg width="3em" height="4em" viewBox="0 0 16 16"
                                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M7.21.8C7.69.295 8 0 8 0c.109.363.234.708.371 1.038.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8zm.413 1.021A31.25 31.25 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z" />
                                                        <path fill-rule="evenodd"
                                                            d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87l-.894-.448z" />
                                                    </svg>
                                                    <p>Garden</p>
                                                </label>
                                                <label
                                                    class="shadow-sm btn p-0 btn-outline-primary my-2 col-md-4 col-6 @if(old('device_type')=="
                                                    lamp") active @else @endif">
                                                    <input type="radio" name="device_type" value="lamp"
                                                        autocomplete="off" <blade
                                                        if|(old(%26%2339%3Bdevice_type%26%2339%3B)%3D%3D%26%2334%3Blamp%26%2334%3B%20)%20checked%20%40else%20%40endif%3E>
                                                    <svg width="3em" height="4em" viewBox="0 0 16 16"
                                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M13 3H3v4h10V3zM3 2a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H3zm4.5-1l.276-.553a.25.25 0 0 1 .448 0L8.5 1h-1zm-.012 9c-.337.646-.677 1.33-.95 1.949-.176.396-.318.75-.413 1.042a3.904 3.904 0 0 0-.102.36c-.01.047-.016.083-.02.11L6 13.5c0 .665.717 1.5 2 1.5s2-.835 2-1.5c0 0 0-.013-.004-.039a1.347 1.347 0 0 0-.02-.11 3.696 3.696 0 0 0-.1-.36 11.747 11.747 0 0 0-.413-1.042A34.827 34.827 0 0 0 8.513 10H7.487zm1.627-1h-2.23C6.032 10.595 5 12.69 5 13.5 5 14.88 6.343 16 8 16s3-1.12 3-2.5c0-.81-1.032-2.905-1.885-4.5z" />
                                                    </svg>
                                                    <p>Lamp</p>
                                                </label>
                                                <label
                                                    class="shadow-sm btn p-0 btn-outline-primary my-2 col-md-4 col-6 @if(old('device_type')=="
                                                    door") active @else @endif">
                                                    <input type="radio" name="device_type" value="door"
                                                        autocomplete="off" <blade
                                                        if|(old(%26%2339%3Bdevice_type%26%2339%3B)%3D%3D%26%2334%3Bdoor%26%2334%3B%20)%20checked%20%40else%20%40endif%3E>
                                                    <svg width="3em" height="4em" viewBox="0 0 16 16"
                                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z" />
                                                        <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z" />
                                                    </svg>
                                                    <p>Door</p>
                                                </label>
                                            </div>
                                            @error('device_type')
                                                <span class="text-danger">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="device_name">Device Name</label>
                                            <input type="text" required name="device_name"
                                                value="{{ old('device_name') }}" id="device_name"
                                                class="form-control @error(" device_name") is-invalid @enderror"
                                                aria-describedby="deviceNameHelpId">
                                            <small id="deviceNameHelpId" class="text-secondary">Device name can be
                                                filled
                                                with your product name such as <b>Arduino UNO</b> or
                                                <b>DHT22</b></small>
                                            @error('device_name')
                                                <span class="invalid-feedback">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-12">
                                            <label for="room">Rooms</label>
                                            <select required class="form-control" name="room" id="room">
                                                <option @if(old('room')) @else selected @endif disabled>--Select room--
                                                </option>
                                                <option @if(old('room')=="bedroom" ) selected @endif value="bedroom">
                                                    Bedroom
                                                </option>
                                                <option @if(old('room')=="kitchen" ) selected @endif value="kitchen">
                                                    Kitchen
                                                </option>
                                                <option @if(old('room')=="kids room" ) selected @endif
                                                    value="kids room">
                                                    Kids room</option>
                                                <option @if(old('room')=="family room" ) selected @endif
                                                    value="family room">Family room</option>
                                                <option @if(old('room')=="dining room" ) selected @endif
                                                    value="dining room">Dining room</option>
                                                <option @if(old('room')=="dressing room" ) selected @endif
                                                    value="dressing room">Dressing Room</option>
                                                <option @if(old('room')=="basement room" ) selected @endif
                                                    value="basement">
                                                    Basement</option>
                                                <option @if(old('room')=="outdoor room" ) selected @endif
                                                    value="outdoor">
                                                    Outdoor</option>
                                                <option @if(old('room')=="attic" ) selected @endif value="attic">
                                                    Attic</option>
                                                <option @if(old('room')=="media room" ) selected @endif
                                                    value="media room">
                                                    Media Room</option>
                                                <option @if(old('room')=="study room" ) selected @endif value="study">
                                                    Study
                                                </option>
                                                <option @if(old('room')=="laundry room" ) selected @endif
                                                    value="laundry room">Laundry room</option>
                                                <option @if(old('room')=="bathroom room" ) selected @endif
                                                    value="bathroom">
                                                    Bathroom</option>
                                                <option @if(old('room')=="living room" ) selected @endif
                                                    value="living room">Living Room</option>
                                            </select>
                                            <span>
                                                <small id="roomMessage"></small>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="row">
                                            <label class="col-12 mb-2 text-purple font-weight-bold modal-subtitle py-2"
                                                for="config">{{ __('Configuration') }}</label>
                                            <div class="form-group col-12">
                                                <label for="ip_address">
                                                    IP Address
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
                                            <div class="form-group col-sm-6">
                                                <label for="wifi_ssid">
                                                    SSID Wifi
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
                                            <div class="form-group col-sm-6">
                                                <label for="wifi_password">Password Wifi</label>
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
                                        <div class="row">
                                            <label class="col-12 mb-2 text-purple font-weight-bold modal-subtitle py-2"
                                                for="location">Location</label>
                                            <button type="button" id="getLocation"
                                                class="d-flex col-12 mx-3 p-0 btn btn-sm btn-link">Fill with current
                                                location</button>
                                            <div class="form-group col-12 col-md-6">
                                                <label for="long">Longitude</label>
                                                <input required type="text" class="form-control @error(" long")
                                                    is-invalid </blade
                                                    enderror|%26%2334%3B%20value%3D%26%2334%3B%7B%7Bold(%2526%252334%253Blong%2526%252334%253B)%7D%7D%26%2334%3B%20name%3D%26%2334%3Blong%26%2334%3B>
                                                id="long" aria-describedby="longhelpId" placeholder="">
                                                @error('long')
                                                    <span class="invalid-feedback">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <small id="longHelpId"
                                                    class="form-text text-muted">{{ __('Example: -7.068723') }}</small>
                                            </div>
                                            <div class="form-group col-12 col-md-6">
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
                                                <label for="map">Preview</label>
                                                <button type="button" id="mapPreview"
                                                    class="d-block px-0 btn btn-sm btn-link">View map</button>
                                                <div id="map" class="map-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-sm btn-info float-right" type="submit">Add Device</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
