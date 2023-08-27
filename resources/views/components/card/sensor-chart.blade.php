<div class="content-body col-xl-4 col-md-6 col-12 mt-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 id="heading" class="heading small card-title">{{ $title }}</h4>
            <div class="mt-5 text-center">
                <div class="chart-loading spinner-border" role="status">
                    <span class="sr-only">Memuat...</span>
                </div>
                <div class="chart-error"></div>
                <canvas class="chart-canvas" data-url={{ $chartUrl }} data-title="{{ $title }}"></canvas>
            </div>
        </div>
    </div>
</div>
