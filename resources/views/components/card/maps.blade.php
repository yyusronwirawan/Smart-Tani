<div class="col-lg-7 col-xl-8 col-md-6 col-12 mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="card-title small">{{ __('Lokasi Perangkat') }}</h4>
            <div class="map-js-container" style="height: 400px" id="mapJs" data-zoom="{{$zoom}}" data-location='@json($location)' data-device='@json($device)'></div>
        </div>
    </div>
</div>
