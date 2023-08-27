<div id="setup" class="col-12 mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 id="heading" data-toggle="tooltip" data-placement="top" title="Bersifat Rahasia"
                class="small card-title">{{ __('Instalasi') }}</h4>
            @if($device['device_type'] != 'lamp')
                <section class="mt-4">
                    <h5 class="font-weight-bold">{{__('Unduh file arduino')}}</h5>
                    <p>{{__('Unduh file arduino kemudian pasang pada perangkat Arduino anda')}}</p>
                    @if($device['device_type'] != "door")
                        <a name="downloadButton" id="downloadButton" class="btn btn-info btn-sm"
                            href="{{ route('sensor.download', ['userId' => session('uid'), 'deviceId' => $device->id(), 'device_type' => $device['device_type']]) }}"
                            role="button"><i class="fas fa-file-download"></i> Unduh</a>
                    @else
                        <p class="text-secondary">File Arduino tidak tersedia</p>
                    @endif
                </section>
                <section class="my-4">
                    <h5 class="font-weight-bold">Baca Kendali Perangkat</h5>
                    <div class="code bg-light px-2 mb-2">
                        <code id="controlApi">
                            {{$updateUrl}}
                        </code>
                        <button data-clipboard-target="#controlApi" id="copyButton"
                            class="text-secondary small btn btn-sm p-2 clipboard">
                            <i class="fas fa-clipboard"></i><span class="badge badge-info"></span>
                            {{ __('Salin') }}
                        </button>
                    </div>
                    <p>
                        Salin link berikut ke fungsi "baca kendali" untuk mendapatkan nilai kendali Arduino anda.
                        <code>{{ session('uid') }}</code> adalah id user dan
                        <code>{{ $device['device_type'] }}</code>
                        adalah jenis perangkat anda (<code>garden</code>, <code>lamp</code>, or
                        <code>door</code>). Hati-hati, link ini mengandung informasi sensitif.
                    </p>
                </section>
            @endif
            @if ($device['device_type'] != 'house')
                <section class="my-4">
                    <h5 class="font-weight-bold">Perbarui Kendali</h5>
                    <div class="code bg-light px-2 mb-2">
                        @if($device['device_type'] == 'lamp')
                            <code id="controlAddApi">
                                {{ route('control.add', ['deviceId' => $device->id(), 'deviceType' => $device['device_type'], 'userId' => session('uid'), 'houseId' => $houseId]) }}
                            </code>
                        @else
                            <code id="controlAddApi">
                                {{ route('control.add', ['deviceId' => $device->id(), 'deviceType' => $device['device_type'], 'userId' => session('uid')]) }}
                            </code>
                        @endif
                        <button data-clipboard-target="#controlAddApi" id="copyButton"
                                class="text-secondary small btn btn-sm p-2 clipboard">
                            <i class="fas fa-clipboard"></i><span class="badge badge-info"></span>
                            {{ __('Salin') }}
                        </button>
                    </div>
                    <p>Salin link berikut ke fungsi "perbarui kendali" untuk memperbarui nilai kendali Arduino anda.</p>
                        <h6>Parameter</h6>
                        <p>Berikut daftar parameter yang harus dimasukkan:</p>
                        @foreach ($device->data()['control'] as $key=>$value)
                            @if($key != 'timestamp')
                                <li>
                                    <code>{{$key}} <i class="text-secondary">{{__('int')}}</i></code>
                                </li>
                            @endif
                        @endforeach
                </section>
            @endif
            @if($device['device_type'] != 'lamp')
                @if($device['device_type'] != 'door')
                    <section class="my-4">
                        <h5 class="font-weight-bold">{{ __('Tambah Data Sensor') }}</h5>
                        <div class="code bg-light px-2 mb-2">
                            <code id="addApi">
                                {{ route('sensor.add', ['deviceId' => $device->id(), 'id' => session('uid'), 'deviceType' => $device['device_type']]) }}
                            </code>
                            <button data-clipboard-target="#addApi" id="copyButton"
                                class="text-secondary small btn btn-sm p-2 clipboard">
                                <i class="fas fa-clipboard"></i><span class="badge badge-info"></span>
                                {{ __('Salin') }}
                            </button>
                        </div>
                        <p>Salin link berikut ke fungsi "perbarui kendali" untuk memperbarui nilai kendali Arduino anda. <code>{{ $device->id() }}</code> adalah id perangkat dan
                            <code>{{ session('uid') }}</code> adalah id user. Hati-hati, link ini mengandung informasi sensitif.
                        </p>
                        <h6>Parameter</h6>
                        <p>Berikut parameter yang harus dimasukkan:</p>
                        @foreach($device['sensor'] as $item)
                        @if($item != "tanggal" && $item != "jam")
                            <li>
                                <code>{{ $item }}</code> <i class="text-secondary">int</i>
                            </li>
                        @endif
                        @endforeach
                    </section>
                @endif
            @endif
        </div>
    </div>
</div>
