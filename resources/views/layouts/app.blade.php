<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://kit.fontawesome.com/ffa7b87ca6.js" crossorigin="anonymous"></script>
    @if(Session::has('user'))
        <link href="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/gh/akottr/dragtable@master/dragtable.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">

    <title>@yield('title') / Aplikasi Monitoring IoT</title>


</head>

<body>
    <main>
        <div class="bg-light">
            @if(Session::has('user'))
                <nav class="d-lg-none sticky-top navbar navbar-expand-lg bg-light navbar-light">
                    <button class="border-0 navbar-toggler px-0" type="button" data-toggle="collapse"
                        data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>
                </nav>
            @endif
            <div class="bg-light container-fluid position-absolute">
                <section id="desktop" class="wrapper min-vh-100">
                    @if(Session::has('user'))
                        <nav id="navbarTogglerDemo01"
                            class="row no-gutters navbar navbar-light d-lg-block collapse navbar-collapse navbar-expand-lg sidebar bg-white border-right min-vh-100 pt-3">
                            <button
                                class="bg-white d-lg-none d-flex justify-content-end mb-2 mx-2 navbar-toggler position-absolute shadow-sm"
                                style="top: 15px; right: -30px" type="button" data-toggle="collapse"
                                data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="col sidebar-sticky container">
                                <ul class="nav">
                                    <div class="mb-3">
                                        <label id="heading"
                                            class="nav-link text-secondary">{{ __('Dashboard') }}</label>
                                        <li class="nav-item">
                                            <a class="nav-link rounded-pill @if(Route::is('dashboard')) active @else @endif" href="{{route('dashboard')}}">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-house-door-fill" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6.5 10.995V14.5a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5v-7a.5.5 0 0 1 .146-.354l6-6a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 .146.354v7a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5V11c0-.25-.25-.5-.5-.5H7c-.25 0-.5.25-.5.495z" />
                                                    <path fill-rule="evenodd"
                                                        d="M13 2.5V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                                                </svg> {{__('Dashboard')}}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link rounded-pill @if(Route::is('arduino') || Route::is('arduino.read')) active @endif"
                                                href="{{ route('arduino') }}">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-terminal-fill" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M0 3a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3zm9.5 5.5h-3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm-6.354-.354L4.793 6.5 3.146 4.854a.5.5 0 1 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708z" />
                                                </svg> {{ __('Perangkat') }}
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('control') }}"
                                                class="nav-link rounded-pill @if(Route::is('control')) active @endif">
                                                <svg fill="currentColor" height="1.5em" viewBox="0 0 512 512" width="1.5em" xmlns="http://www.w3.org/2000/svg"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm121.75 388.414062c-4.160156 4.160157-9.621094 6.253907-15.082031 6.253907-5.460938 0-10.925781-2.09375-15.082031-6.253907l-106.667969-106.664062c-4.011719-3.988281-6.25-9.410156-6.25-15.082031v-138.667969c0-11.796875 9.554687-21.332031 21.332031-21.332031s21.332031 9.535156 21.332031 21.332031v129.835938l100.417969 100.414062c8.339844 8.34375 8.339844 21.824219 0 30.164062zm0 0"/></svg>
                                                {{ __('Riwayat') }}</a>
                                        </li>
                                    </div>
                                    <div class="mb-3">
                                        <label id="heading"
                                            class="nav-link text-secondary">{{ __('Lainnya') }}</label>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link rounded-pill" href="#">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-question-circle-fill" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.57 6.033H5.25C5.22 4.147 6.68 3.5 8.006 3.5c1.397 0 2.673.73 2.673 2.24 0 1.08-.635 1.594-1.244 2.057-.737.559-1.01.768-1.01 1.486v.355H7.117l-.007-.463c-.038-.927.495-1.498 1.168-1.987.59-.444.965-.736.965-1.371 0-.825-.628-1.168-1.314-1.168-.901 0-1.358.603-1.358 1.384zm1.251 6.443c-.584 0-1.009-.394-1.009-.927 0-.552.425-.94 1.01-.94.609 0 1.028.388 1.028.94 0 .533-.42.927-1.029.927z" />
                                                </svg> Bantuan
                                            </a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a class="nav-link rounded-pill @if(Route::is('profile')) active @endif"
                                                href="{{ route('profile') }}">
                                                <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                                                    class="bi bi-person-square" fill="currentColor"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                                </svg> {{ __('Profil') }}
                                            </a>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                            <div class="bg-light border-top mx-n3 p-3 position-absolute row sidebar-footer w-100">
                                <a class="btn p-0 btn-block d-flex text-dark"
                                    href="{{ route('logout') }}">
                                    <div class="mr-2">
                                        <i class="fas fa-power-off"></i>
                                    </div>
                                    <div>
                                        <span class="font-weight-bold">{{__('Keluar')}}</span>
                                    </div>
                                </a>
                            </div>
                        </nav>
                        <div class="d-block row no-gutters bg-light parent-content py-3 px-md-5 px-3">
                            @yield('content')
                        </div>
                    @else
                        @yield('content')
                    @endif
            </div>
        </div>
    </main>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js"></script>

    @if(Session::has('user'))
        <script src="https://unpkg.com/bootstrap-table@1.18.0/dist/bootstrap-table.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.18.0/dist/extensions/export/bootstrap-table-export.min.js">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.8/xlsx.core.min.js"></script>
        <script
            src="https://unpkg.com/bootstrap-table@1.18.0/dist/extensions/auto-refresh/bootstrap-table-auto-refresh.min.js">
        </script>
        <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
        <script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
        <script src="https://unpkg.com/bootstrap-table@1.18.1/dist/extensions/mobile/bootstrap-table-mobile.min.js">
        </script>
        <script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF/jspdf.min.js"></script>
        <script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
        </script>
        <script
            src="https://unpkg.com/bootstrap-table@1.18.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js">
        </script>
        <script src="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table-locale-all.min.js"></script>
        {{-- Clipboard JS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
        <script src="{{ asset('js/room.js') }}"></script>
        {{-- Weather --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/weather/0.0.2/weather.js"></script>
        <script src="{{asset('js/moment.js')}}"></script>
    @endif
    @stack('scripts')
    <script type="module" src="{{ asset('js/main.js') }}"></script>
</body>

</html>
