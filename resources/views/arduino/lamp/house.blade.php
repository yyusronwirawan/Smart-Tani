@extends('layouts.app')

@section('title', $data['device_name'].' ('.ucwords($data['device_type']).')')

@section('content')

<x-modal.edit.lamp :device="$snapshot"/>
<div class="title">
    <h1 class="heading">{{$data['device_name']}}</h1>
    <div class="align-self-center d-inline-flex">
        <p class="text-secondary m-0">{{__('Added on')}} {{$data['date_created']}}</p>
        <p class="mx-3 text-secondary"> IP Address: {{ $data['ip_address'] }} </p>
        <p class="mr-3 text-secondary"> Wifi Name: {{ $data['wifi_ssid'] }} </p>
    </div>
    <nav aria-label="breadcrumb" class="small breadcrumb">
        <a class="breadcrumb-item" href="{{ route('arduino') }}">{{ __('Devices') }}</a>
        <span class="breadcrumb-item active text-capitalize">{{ $data['device_type'] }}</span>
        <span aria-current="page" class="breadcrumb-item active">{{ $data['device_name'] }}</span>
    </nav>
</div>
<div id="content" class="mt-3 row">
    <div class="col-12 mb-3 d-inline-block">
        <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#modelAddDeviceId">
            {{ __('+ Add Lamp') }}
        </button>
    </div>
    @if(Session::has('message'))
        <x-alert>
            {!! Session::get('message') !!}
        </x-alert>
    @endif
    @if(Session::has('success'))
        <x-alert>
            {!! Session::get('success') !!}
        </x-alert>
    @endif
    <div class="col-12 content-body mt-3">
        <div class="card shadow-sm">
            <div class="card-body py-2">
                <ul class="nav nav-pills nav-stacked" id="deviceTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="detailsTab" class="nav-link active" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="true">{{__('Informasi')}}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#setup" data-toggle="tab" role="tab" class="nav-link" aria-controls="setup" aria-selected="false" id="setupTab">{{__('Instalasi')}}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a href="#settings" data-toggle="tab" role="tab" class="nav-link" aria-controls="settings" aria-selected="false" id="settingsTab">{{__('Pengaturan')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="deviceContent" class="tab-content col-12 my-3">
        <div id="details" class="tab-pane active row show fade">
            @if($lampDocuments->size() > 0)
                @foreach ($titles as $title)
                    <div class="room-container">
                        <div class="col-12 my-3">
                            <span class="heading small">{{ $title }}</span>
                        </div>
                        @foreach($lampDocuments as $lamp)
                            @if($lamp['device_type'] == $title || $lamp['room'] == $title)
                                <x-page.device.list-device :device="$lamp" :houseId="$id" />
                            @endif
                        @endforeach
                    </div>
                @endforeach
            @else
                <x-page.not-found />
            @endif
            <div class="chart-container col-12 no-gutters">
                <x-card.sensor-chart-range chartRangeUrl="{{ route('sensor.chart', ['deviceId' => $id, 'deviceType' => 'house', 'userId' => session('uid')]) }}"/>
                <div class="chart-canvas-container row">
                    @foreach ($data['chart'] as $chart)
                        <x-card.sensor-chart :title="$chart" chartUrl="{{ route('sensor.chart', ['deviceId' => $id, 'deviceType' => 'house', 'userId' => session('uid')]) }}" />
                    @endforeach
                </div>
            </div>
            <x-card.sensor-data :device="$snapshot" />
            @if(!empty($data['location']['lng']) && !empty($data['location']['lat']))
                <x-card.maps zoom="15" :device="[$data['device_name']]" :location="[$data['location']]" />
            @endif
        </div>
        <div id="setup" class="tab-pane row fade content">
            <x-card.setup :device="$snapshot" updateUrl="{{route('sensor.update', ['deviceType' => __('house'), 'id' => session('uid'), 'deviceId' => $snapshot->id()])}}"/>
        </div>
        <div id="settings" class="tab-pane row fade content">
            <x-card.settings updateUrl="{{route('house.update', ['id' => $id])}}" :device="$data" />
            <div id="editDevice" class="d-none col-12 col-md-7 col-xl-9 mt-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 id="heading" class="card-title small">{{__('Edit Device')}}</h4>
                        <form action="{{ route('house.update', ['id' => $id]) }}" method="POST">
                            <input name="_method" type="hidden" value="PUT">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6 col-12">
                                    <label for="device_name">
                                        {{ __('Device Name') }}
                                    </label>
                                    <input type="text" name="device_name" required id="device_name"
                                        value="{{ $data['device_name'] }}"
                                        class="form-control @error('device_name') is-invalid @enderror"
                                        aria-describedby="device_nameId">
                                    @error('device_name')
                                        <span class=" invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6 col-12">
                                    <label for="ip_address">
                                        {{ __('IP Address') }}
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                        </svg>
                                    </label>
                                    <input required type="text" class="form-control @error('ip_address') is-invalid @enderror"
                                        value="{{ $data['ip_address'] }}" name="ip_address"
                                        id="ip_address" aria-describedby="ipAddressHelp" placeholder="">
                                    @error('ip_address')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="wifi_ssid">
                                        {{ __('SSID') }}
                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                        </svg>
                                    </label>
                                    <input required type="text" value="{{ $data['wifi_ssid'] }}"
                                        class="form-control @error('wifi_ssid') is-invalid @enderror" name="wifi_ssid"
                                        id="wifi_ssid" aria-describedby="wifi_ssidId" placeholder="">
                                    @error('wifi_ssid')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="wifi_password">{{ __('Wifi Password') }}</label>
                                    <input required type="password" value="{{ $data['wifi_password'] }}"
                                        class="form-control @error('wifi_password') is-invalid @enderror" name="wifi_password"
                                        id="wifi_password" placeholder="">
                                    @error('wifi_password')
                                        <span class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @if(!empty($data['location']['lng']) && !empty($data['location']['lat']))
                                <div class="row">
                                    <div class="form-group col-12 col-md-6">
                                        <label for="long">Longitude</label>
                                        <input required type="text" class="form-control @error("long") is-invalid @enderror"
                                            value="{{ $data['location']['lng'] }}" name="long" id="long"
                                            aria-describedby="longhelpId" placeholder="">
                                        @error('long')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-12 col-md-6">
                                        <label for="lat">Latitude</label>
                                        <input required type="text" class="form-control @error('lat') is-invalid @enderror"
                                            value="{{ $data['location']['lat'] }}" name="lat" id="lat"
                                            aria-describedby="lathelpId" placeholder="">
                                        @error('lat')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="button" id="getLocation" class="d-flex col-12 mx-3 p-0 btn btn-sm btn-link">Fill
                                        with current location</button>
                                    <div class="col-12 mb-2">
                                        <label for="map">Preview</label>
                                        <button type="button" id="mapPreview" class="d-block px-0 btn btn-sm btn-link">View
                                            map</button>
                                        <div id="map" class="map-container"></div>
                                    </div>
                                </div>
                            @endif
                            <button class="btn btn-sm btn-info" type="submit">{{ __('Update Device') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <x-card.delete deleteUrl="{{route('house.delete', ['id' => $id])}}"/>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/control.js')}}"></script>
    <script src="{{asset('js/room.js')}}"></script>
    <script src="{{asset('js/data-table.js')}}"></script>
    <script src="{{asset('js/chart.js')}}"></script>

    {{-- Google Maps --}}
    <script src="{{ asset('js/gmaps.js') }}"></script>
    <script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script>
    <script defer
        src="https://maps.googleapis.com/maps/api/js?map_ids=2c1cc1d0308173cb&key=AIzaSyBuA2OzJNAjDD_JBZ54SJAkfmONylNHOSo&callback=initMap&region=ID"
        type="text/javascript"></script>
@endpush
