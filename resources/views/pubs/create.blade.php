@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mt-2">
                                    <div class="card-header"><h3 class="font-weight-light my-4">nouveau produit :  </h3></div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('produit.store')}}" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">nom de produit: </label>
                                                        <input type="text" value="{{ old('nom') }}" name="nom"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1">catégorie de produit :</label>
                                                        <select class="form-control" name="categorie" id="categories">
                                                                <option value="general" selected>
                                                                    général
                                                                </option>                    
                                                        </select>
                                                    <a style="cursor:pointer;" data-toggle="modal" data-target="#exampleModal">
                                                    ajouter catégorie
                                                    </a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1">choisir fournisseur :</label>
                                                        <select class="form-control" name="fournisseur" id="fournisseurs">
                                                        @foreach($fournisseurs as $fournisseur)
                                                                <option value="{{$fournisseur}}" selected>
                                                                    {{$fournisseur->nom_prenom ?? ''}}
                                                                </option>                    
                                                        @endforeach
                                                        </select>
                                                    <a href="{{route('fournisseur.show.create')}}"   >
                                                    ajouter fournisseur
                                                    </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                            <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" >quantite initiale :</label>
                                                        <input  class="form-control py-4" value="{{ old('quantite') }}" name="quantite" id="" type="number" placeholder="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">prix initiale : </label>
                                                        <input  class="form-control py-4" value="{{ old('prix_vente') }}" name="prix_vente" id="email" type="text" placeholder="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">prix d'achet ( fournisseur )  : </label>
                                                        <input  class="form-control py-4" value="{{ old('prix_fournisseur') }}" name="prix_fournisseur" type="text" placeholder="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">prix livraison : </label>
                                                        <input  class="form-control py-4" value="{{ old('prix_livraison') }}" name="prix_livraison" type="text" 
                                                        placeholder="" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">description de produit </label>
                                                        <textarea name="description" class="form-control"></textarea>  
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small mb-1" for="inputEmailAddress">image: </label>
                                                    <input  class="form-control-file" name="image[]" multiple type="file" placeholder="telephone" />
                                                </div>

                                            </div>

                                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">ajouter </button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputConfirmPassword">description de produit </label>
                                    <input  class="form-control py-4" value="{{ old('new_categorie') }}" name="new_categorie" type="text" 
                                                        id='new_categorie'
                                                        placeholder="ajouter nouvelle catégorie .. " />
                                    
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="add_new_categorie">ajouter dans la liste</button>
                        </div>
                        </div>
                    </div>
                    </div>



@endsection


@section('scripts')
<script>
$(document).ready(function() { 
  $('#add_new_categorie').click(function() {
      var v = $('#new_categorie').val()
        if(v.length>0){
            $('#categories').append(new Option(v, v));
            $("#categories").val(v);

        }
        $('#exampleModal').modal('toggle');

  });
});


</script>

@endsection
