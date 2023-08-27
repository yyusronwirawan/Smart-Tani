<div class="@if(Route::is('login') || Route::is('profile')) @else col-12 @endif content-body">
    <div class="alert alert-dismissible bg-purple fade shadow show text-white" role="alert">
        <span class="font-weight-bold">{{ $slot }}</span>
        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
