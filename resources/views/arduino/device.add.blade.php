@extends('layouts.app')

@section('content')
<div id="title">
    <h1 id="heading">Tambah Perangkat</h1>
    <div class="align-self-center">
        <p class="m-0 text-secondary">Total Perangkat: 9</p>
        <div class="d-md-inline-flex">
            <nav class="breadcrumb px-0 bg-transparent">
                <a class="breadcrumb-item" href="../arduino">Arduino</a>
                <span class="breadcrumb-item active">Tambah Perangkat</span>
            </nav>
        </div>
    </div>
</div>
<div id="content" class="row mt-3">
    <div id="content-body" class="col-12 col-md-8 mb-3">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="card-title">
                    <h4 id="heading" class="d-inline-flex small card-title">Tambah Perangkat</h4>
                </div>
                <div class="d-inline-block">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div>
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            </svg>
                            <span>Buka halaman <a href="bantuan.html">bantuan</a> untuk instruksi tambah perangkat
                                Arduino</span>
                        </div>
                    </div>
                    <script>
                        $(".alert").alert();

                    </script>
                </div>
                <form action="" method="post">
                    <div class="row">
                        <div class="form-group col-md-5 col-lg-6 col-12">
                            <label for="deviceType">Jenis Perangkat</label>
                            <select class="form-control" name="deviceType" id="deviceType">
                                <option>Kebun</option>
                                <option>Pintu</option>
                                <option>Lampu</option>
                            </select>
                        </div>
                        <div class="form-group col-md-7 col-lg-6 col-12">
                            <label for="deviceName">Nama Perangkat</label>
                            <div class="d-flex">
                                <span class="mr-3 align-self-center">Lampu</span>
                                <input type="text" name="deviceName" id="deviceName" class="form-control" placeholder=""
                                    aria-describedby="deviceNameId">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ipAddress">
                            IP Address
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            </svg>
                        </label>
                        <input type="text" class="form-control" name="ipAddress" id="ipAddress"
                            aria-describedby="ipAddressHelp" placeholder="">
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label for="ssidWifi">
                                SSID Wifi
                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill"
                                    fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </label>
                            <input type="text" class="form-control" name="ssidWifi" id="ssidWifi"
                                aria-describedby="ssidWifiId" placeholder="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="passwordWifi">Password Wifi</label>
                            <input type="password" class="form-control" name="passwordWifi" id="passwordWifi"
                                placeholder="">
                        </div>
                    </div>
                    <button class="btn btn-sm btn-info" type="submit">Tambah Perangkat</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    <script type="module" src="{{ asset('js/gmaps.js') }}"></script>
@endpush
