@extends('layouts.app')

@section('title', 'Riwayat Kendali')

@section('content')
<div class="title">
    <h1 class="heading">{{ __('Riwayat Kendali') }}</h1>
    <div class="align-self-center">
        <p class="text-secondary">Menampilkan riwayat kendali yang dikendalikan oleh Anda</p>
    </div>
</div>
{{-- <div class="content row mt-3">
    <div class="content-body col-12 mt-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 id="heading" class="heading small card-title">{{ __('Riwayat Kendali') }}</h4>
                <div class="mt-5">
                    <table id="table" data-locale="id-ID" data-pagination="true" data-height="400"
                        data-total-not-filtered-field="totalNotFiltered" data-side-pagination="server"
                        data-show-button-text="true" data-toggle="table" data-buttons-class="info"
                        data-buttons-prefix="btn-sm btn" data-show-refresh="true"
                        data-classes="table table-striped table-borderless small" data-mobile-responsive="true"
                        data-check-on-init="true" data-show-search-clear-button="true"
                        data-url="{{ route('api.control', ['userId' => session('uid')]) }}">
                        <thead>
                            <tr>
                                <th data-field="timestamp">{{ __('Waktu') }}</th>
                                <th data-field="device_name">
                                    {{ __('Perangkat') }}
                                </th>
                                <th class="text-capitalize" data-field="device_type">{{ __('Tipe') }}</th>
                                <th data-field="nilai">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<h4 class="title small" id="heading">
    Linimasa
</h4>
<div class="row mt-3">
    <div class="col-lg-3 pr-3 mb-3">
        <form action="{{ route('control') }}" method="get">
            <div class="form-group">
                <label for="device">Jenis Perangkat</label>
                <select onchange="this.form.submit()" class="form-control" name="device" id="device">
                    <option selected disabled>--Pilih Perangkat--</option>
                    <option value="lamp" @if(Request::get('device')=='lamp' ) selected @endif>Lampu</option>
                    <option @if(Request::get('device')=='door' ) selected @endif value="door">Pintu</option>
                    <option @if(Request::get('device')=='garden' ) selected @endif value="garden">Kebun</option>
                </select>
            </div>
        </form>
        <a href="{{route('control')}}" class="btn btn-info btn-sm">Hapus Filter</a>
    </div>
    @if(!empty($pagination['data']))
        <div class="col-lg-9 col-12 content mb-5 overflow-auto py-3 rounded row" style="max-height: 25em">
            @foreach ($control as $key => $item)
                <div class="align-items-center col-md-3 d-md-flex bg-light justify-content-center mb-n1 pb-md-4">
                    <span class="text-secondary" style="opacity: 0.5;font-size: 2em; font-weight: 800;">{{$key != 0 ? ((date("d/m", strtotime($control[$key]['timestamp']->formatAsString())) != date("d/m", strtotime($control[$key - 1]['timestamp']->formatAsString()))) ? date("d/m", strtotime($item['timestamp']->formatAsString())) : '') : date("d/m", strtotime($control[$key]['timestamp']->formatAsString())) }}</span>
                </div>
                <div class="content-body timeline col-md-8 col-12 mb-n1">
                    <div class="device card shadow-sm">
                        <a class="stretched-link" href="{{$item['device_type'] != 'lamp' ? route("arduino.read", ['id' => $item['id']]) : '#' }}"></a>
                        <div class="card-body">
                            <div class="mt5 row no-gutters align-items-center justify-content-between">
                                <div class="col-12 card-title device-title">
                                    <h4 class="heading d-inline-flex small">
                                        {{!empty($item['device_name']) ? $item['device_name'] : 'undefined'}}
                                    </h4>
                                </div>
                                <div class="d-inline-flex">
                                    <div class="align-self-center d-inline-block text-primary">
                                        @switch($item['device_type'])
                                            @case('lamp')
                                                <x-icons.lamp/>
                                                @break
                                            @case('garden')
                                                <x-icons.garden/>
                                                @break
                                            @case('door')
                                                <x-icons.door/>
                                                @break
                                            @default
                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                @break
                                        @endswitch
                                    </div>
                                    <div class="d-inline-block ml-3">
                                        <div class="device-toggle">
                                            @switch($item['device_type'])
                                                @case('lamp')
                                                    <span class="mr-2">
                                                        @if ($item['control']['nilai'] == 1)
                                                            <i class="fas fa-lightbulb"></i>
                                                        @else
                                                            <i class="fas fa-lightbulb text-secondary"></i>
                                                        @endif
                                                    </span>
                                                    <span class="mr-2 font-weight-bold">
                                                        {{__('Sensor: ')}}
                                                        @php
                                                            switch ($item['control']['nilai']) {
                                                                case '0':
                                                                    $status = 'aktif';
                                                                    break;
                                                                case '1':
                                                                    $status = 'cahaya';
                                                                    break;
                                                                case '2':
                                                                    $status = 'gerak';
                                                                    break;
                                                                default:
                                                                    return '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>';
                                                                    break;
                                                            }
                                                        @endphp
                                                        <span class="badge badge-info text-uppercase">
                                                            {{!empty($status) ? $status : '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>'}}
                                                        </span>
                                                    </span>
                                                    @break
                                                @case('door')
                                                    <span class="mr-2">
                                                        @if ($item['control']['nilai'] == 1)
                                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-unlock text-secondary" aria-hidden="true"></i>
                                                        @endif
                                                    </span>
                                                    <span class="mr-2">
                                                        @if ($item['control']['security'] == 1)
                                                            <i class="fa fa-shield" aria-hidden="true"></i>
                                                        @else
                                                            <i class="fa fa-shield text-secondary" aria-hidden="true"></i>
                                                        @endif
                                                    </span>
                                                @break
                                                @case('garden')
                                                <span class="mr-2 font-weight-bold">
                                                    {{__('Status: ')}}
                                                    @php
                                                        switch ($item['control']['nilai']) {
                                                            case '0':
                                                                $status = 'otomatis';
                                                                break;
                                                            case '1':
                                                                $status = 'terjadwal';
                                                                break;
                                                            case '2':
                                                                $status = 'aktif';
                                                                break;
                                                            case '3':
                                                                $status = 'nonaktif';
                                                                break;
                                                            default:
                                                                // return response()->json(['message' => 'Sensor tidak terdaftar'], 500);
                                                                break;
                                                        }
                                                    @endphp
                                                    <span class="text-uppercase badge badge-info">{{!empty($status) ? $status : 'Tidak diketahui'}}</span>
                                                </span>
                                                @break
                                                @default
                                                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                @break
                                            @endswitch
                                        </div>
                                        <span class="small text-secondary">
                                            {{date("d/m/y H:i:s", strtotime($item['timestamp']->formatAsString()))}}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-inline-flex">
                                    <span class="small text-secondary">
                                        {{date("H:i", strtotime($item['timestamp']->formatAsString()))}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-xl-12 col-lg-12 col-12" aria-label="Page navigation">
            <div class="pagination justify-content-between">
                <div class="first">
                    <a name="previous" id="previous" class="@if($pagination['current_page'] == 1) disabled @endif btn btn-info btn-sm" href="{{$pagination['prev_page_url']}}" role="button"><i class="fa fa-chevron-left" aria-hidden="true"></i> Sebelumnya</a>
                    <a name="first" id="first" class="@if($pagination['current_page'] == 1) disabled @endif btn btn-info btn-sm" href="{{$pagination['first_page_url']}}" role="button">{{$pagination['first_page']}}</a>
                </div>
                <div class="last">
                    <a name="last" id="last" class="@if($pagination['current_page'] == $pagination['last_page']) disabled @endif btn btn-info btn-sm" href="{{$pagination['last_page_url']}}" role="button">{{$pagination['last_page']}}</a>
                    <a name="next" id="next" class="@if($pagination['current_page'] == $pagination['last_page']) disabled @endif btn btn-info btn-sm" href="{{$pagination['next_page_url']}}" role="button">Selanjutnya <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    @else
    <div class="p-3 d-block mx-auto my-3">
        <div class="col-8 col-md-4 m-auto text-center">
            <img class="img-fluid" src="{{ asset('images/Group 62.svg') }}" alt="Empty">
        </div>
        <p class="text-center text-secondary">Anda belum mengendalikan perangkat</p>
    </div>
        {{-- <x-page.not-found/> --}}
    @endif
</div>
@endsection
@push('scripts')
    <script src="{{ asset('js/data-table.js') }}"></script>
@endpush
