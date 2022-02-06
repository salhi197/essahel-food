@extends('layouts.master')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4">Gestion produits</h1>
                            <div class="card mb-4">
                            <div class="card-header">
                                <button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary center-block">
                                    Ajouter Produit
                                </button>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>
                                            <tr>
                                                <th>ID produit</th>
                                                <th>Nom produit </th>
                                                <th> prix_semi_gros </th>
                                                <th> prix_detail  </th>
                                                <th> prix_minimum  </th>
                                                <th> prix_autre  </th>

                                                <th>Prix</th>
                                                <th>actions</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach($produits as $produit)                                            

                                            <tr>

                                                <td>{{$produit->id ?? ''}}</td>
                                                <td>
                                                    {{$produit->nom ?? ''}}
                                                </td>
                                                <td>{{$produit->prix_gros ?? ''}} </td>
                                                <td>{{$produit->prix_semi_gros?? ''}} </td>
                                                <td>{{$produit->prix_detail ?? ''}} </td>
                                                <td>{{$produit->prix_minimum ?? ''}} </td>
                                                <td>{{$produit->prix_autre ?? ''}} </td>

                                                <td >

                                                    <div class="table-action">  

                                                        <a  
                                                        href="{{route('produit.destroy',['id_produit'=>$produit->id])}}"
                                                        onclick="return confirm('etes vous sure  ?')"
                                                        class="text-white btn btn-danger btn-sm">
                                                                <i class="fas fa-trash"></i> 
                                                        </a>
                                                        <button data-toggle="modal" data-target="#squarespaceModal{{$produit->id}}" class="btn btn-primary btn-sm center-block">
                                                            Modifer
                                                        </button>       
                                                        @include('includes.edit_produit',['produit'=>$produit])                                                 
                                                    </div>

                                                </td>



                                            </tr>

           

                                            @endforeach





                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>




<div class="modal fade " id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Ajouter Produit : </h3>
            </div>
            <div class="modal-body">
                <form action="{{route('produit.create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nom Produit</label>
                        <input type="text" value="{{ old('nom') }}" name="nom" class="form-control"
                            id="exampleInputEmail1" placeholder=" ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Catégorie</label>
                        <select class="form-control">
                            @foreach($categories as $categorie)
                                <option value="{{$categorie->nom}}"
                                        @if($categorie->id == $produit->id) selected @endif>
                                    {{$categorie->nom ?? ''}}
                                </option>
                            @endforeach

                        </select>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Catégorie : </label>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Réference : </label>
                        <input type="text" value="{{ old('reference') }}" name="reference" class="form-control"
                            placeholder="  ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Description : </label>
                        <input type="text" class="form-control" value="{{ old('description') }}" name="description" id="nom"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">prix gros  : </label>
                        <input type="text" class="form-control" value="{{ old('prix_gros') }}" name="prix_gros" id="prix_gros"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">prix Semi Gros :</label>
                        <input type="text" value="{{ old('prix_semi_gros') }}" name="prix_semi_gros" class="form-control" id=""
                            placeholder=" ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Prix Détail : </label>
                        <input type="text" value="{{ old('prix_detail') }}" name="prix_detail" class="form-control" id="prix_detail"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Prix Minimum : </label>
                        <input type="text" value="{{ old('prix_minimum') }}" name="prix_minimum" class="form-control" id="prix_minimum"
                            placeholder="">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputEmail1">Prix Autre : </label>
                        <input type="text" value="{{ old('prix_autre') }}" name="prix_autre" class="form-control" id="prix_autre"
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



@endsection

