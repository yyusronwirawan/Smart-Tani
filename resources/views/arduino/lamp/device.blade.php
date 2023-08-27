@extends('layouts.app')

@section('title', $snapshot['device_name'].' ('.ucwords($snapshot['device_type']).')')

@section('content')
    <div class="title">
        <h1 class="heading">{{$snapshot['device_name']}}</h1>
        <div class="align-self-center d-inline-flex">
            <p class="text-secondary m-0">{{__('Added on')}} {{$snapshot['date_created']}}</p>
        </div>
        <nav aria-label="breadcrumb" class="small breadcrumb">
            <a class="breadcrumb-item" href="{{ route('arduino') }}">{{ __('Devices') }}</a>
            <span class="breadcrumb-item active text-capitalize">{{ __('House') }}</span>
            <a href="{{ route('house.read', ['id' => $houseSnapshot->id()]) }}" class="breadcrumb-item text-capitalize">{{ $houseSnapshot['device_name'] }}</a>
            <span class="breadcrumb-item active text-capitalize">{{ $snapshot['device_type'] }}</span>
            <span class="breadcrumb-item active text-capitalize">{{ $snapshot['room'] }}</span>
            <span aria-current="page" class="breadcrumb-item active">{{ $snapshot['device_name'] }}</span>
        </nav>
        <div id="content" class="mt-3 row">
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
                    <div class="card-body p-2">
                        <ul class="nav nav-pills nav-stacked" id="deviceTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#setup" data-toggle="tab" role="tab" class="nav-link active" aria-controls="setup" aria-selected="false" id="setupTab">{{__('Instalasi')}}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#settings" data-toggle="tab" role="tab" class="nav-link" aria-controls="settings" aria-selected="false" id="settingsTab">{{__('Pengaturan')}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="deviceContent" class="tab-content col-12 my-3">
                <div id="setup" class="tab-pane active show row fade content">
                    <x-card.setup :device="$snapshot" :houseId="$houseSnapshot->id()"/>
                </div>
                <div id="settings" class="tab-pane row fade content">
                    <x-card.settings updateUrl="{{ route('lamp.update', ['id' => $houseId, 'lampId' => $lampId]) }}" :device="$snapshot"/>
                    <div id="editDevice" class="d-none col-12 col-lg-6 col-md-6 mt-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h4 id="heading" class="card-title small">{{ __('Edit Device') }}
                                </h4>
                                <form
                                    action="{{ route('lamp.update', ['id' => $houseId, 'lampId' => $lampId]) }}"
                                    method="POST">
                                    <input name="_method" type="hidden" value="PUT">
                                    @csrf
                                    <div class="form-group">
                                        <label for="device_name">
                                            {{ __('Device Name') }}
                                        </label>
                                        <input type="text" name="device_name" required id="device_name"
                                            value="{{ $snapshot['device_name'] }}"
                                            class="form-control @error('device_name') is-invalid @enderror"
                                            aria-describedby="device_nameId">
                                        @error('device_name')
                                            <span class=" invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="room">Rooms</label>
                                        <select data-room="{{ $snapshot['room'] }}"
                                            data-url="{{ route('room.list') }}" required
                                            class="form-control" name="room" id="room">
                                            <option disabled>--Select room--</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-sm btn-info"
                                        type="submit">{{ __('Update Device') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <x-card.delete
                        deleteUrl="{{ route('lamp.delete', ['id' => $houseId, 'lampId' => $lampId]) }}" />
                </div>
            </div>
        </div>
    </div>
@push('scripts')
    <script type="module" src="{{ asset('js/gmaps.js') }}"></script>
@endpush
@endsection
