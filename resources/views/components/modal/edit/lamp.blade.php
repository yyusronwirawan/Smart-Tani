@extends('components.modal.modal')

@section('modal.title', 'Tambah Lampu')

@section('modal.content')
<form
    action="{{ route('house.add', ['id' => $device->id()]) }}"
    method="POST">
    @csrf
    <label for="device" class="text-purple mb-2 font-weight-bold modal-subtitle py-2">
        {{ __('Jenis Perangkat') }}
    </label>
    <div>
        <label for="col-12 text-purple mb-2 font-weight-bold modal-subtitle py-2"
            for="device">{{ __('Device Info') }}</label>
        <div id="formDevice" class="form-group">
            <label for="lamp_name">Nama Perangkat</label>
            <input type="text" required name="lamp_name" value="{{ old('lamp_name') }}"
                id="lamp_name" class="form-control @error("lamp_name") is-invalid @enderror">
            @error('lamp_name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div id="formRooms" class="form-group">
            <label for="room">Ruangan</label>
            <select data-room="@isset($snapshot['room']) {{ $snapshot['room']}} @else {{"--Pilih Ruangan--"}} @endisset" data-url="{{route('room.list')}}" required class="form-control @error('room') is-invalid @enderror" name="room" id="room">
                <option @if(old('room')) @else selected @endif disabled>--Pilih Ruangan--
                </option>
            </select>
            @error('room')
                <span class="invalid-feedback">
                    <strong><{{$message}}/strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-info btn-sm">Tambah Perangkat</button>
    </div>
</form>
@endsection

