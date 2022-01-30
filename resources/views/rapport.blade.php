@extends('layouts.admin')
@section('content')
                    <div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord</h1>
                      <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total commandes</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Livreur</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-truck fa-2x text-gray-300"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total des produits</div>
                                  <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">3</div>
                                    </div>
                                    <div class="col">
                                      <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                          <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Commerciaux</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">10</div>
                                </div>
                                <div class="col-auto">
                                  <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                <div class="col-lg-6 mb-4">
                  <div class="card bg-primary text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-list"></i>
                        &nbsp;
                        <a class="small text-white stretched-link" href="#">Mes Produits &nbsp;</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-success text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-file-invoice-dollar"></i>
                        &nbsp;
                        <a class="small text-white stretched-link" href="{{route('commande.index')}}">Mes Commandes  &nbsp;</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-info text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-plus"></i>
                        &nbsp;
                        <a class="small text-white stretched-link" href="{{route('livreur.show.create')}}">Ajouter Livreur &nbsp;</a>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 mb-4">
                  <div class="card bg-warning text-white shadow">
                    <div class="card-body">
                        <i class="fas fa-plus"></i>
                        &nbsp;
                        <a class="small text-white stretched-link" href="{{route('user.show.create')}}">Ajouter Commercial &nbsp;</a>
                    </div>
                  </div>
                </div>
            </div>



@endsection





