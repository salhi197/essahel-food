<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>CliNtic </title>
  <!-- Custom fonts for this template -->
  <link href="{{asset('super/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    body{
      text-transform: capitalize;
    }
    .btn {
      text-transform: capitalize;
    }
    .modal .modal-dialog {
      width: 850px !important;
    }
    input[type="text"] {
      text-transform: initial;
    }
  </style>

  <!-- Custom styles for this template -->
  <link href="{{asset('super/css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/toastr.css')}}" rel="stylesheet" />


</head>

<body id="page-top" class="sidebar-toggled">
  <!-- Page Wrapper -->
  <div id="wrapper">
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CLINnTIC <sup>2</sup></div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="/home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span> Tableau de bord </span></a>
      </li>
      @auth('freelancer')

        <li class="nav-item active">
              <a class="nav-link" href="#">
              <i class="fas fa-dumpster"></i>
              <span>produit à vendre </span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">
            <i class="fas fa-address-card"></i>
            <span>Mon stock clicntic</span></a>
          </li> 
          <li class="nav-item active">
            <a class="nav-link" href="#">
            <i class="fas fa-address-card"></i>
            <span>freelancers </span></a>
          </li> 
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="#">
            <i class="fas fa-users"></i>
            <span>Mon payment</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">
            <i class="fas fa-motorcycle"></i>
            <span>Rapports</span></a>
          </li>      
          <li class="nav-item active">
            <a class="nav-link" target="_blank" href="https://www.clicntic-dz.com">
            <i class="fas fa-motorcycle"></i>
            <span>clicntic-dz.com</span></a>
          </li>      
          <li class="nav-item active">
            <a class="nav-link" target="_blank" href="facebook.com">
            <i class="fas fa-facebook-f"></i>
            <span>Rapports</span></a>
          </li>      
          <li class="nav-item active">
            <a class="nav-link" href="#" target="_blank">
            <i class="fas fa-motorcycle"></i>
            <span>Rapports</span></a>
          </li>      
          

          <li class="nav-item active">
            <a class="nav-link" href="#">
            <i class="fas fa-store"></i>
            <span>gestion de stock</span></a>
          </li>      
          <li class="nav-item active">
            <a class="nav-link" href="#">
            <i class="fas fa-envelope-open-text"></i> 
            <span>news Letter</span></a>
          </li>
      
      @endif
      @auth('livreur')
    <li class="nav-item active">
      <a class="nav-link" href="/admin">
          <i class="fas fa-list"></i>
          <span>tout les Commandes</span></a>
      </li>
      <li class="nav-item active">
      <a class="nav-link" href="{{route('livreur.livraisons')}}">
      <i class="fas fa-user "></i>
          <span>mes commandes </span></a>
      </li>
      @endif
     @auth('admin')
     <li class="nav-item active">
      <a class="nav-link" href="{{route('produit.index')}}">
      <i class="fas fa-cart-plus"></i>
                <span>Produit</span></a>
      </li>
      <li class="nav-item active">
          <a class="nav-link" href="{{route('commande.index')}}">
          <i class="fas fa-dumpster"></i>
          <span>Commandes</span></a>
      </li>
      <li class="nav-item active">
          <a class="nav-link" href="{{route('type.index')}}">
          <i class="fas fa-list"></i>
          <span>type livraison</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{route('fournisseur.index')}}">
        <i class="fas fa-address-card"></i>
        <span>Fournisseurs </span></a>
      </li> 

      <li class="nav-item active">
        <a class="nav-link" href="{{route('achat.index')}}">
        <i class="fas fa-address-card"></i>
        <span>renouvlemnt / payment</span></a>
      </li> 


      <li class="nav-item active">
        <a class="nav-link" href="{{route('freelancer.index')}}">
        <i class="fas fa-address-card"></i>
        <span>freelancers </span></a>
      </li> 
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="{{route('user.index')}}">
        <i class="fas fa-users"></i>
        <span>Liste des commeciaux</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{route('livreur.index')}}">
        <i class="fas fa-motorcycle"></i>
        <span>Liste des livreurs</span></a>
      </li>      
      <li class="nav-item active">
        <a class="nav-link" href="{{route('stock.index')}}">
        <i class="fas fa-store"></i>
        <span>gestion de stock</span></a>
      </li>      
      <li class="nav-item active">
        <a class="nav-link" href="{{route('newsletter.index')}}">
        <i class="fas fa-envelope-open-text"></i> 
        <span>news Letter</span></a>
      </li>
      <li class="nav-item active">
            <a class="nav-link" href="{{route('pub.index')}}">
            <i class="fas fa-broadcast-tower"></i>
            <span>Gestion publicitaire</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{route('boutique.index')}}">
        <i class="fas fa-cogs"></i>
        <span>Boutique</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="{{route('rapport')}}">
        <i class="fas fa-chart-bar"></i>
        <span>Rapports</span></a>
      </li>
      <hr class="sidebar-divider">

      <li class="nav-item active">
            <a class="nav-link" target="_blank" href="https://www.clicntic-dz.com">
            <i class="fas fa-motorcycle"></i>
            <span>clicntic-dz.com</span></a>
          </li>      
          <li class="nav-item active">
            <a class="nav-link" target="_blank" href="https://www.facebook.com">
              <i class="fab fa-facebook-square"></i>
              <span>page facebok</span></a>
          </li>      
          <li class="nav-item active">
            <a class="nav-link" href="https://www.clicntic-dz.com/contact" target="_blank">
            <i class="fas fa-file-signature"></i>
            <span>Contact</span></a>
          </li>      

      @endif
      <li class="nav-item active">
          <a class="nav-link" href="{{ route('logout') }}" 
            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
          <i class="fa fa-door-open"></i>
          <span>déconnexion</span> 
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider">
      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </ul>
    
    <!-- Sidebar -->
<!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <!-- Sidebar Toggle (Topbar) -->
          <form class="form-inline">
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
              <i class="fa fa-bars"></i>
              Tableau de bord
            </button>
          </form>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw">
                </i>
              </a>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              @auth('livreur')
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user('livreur')->name ?? '' }} {{Auth::user('livreur')->prenom ?? ''  }}</span>
              @endif
              @auth('boutique')
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user('livreur')->name ?? '' }} {{Auth::user('livreur')->prenom ?? ''  }}</span>
              @endif
              @auth('freelancer')
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">freelancer</span>
              @endif
              @auth('admin')
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user('guard:admin')->name ?? ''}}</span>
              @endif
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; <a href="clicntic.com/">clicntic.com</a> 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  @if(!Auth::guard('admin')->user())
  <div class="modal fade" id="ad-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Espace publicitaire</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <img width='300px' class="" src="{{asset('pub.jpg')}}">
          <img width='300px' class="" src="{{asset('pub.jpeg')}}">
          <img width='300px' class="" src="{{asset('pub.jpng')}}">
                </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
  @endif 

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>




                

                          <div class="modal fade" id="leModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">saisir le Motif:</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form_type" action=" {{route('commande.annuler')}}" method="post">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden" value="{{$commande->id ?? ''}}" name="commande" id="commande_id"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputFirstName">Motif d'annulation  : </label>
                                                            <textarea name="motif" class="form-control">

                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button class="btn btn-primary btn-block" type="submit" >envoyer</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>







                            <!-- Bootstrap core JavaScript-->
  <script src="{{asset('super/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('super/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('super/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('js/toastr.min.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('super/js/sb-admin-2.min.js')}}"></script>
  <script src="{{asset('js/dynamic-form.js')}}"></script>
  <script src="{{asset('js/printThis.js')}}"></script>
  <script>
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
// setInterval(function(){

//   $('#ad-modal').modal('show');
// }, 30000); //This value is represented in mili seconds.


</script>

        @yield('scripts')


</body>

</html>
