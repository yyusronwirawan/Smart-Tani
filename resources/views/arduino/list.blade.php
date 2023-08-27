@extends('layouts.app')

@section('title', 'Perangkat')

@section('content')

<x-modal.add/>

<div class="title">
    <h1 class="heading">{{ __('Perangkat') }}</h1>
    <div class="align-self-center">
        <p class="m-0 text-secondary"></p>
        <p class="m-0 text-secondary">{{__('Perangkat diperbarui')}} <span data-time="{{strtotime(now())}}" class="time-now">...</span></p>
    </div>
</div>
<div class="content row mt-3">
    <div class="col-12 mb-3 d-inline-block">
        <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#modelAddDeviceId">
            {{ __('+ Tambah Perangkat') }}
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
    @if(isset($snapshot) || isset($houseSnapshot))
        @if($snapshot->size() > 0 || $houseSnapshot->size() > 0)
        <div class="content-body col-12">
            <div class="card shadow-sm">
                <div class="card-body p-2">
                    <ul class="nav nav-pills nav-stacked" id="deviceTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a id="houseTab" class="nav-link" data-toggle="tab" href="#house" role="tab" aria-controls="home" aria-selected="false">{{__('Rumah')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a id="otherTab" class="nav-link active" data-toggle="tab" role="tab" aria-controls="other" aria-selected="true" href="#other">{{__('Pintu dan Taman')}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
            <div class="tab-content col-12 my-3" id="deviceContent">
                <div id="house" role="tabpanel" aria-labelledby="house-tab" class="tab-pane row fade">
                    @if($houseSnapshot->size() > 0)
                        <div class="col-12 my-3">
                            <span class="heading small">{{__('Rumah')}}</span>
                        </div>
                        @foreach ($houseSnapshot as $houseItem)
                            <x-page.device.list-device :device="$houseItem" />
                        @endforeach
                    @else
                        <x-page.not-found/>
                    @endif
                </div>
                <div class="tab-pane row show active fade" id="other" role="tabpanel" aria-labelledby="other-tab">
                    @if($snapshot->size() > 0)
                        <div class="col-12 d-inline-block">
                            <div class="float-sm-right">
                                <form method="GET" action="{{ route('arduino') }}" class="form-inline">
                                    <div class="form-group p-0">
                                        <label for="sortBy" class="mr-2">{{__('Urutkan:')}}</label>
                                        <select onchange="this.form.submit()" class="form-control" name="sortBy" id="sortBy">
                                            <option @if(Request::get('sortBy')=='type' ) selected @endif value="type">{{__('Jenis Perangkat')}}
                                            </option>
                                            <option @if(Request::get('sortBy')=="room" ) selected @endif value="room">Ruangan</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @foreach($titles as $title)
                            <div class="col-12 my-3">
                                <span class="heading small">{{ $title == 'door' ? 'Pintu' : 'Taman' }}</span>
                            </div>
                            @foreach($snapshot as $device)
                                @if($device['device_type'] == $title || $device['room'] == $title)
                                    <x-page.device.list-device :device="$device" />
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        <x-page.not-found />
                    @endif
                </div>
            </div>
        @else

        <x-page.not-found />

        @endif
    @endif
</div>
@endsection
@push('scripts')
    <script src="{{asset('js/moment.js')}}"></script>
    <script src="{{asset('js/control.js')}}"></script>
@endpush
