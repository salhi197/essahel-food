
<?php
use App\Livreur;
$_livreurs = Livreur::all();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title>Ls-Rapide</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('img/lsrapide.jpg')}}" type="image/png">
  <!-- Fonts -->
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Icons -->
  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
  <link href="{{asset('css/toastr.css')}}" rel="stylesheet" />
    @yield('styles')
  <style>
    html,body{
        text-transform: capitalize;
    }
    .modal-ku {
        width: 750px;
        margin: auto;
    }
    .odd{
        font-size: 120%;
    }


  </style>
</head>

<body>
  <!-- Sidenav -->
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white hidden-xs" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  align-items-center">
        <a class="navbar-brand" href="javascript:void(0)">
          <img src="{{asset('img/lsrapide.jpg')}}" alt="...">
          <h3>

                </h3>

        </a>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            @auth('admin')

            <li class="nav-item">
              <a class="nav-link active" href="{{route('impression')}}">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">
                <strong>
                    Impression des Tickets</span>
                </strong>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{route('rapport')}}">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">
                <strong>
                    Rapport</span>
                </strong>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link button" data-toggle="modal" data-target="#livreurModal">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">
                <strong>
                    Affiche Livreur
                  </strong>
                </span>
              <strong>
                </strong>
              </a>
            </li>




            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-pin-3 text-primary"></i>
                <span class="nav-link-text">
                <strong>
                    Utilisateur</span>
                </strong>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('livreur.index')}}">Livreur</a>
                    <a class="dropdown-item" href="{{route('production.index')}}">Agents Production</a>
                    <a class="dropdown-item" href="{{route('admin.index')}}">Personnel</a>

                </div>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{route('produit.index')}}">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text"><strong>Produit</span></strong>
              </a>
            </li>

              <li class="nav-item">
                  <a class="nav-link active" href="{{route('categorie.index')}}">
                      <i class="ni ni-tv-2 text-primary"></i>
                      <span class="nav-link-text"><strong>Categorie</span></strong>
                  </a>
              </li>
        @endif
      @auth('fournisseur')
          <?php
                $fournisseur = Auth::guard('fournisseur')->user();
            ?>
            <li class="nav-item">
              <a class="nav-link active" href="/home">
                <i class="ni ni-tv-2 text-primary"></i>
                <span class="nav-link-text">
                <strong>
                    Mes Colis   </span>
                </strong>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route('produit.index')}}">
                <i class="ni ni-single-02 text-yellow"></i>
                <span class="nav-link-text">
                <strong>
                    Produits</span>
                </strong>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{route('fournisseur.journal',['fournisseur'=>$fournisseur->id])}}">
                <i class="ni ni-circle-08 text-pink"></i>
                <span class="nav-link-text">
                <strong>
                    Mon Journal</span>
                </strong>
              </a>
            </li>


            <li class="nav-item">
              <a class="nav-link" href="{{route('fournisseur.stock')}}">
                <i class="ni ni-circle-08 text-pink"></i>
                <span class="nav-link-text">
                <strong>
                    Stock</span>
                </strong>
              </a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="{{route('wilaya.fournisseurs')}}">
                <i class="ni ni-key-25 text-info"></i>
                <span class="nav-link-text">
                <strong>
                    T.Fournisseur</span>
                </strong>
              </a>
            </li>

      @endif


      <li class="nav-item active">
          <a class="nav-link" href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fa fa-door-open"></i>
          <strong>
            <span>déconnexion</span>
          </strong>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>

          </ul>
          <!-- Divider -->
          <hr class="my-3">
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Search form -->
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item dropdown">
                <h3>

                </h3>
                <h4 class="text-white">Accès
                @auth('fournisseur')
                    Fournisseur
                @endif
                @auth('admin')
                    Admin
                @endif

                @auth('livreur')
                    Livreur
                @endif

                 !</h4>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <!-- Page content -->
    <div class="container-fluid mt--6">
        @yield('content')
      <!-- Footer -->
    </div>
  </div>

  <div class="modal fade" id="livreurModal" tabindex="-1" role="dialog" aria-labelledby="livreurModalLabel" aria-hidden="true">
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
                    <select class="form-control affiche_livreurs js-example-basic-single" size="5"  name="livreur">
                        <option value="">{{ __('Séléctionner ...') }}</option>
                        @foreach ($_livreurs as $livreur)
                            <option value="{{$livreur->id}}" >
                            {{$livreur->name ?? ''}} {{$livreur->prenom ?? ''}}
                            </option>

                        @endforeach

                    </select>
            </div>
            <a href="#" id="filter_livreur" class="btn btn-primary">Filtrer</a>
      </div>
    </div>
  </div>
</div>






  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
  <!-- Optional JS -->
  <script src="{{asset('js/toastr.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  <!-- Argon JS -->
  <script src="{{asset('assets/js/argon.js?v=1.2.0')}}"></script>
  <script src="{{asset('js/dynamic-form.js')}}"></script>

  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="{{asset('js/datatables-demo.js')}}"></script>

  <script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
  @if(session('success'))
      $(function(){
          toastr.success('{{Session::get("success")}}')
      })
  @endif
  @if ($errors->any())
      $(function(){
        @foreach ($errors->all() as $error)
                  toastr.error('{{$error}}')
        @endforeach
      })
  @endif
  @if(session('error'))
    $(function(){
        toastr.error('{{Session::get("error")}}')
    })
  @endif

$('.affiche_livreurs').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    var lien = "/livreur/filter/"+valueSelected;
    $('#filter_livreur').attr('href',lien)
});

// setInterval(function(){

//   $('#ad-modal').modal('show');
// }, 30000); //This value is represented in mili seconds.


</script>

  @yield('scripts')
</body>

</html>
