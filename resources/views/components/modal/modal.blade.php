<div class="modal fade" id="modelAddDeviceId" tabindex="-1" role="dialog"
    aria-labelledby="modelAddDeviceTitleId" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content card shadow-sm">
            <div class="content-body">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="card-title">
                            <h4 class="heading d-inline-flex small card-title">
                                @yield('modal.title')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @yield('modal.content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
