<!DOCTYPE html>
<html lang="en">
<?php
use App\Livreur;
$_livreurs = Livreur::all();
?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png')}}">
    <title>
        Essahel Food
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ asset('ui/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('ui/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('ui/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->

    <link id="pagestyle" href="{{ asset('ui/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />     
</head>

<body class="g-sidenav-show  bg-gray-100">
    
    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
        
        <div class="sidenav-header">
            
            <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"aria-hidden="true" id="iconSidenav">
                
            </i>
            
            <a class="navbar-brand m-0" href=""
            target="_blank">
            
                <img src="{{ asset('ui/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold">
                    
                @auth("production")
                    Accés Agent Production
                @endauth
                @auth("admin")
                    Accés Admin
                @endauth
                @auth("depot")
                    Accés Agent Depot
                @endauth

                </span>
            </a>
        </div>
        <hr class="horizontal dark mt-0">
        <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
            <ul class="navbar-nav">
                @auth("production")
                    @include('includes.production')
                @endauth
                @auth("admin")
                    @include('includes.admin')
                @endauth
                @auth("depot")
                    @include('includes.depot')
                @endauth


                <li class="nav-item">
                    <a class="nav-link {{ Request::is('déconexion') == 1 ? 'active' : '' }}"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                            <svg width="12px" height="12px" viewBox="0 0 40 40" version="1.1"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>settings</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-2020.000000, -442.000000)" fill="#FFFFFF"
                                        fill-rule="nonzero">
                                        <g transform="translate(1716.000000, 291.000000)">
                                            <g transform="translate(304.000000, 151.000000)">
                                                <polygon class="color-background opacity-6"
                                                    points="18.0883333 15.7316667 11.1783333 8.82166667 13.3333333 6.66666667 6.66666667 0 0 6.66666667 6.66666667 13.3333333 8.82166667 11.1783333 15.315 17.6716667">
                                                </polygon>
                                                <path class="color-background opacity-6"
                                                    d="M31.5666667,23.2333333 C31.0516667,23.2933333 30.53,23.3333333 30,23.3333333 C29.4916667,23.3333333 28.9866667,23.3033333 28.48,23.245 L22.4116667,30.7433333 L29.9416667,38.2733333 C32.2433333,40.575 35.9733333,40.575 38.275,38.2733333 L38.275,38.2733333 C40.5766667,35.9716667 40.5766667,32.2416667 38.275,29.94 L31.5666667,23.2333333 Z">
                                                </path>
                                                <path class="color-background"
                                                    d="M33.785,11.285 L28.715,6.215 L34.0616667,0.868333333 C32.82,0.315 31.4483333,0 30,0 C24.4766667,0 20,4.47666667 20,10 C20,10.99 20.1483333,11.9433333 20.4166667,12.8466667 L2.435,27.3966667 C0.95,28.7083333 0.0633333333,30.595 0.00333333333,32.5733333 C-0.0583333333,34.5533333 0.71,36.4916667 2.11,37.89 C3.47,39.2516667 5.27833333,40 7.20166667,40 C9.26666667,40 11.2366667,39.1133333 12.6033333,37.565 L27.1533333,19.5833333 C28.0566667,19.8516667 29.01,20 30,20 C35.5233333,20 40,15.5233333 40,10 C40,8.55166667 39.685,7.18 39.1316667,5.93666667 L33.785,11.285 Z">
                                                </path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <span class="nav-link-text ms-1">Déconnexion</span>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </a>
                </li>



            </ul>
        </div>
    </aside>
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        
        <!-- Navbar -->
        <nav class="navbar navbar-expand-md navbar-light bg-light" id="navbarBlur">
            
            <div class="container-fluid py-1 px-3">

                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                </div>
            </div>
        </nav>
        @yield('content')




        <div class="modal fade" id="livreurModal" tabindex="-1" role="dialog" aria-labelledby="livreurModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="livreurModalLabel">Séléctionner Livreur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Livreur: </label>
                            <select class="form-control affiche_livreurs js-example-basic-single" size="5"
                                name="livreur">
                                <option value="">{{ __('Séléctionner ...') }}</option>
                                @foreach ($_livreurs as $livreur)
                                    <option value="{{ $livreur->id }}">
                                        {{ $livreur->name ?? '' }} {{ $livreur->prenom ?? '' }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>





    </main>
    <script src="{{ asset('ui/js/jquery.min.js') }}"></script>

    <script src="{{ asset('ui/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('ui/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('ui/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('ui/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('ui/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
        
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/datatables-demo.js') }}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>

    <script src="{{ asset('ui/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{asset('js/sweetalert.min.js')}}"></script>
    <script src="{{ asset('js/printThis.js') }}"></script>

    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                'width': '100%'
            });
        });
        @if (session('success'))
            $(function(){
            toastr.success('{{ Session::get('success') }}')
            })
        @endif
        @if ($errors->any())
            $(function(){
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
            })
        @endif
        @if (session('error'))
            $(function(){
            toastr.error('{{ Session::get('error') }}')
            })
        @endif

        $('.affiche_livreurs').on('change', function(e) {
            console.log('test');
            var optionSelected = $("option:selected", this);
            var valueSelected = this.value;
            var lien = "/livreur/filter/" + valueSelected;
            $('#filter_livreur').attr('href', lien)
            window.location = lien
        });
    </script>

    @yield('scripts')

</body>

</html>
