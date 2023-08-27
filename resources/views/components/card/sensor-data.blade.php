<div class="content-body col-12 mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 id="heading" data-id="{{ $device->id() }}" class="heading small card-title">
                {{ __('Data Sensor') }}</h4>
            <div class="mt-5 table-container">
                <div class="mb-md-0 mb-2 row no-gutters date-range">
                    <div class="col-12 form-group mb-0">
                        <label for="daterange">{{ __('Jarak Data') }}</label>
                        <input class="form-control" type="daterange" name="daterange" id="daterange">
                    </div>
                </div>
                <table id="table" data-locale="id-ID" data-id="{{ $device->id() }}" data-sortable="false" data-toolbar="#toolbar"
                    data-url="{{ route('sensor.read', ['deviceType' => $device['device_type'], 'deviceId' => $device->id(), 'id' => session('uid'), 'endDate' => date("d-m-Y"), 'startDate' => date("d-m-Y", strtotime('-1 month'))]) }}"
                    data-pagination="true" data-side-pagination="server" data-height="460"
                    data-total-not-filtered-field="totalNotFiltered" data-show-button-text="true"
                    data-locale-export="Export" data-show-export="true" data-toggle="table" data-buttons-class="info"
                    data-buttons-prefix="btn-sm btn" data-show-refresh="true"
                    data-classes="table table-striped table-borderless small" data-mobile-responsive="true"
                    data-check-on-init="true">
                    <thead>
                        <tr>
                            @foreach($device['sensor'] as $keys)
                                <th data-field="{{ $keys }}"
                                    class="@if($keys == 'sm') text-uppercase @else text-capitalize @endif">
                                    {{ $keys }}</th>
                            @endforeach
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
