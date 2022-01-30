@extends('layouts.admin')

@section('content')
<div class="container-fluid">
<div class="row">
            <!-- Content Column -->
            <div class="col-lg-6 mb-4">
              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Voir produit</h6>
                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" 
                    src="{{($produit->image ?? '') ? asset('storage/'.$produit->image) : "#" }}"
                        >
                  </div>

                  <p>
                   {{$produit->description ?? ''}}    
                </p>

                  <p>{{$produit->nom ?? ''}}</p>
                  <p> qunatité :{{$produit->qunatité ?? ''}}</p>
                  <p> catégorie :{{$produit->catégorie ?? ''}}</p>
                  <p> prix_vente :{{$produit->prix_vente ?? ''}}</p>
                  <p> prix_fournisseur :{{$produit->prix_fournisseur ?? ''}}</p>
                  <p> fournisseur :{{$produit->fournisseur ?? ''}}</p>
                  
                  <a target="_blank" rel="nofollow" href="{{ URL::previous() }}">retour -></a>
                </div>
              </div>
              <!-- Approach -->
            </div>
          </div>
</div>
@endsection
