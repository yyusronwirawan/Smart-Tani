<div id="modal-1" class="content-body" aria-hidden="true">
    <div tabindex="-1" class="card shadow-sm" data-micromodal-close>
        <div role="dialog" class="card-body" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="card-title">
                <h4 class="heading d-inline-flex small card-title">{{ __('Tambah Perangkat') }}</h4>
                <button aria-label="Close modal" data-micromodal-close></button>
            </header>
            <div id="modal-1-content">
                <form action="{{ route('arduino.create') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-7 col-lg-6 col-12">
                            <label for="device_name">Device Name</label>
                            <input type="text" name="device_name" id="device_name"
                                class="form-control @error('device_name') is-invalid @enderror" placeholder=""
                                aria-describedby="deviceNameId">
                            @error('device_name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-5 col-lg-6 col-12">
                            <label for="device_type">Device Type</label>
                            <select class="form-control" name="device_type" id="device_type">
                                <option value="garden">Garden</option>
                                <option value="lamp">Lamp</option>
                                <option value="temperature" disabled>Temperature</option>
                                <option value="door" disabled>Door</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ip_address">
                            IP Address
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            </svg>
                        </label>
                        <input type="text" class="form-control @error('ip_address') is-invalid @enderror"
                            name="ip_address" id="ip_address" aria-describedby="ipAddressHelp" placeholder="">
                        @error('ip_address')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="wifi_ssid">
                                SSID Wifi
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input type="text" class="form-control" name="wifi_ssid" id="wifi_ssid"
                                aria-describedby="ssidWifiId" placeholder="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="wifi_password">Password Wifi</label>
                            <input type="password" class="form-control @error('wifi_password') is-invalid @enderror"
                                name="wifi_password" id="wifi_password" placeholder="">
                            @error('wifi_password')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <button class="btn btn-sm btn-info" type="submit">Add Device</button>
                </form>
            </div>
        </div>
    </div>
</div>
