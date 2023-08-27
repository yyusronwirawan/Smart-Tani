<div class="p-3 d-block mx-auto my-3">
    <div class="col-8 col-md-4 m-auto text-center">
        <img class="img-fluid" src="{{ asset('images/Group 62.svg') }}" alt="Empty">
    </div>
    <p class="text-center text-secondary">Anda belum memiliki perangkat</p>
    <div class="text-center">
        @if(Route::is('arduino') || Route::is('house.read'))
            <button data-toggle="modal" data-target="#modelAddDeviceId" type="button" class="btn btn-info btn-sm">Tambah Perangkat Pertama</button>
        @else
            <a href="{{ route('arduino', ['addDevice' => 'true']) }}"
                class="btn btn-info btn-sm">Tambah Perangkat Pertama</a>
        @endif
    </div>
</div>
