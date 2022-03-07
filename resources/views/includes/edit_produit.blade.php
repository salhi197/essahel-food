<div class="modal fade " id="squarespaceModal{{$produit->id}}" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Ajouter Produit : </h3>
            </div>
            <div class="modal-body">
                <form action="{{route('produit.update',['produit'=>$produit->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nom Produit</label>
                        <input type="text" value="{{ $produit->nom ?? '' }}" name="nom" class="form-control"
                            id="exampleInputEmail1" placeholder=" ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nom Produit</label>
                        <select class="form-control">
                            @foreach($categories as $categorie)
                                <option value="{{$categorie->nom}}"
                                @if($categorie->id == $produit->id) selected @endif
                                >
                                    {{$categorie->nom ?? ''}}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Catégorie</label>
                        <select class="form-control" name="id_categorie">
                            @foreach($categories as $categorie)
                                <option value="{{$categorie->nom}}"
                                        @if($categorie->id == $produit->id) selected @endif>
                                    {{$categorie->nom ?? ''}}
                                </option>
                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Réference : </label>
                        <input type="text" value="{{ $produit->reference ?? '' }}" name="reference" class="form-control"
                            placeholder="  ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description : </label>
                        <input type="text" class="form-control" value="{{ $produit->description ?? '' }}" name="description" id="nom"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">prix gros  : </label>
                        <input type="text" class="form-control" value="{{ $produit->prix_gros ?? '' }}" name="prix_gros" id="prix_gros"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">prix Semi Gros :</label>
                        <input type="text" value="{{ $produit->prix_semi_gros ?? '' }}" name="prix_semi_gros" class="form-control" id=""
                            placeholder=" ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Prix Détail : </label>
                        <input type="text" value="{{ $produit->prix_detail ?? '' }}" name="prix_detail" class="form-control" id="prix_detail"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Prix Minimum : </label>
                        <input type="text" value="{{ $produit->prix_minimum ?? '' }}" name="prix_minimum" class="form-control" id="prix_minimum"
                            placeholder="">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Prix Autre : </label>
                        <input type="text" value="{{ $produit->prix_autre ?? '' }}" name="prix_autre" class="form-control" id="prix_autre"
                            placeholder="">
                    </div>


                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Fermer</button>
                </form>
            </div>
        </div>
    </div>
</div>