@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="title">
    <h1 class="heading">{{ __('Dashboard') }}</h1>
    <div class="align-self-center">
        <p class="m-0 text-secondary current-time"></p>
    </div>
</div>
<div class="content row mt-3">
    <div class="content-body col-12">
        <div class="card shadow-sm">
            <div class="card-body p-2">
                <ul class="nav nav-pills nav-stacked" id="deviceTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="#dashboard" data-toggle="tab" role="tab" class="nav-link active"
                            aria-controls="dashboard" aria-selected="true" id="dashboardTab">
                            <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-house-door-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.5 10.995V14.5a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V11c0-.25-.25-.5-.5-.5H7c-.25 0-.5.25-.5.495z" />
                                <path fill-rule="evenodd" d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                            </svg>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="houseTab" class="nav-link" data-toggle="tab" href="#house" role="tab"
                            aria-controls="house" aria-selected="false">{{ __('Rumah') }}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="gardenTab" class="nav-link" data-toggle="tab" role="tab" aria-controls="garden"
                            aria-selected="false" href="#garden">{{ __('Taman') }}</a>
                    </li>
                    {{-- <li class="nav-item" role="presentation">
                        <a href="#door" id="doorTab" class="nav-link" role="tab" aria-controls="door" data-toggle="tab"
                            aria-selected="false">{{ __('Door') }}</a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
    <div class="tab-content col-12 my-3" id="deviceContent">
        <div id="dashboard" class="tab-pane active row show fade">
            <div class="col-lg-12 col-xl-12 col-md-12 col-12 my-3">
                <h4 id="heading" class="card-title small">
                    {{__('Perangkat')}}
                </h4>
                <div class="device-container row">
                    <div class="col-12 col-md-6 device-count-card-body mb-3">
                        <div class="align-items-center font-weight-bold card p-2 shadow-sm text-primary">
                            <x-icons.house />
                            {{__('Rumah')}}
                        </div>
                        <div class="bg-primary card device-count font-weight-bold position-absolute rounded-circle shadow-sm text-white">
                            {{$house->size()}}
                        </div>
                    </div>
                    <div class="d-none col-md-6 col-12 device-count-card-body mb-3">
                        <div class="align-items-center font-weight-bold card p-2 shadow-sm text-primary">
                            <x-icons.lamp />
                            {{__('Lampu')}}
                        </div>
                        <div class="bg-primary card device-count font-weight-bold position-absolute rounded-circle shadow-sm text-white">
                            @foreach ($lamp as $item)
                                @php
                                    $itemSize[] = $item->size();
                                @endphp
                            @endforeach
                            {{!empty($itemSize) ? array_sum($itemSize) : '0'}}
                        </div>
                    </div>
                    <div class="col-md-6 col-12 device-count-card-body mb-3">
                        <div class="align-items-center font-weight-bold card p-2 shadow-sm text-primary">
                            <x-icons.garden />
                            {{__('Taman')}}
                        </div>
                        <div class="bg-primary card device-count font-weight-bold position-absolute rounded-circle shadow-sm text-white">
                            {{$garden->size()}}
                        </div>
                    </div>
                    <div class="col-md-6 col-12 device-count-card-body mb-3">
                        <div class="align-items-center font-weight-bold card p-2 shadow-sm text-primary">
                            <x-icons.door />
                            {{__('Pintu')}}
                        </div>
                        <div class="bg-primary card device-count font-weight-bold position-absolute rounded-circle shadow-sm text-white">
                            {{$door->size()}}
                        </div>
                    </div>
                </div>
                <a name="devices" id="devices" class="btn btn-info btn-sm" href="{{route('arduino')}}" role="button">{{__('Lihat daftar perangkat')}}</a>
            </div>
            <div class="col-lg-5 col-xl-4 col-md-6 col-12 my-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 id="heading" class="card-title small">
                            {{ __('Cuaca') }}
                        </h4>
                        <div class="weather-loading-container col-12 text-center">
                            <div class="weather-loading mx-auto spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div style="display: none" class="weather-container">
                            <div class="d-inline-flex align-items-center">
                                <img src="" alt="">
                                <span style="font-size: 4em" class="text-degree text-primary font-weight-bold"></span>
                            </div>
                            <p class="city text-capitalize font-weight-bold my-0" style="font-size: 1.3em"></p>
                            <p class="conditions text-capitalize"></p>
                            <span class="text-secondary d-block">
                                <p>
                                    Diperbarui:
                                    <span class="weather-update-time">
                                        ...
                                    </span>
                                    <a class="ml-1 text-secondary weather-refresh">
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                    </a>
                                </p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <x-card.maps zoom="17" :device="$device" :location="$location" />
        </div>
        <div id="house" data-id="house" role="tabpanel" aria-labelledby="house-tab" class="tab-pane content row fade">
            @if($house->size() > 0)
                <div class="chart-container col-12 no-gutters">
                    <x-card.sensor-chart-range chartRangeUrl="" />
                    @foreach($house as $device)
                        <div class="chart-canvas-container row">
                            @foreach($device['chart'] as $chart)
                                <x-card.sensor-chart :title="$chart"
                                    chartUrl="{{ route('sensor.chart', ['deviceType' => $device['device_type'], 'userId' => session('uid')]) }}" />
                            @endforeach
                        </div>
                        @break
                    @endforeach
                </div>
            @else
                <x-page.not-found />
            @endif
        </div>
        <div id="garden" data-id="garden" role="tabpanel" aria-labelledby="garden-tab" class="tab-pane row fade">
            @if($garden->size() > 0)
                <div class="chart-container col-12 no-gutters">
                    <x-card.sensor-chart-range chartRangeUrl="" />
                    @foreach($garden as $device)
                        <div class="chart-canvas-container row">
                            @foreach($device['chart'] as $chart)
                                <x-card.sensor-chart :title="$chart"
                                    chartUrl="{{ route('sensor.chart', ['deviceType' => $device['device_type'], 'userId' => session('uid')]) }}" />
                            @endforeach
                        </div>
                        @break
                    @endforeach
                </div>
            @else
                <x-page.not-found />
            @endif
        </div>
        {{-- <div id="door" role="tabpanel" aria-labelledby="door-tab" class="tab-pane row fade">

        </div> --}}
    </div>
</div>
@endsection
@push('scripts')
    {{-- <script type="module" src="{{ asset('js/moment.js') }}"></script> --}}
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/gmaps.js') }}"></script>

    {{-- Google Maps --}}
    <script src="https://unpkg.com/@googlemaps/markerclustererplus/dist/index.min.js"></script>
    <script defer
        src="https://maps.googleapis.com/maps/api/js?map_ids=2c1cc1d0308173cb&key=AIzaSyBuA2OzJNAjDD_JBZ54SJAkfmONylNHOSo&callback=initMap&region=ID"
        type="text/javascript"></script>
    <script src="{{ asset('js/weather.js') }}"></script>
    <script type="module" src="{{ asset('js/data-table.js') }}"></script>
@endpush
