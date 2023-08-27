<div class="content-body col-12 col-sm-5 col-lg-4 col-xl-3 mb-3">
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
                        @case('house')
                            <x-icons.house />
                            @break
                        @case('door')
                            <x-icons.door />
                            @break
                        @default
                    @endswitch
                </div>
                <div class="d-inline-block ml-3">
                    <h6 class="@if($device['control']['nilai'] == 0) text-danger @else text-success @endif font-weight-bold text-uppercase">@if($device['control']['nilai'] == 0) • Off @else • On @endif</h6>
                    <label
                        for="serialNumber">{{ __('Last Updated') }}</label>
                    <h6 class="font-weight-bold">{{ __('Just now') }}</h6>
                </div>
            </div>
            <a href="{{ route('arduino.read', ['id' => $device->id()]) }}"
                class="stretched-link"></a>
        </div>
    </div>
</div>
