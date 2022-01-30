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
        <a class="nav-link" href="#">
        <i class="fas fa-motorcycle"></i>
        <span>Liste des livreurs</span></a>
      </li>      
      <li class="nav-item active">
        <a class="nav-link" href="{{route('produit.index')}}">
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
    