<div {!! $attributes !!}
    class="device-card-body content-body col-12 col-sm-5 col-lg-4 col-xl-3 mb-3">
    <div class="device card shadow-sm">
        <div class="card-body">
            <div class="card-title device-title">
                <h4 class="heading d-inline-flex small">
                    {{ $device['device_name'] }}</h4>
                <!-- <span class="badge badge-danger align-self-center text-uppercase">baru</span> -->
            </div>
            <div class="d-inline-flex">
                <div class="align-self-center d-inline-block text-primary">
                    @switch($device['device_type'])
                        @case('garden')
                            <x-icons.garden />
                            @break
                        @case('lamp')
                            <x-icons.lamp />
                            @break
                        @case('house')
                            <x-icons.house />
                            @break
                        @case('door')
                            <x-icons.door />
                            @break
                        @default
                    @endswitch
                </div>
                <div data-house="{{$houseId}}" data-url="{{ route('sensor.update', ['deviceType' => $device['device_type'], 'deviceId' => $device->id(), 'id' => Session::get('uid'), 'houseId' => $houseId]) }}" class="@if($device['device_type'] != 'house') device-status @endif d-inline-block ml-3">
                    <div class="device-toggle">
                        @switch($device['device_type'])
                            @case('door')
                                <span class="door-lock mr-2">
                                    <div class="spinner-grow spinner-grow-sm" role="status">
                                        <span class="visually-hidden"></span>
                                    </div>
                                </span>
                                <span class="door-security mr-2">
                                    <div class="spinner-grow spinner-grow-sm" role="status">
                                        <span class="visually-hidden"></span>
                                    </div>
                                </span>
                                @break
                            @case('garden')
                                <span class="badge badge-info garden-toggle text-uppercase">
                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </span>
                                @break
                            @case('lamp')
                                <span class="lamp-toggle mr-2">
                                    <div class="spinner-grow spinner-grow-sm" role="status">
                                        <span class="visually-hidden"></span>
                                    </div>
                                </span>
                                <span class="badge badge-info lamp-sensor text-uppercase mr-2">
                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                </span>
                            @default
                                @break
                        @endswitch
                    </div>
                    <label class="label">{{ __('Diperbarui') }}</label>
                    <h6 data-updated="{{ date("d/m/Y H:i:s", strtotime($device['control']['timestamp']->formatAsString().' +7 hours')) }}"
                        class="font-weight-normal small last-updated"></h6>
                </div>
            </div>
            <a href="@if($device['device_type'] == 'house') {{ route('house.read', ['id' => $device->id()]) }} @elseif($device['device_type'] == 'lamp') {{ route('lamp.read', ['id' => $houseId, 'lampId' => $device->id()]) }} @else {{ route('arduino.read', ['id' => $device->id()]) }} @endif"
                class="stretched-link"></a>
        </div>
    </div>
</div>
