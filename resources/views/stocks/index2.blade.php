@extends('layouts.master')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4">Gestion produits</h1>

                             <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-primary" href="{{route('produit.create')}}">
                                <i class="fa fa-plus"></i> Ajouter produit</a>

                            </div>

                                                    <div class="col-md-3">
                                                        <label> Filtrer par client :    </label>
                                                        <select class='form-control clients' name='produit' id="produit" >
                                                                    <option value="all_clients" >
                                                                        tous les clients
                                                                    </option>                    

                                                            @foreach($fournisseurs as $fournisseur)
                                                                    <option value="{{$fournisseur->id}}" >
                                                                    {{$fournisseur->nom_prenom}} {{$fournisseur->prenom}}
                                                                    </option>                    
                                                            @endforeach

                                                        </select>
                                                    </div>


                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>
                                            <tr>
                                                <th>ID produit</th>
                                                <th>Nom produit </th>
                                                <th>Fournisseur</th>
                                                <th>qunatité-stock</th>
                                                <th>actions</th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($produits as $produit)                                            

                                            <tr
                                            class="
                                                client
                                                client-{{$produit->fournisseur_id}}                                             
                                            "
                                            >

                                                <td>{{$produit->id ?? ''}}</td>

                                                <td> <i class=" fas fa-box	"></i> {{$produit->nom ?? ''}}
                                                <br>
                                                <?php 
                                                $image = json_decode($produit->image);
                                                ?>
                                                <img src="{{asset('storage/app/public/'.$produit->image)}}" width="60px"/>

                                                </td>

                                                <?php
                                                    $fournisseur = json_decode($produit->fournisseur); 
                                                ?>
                                                <td>{{$fournisseur->nom_prenom ?? ''}} </td>
                                                
                                                <td><span class="badge badge-info"> {{$produit->quantite ?? ''}} pieces </span></td>
                                                <td >

                                                    <div class="table-action">  
                                                        <a 
                                                            href="{{route('produit.stock',['id_produit'=>$produit->id])}}"
                                                            class="text-white btn btn-info">
                                                                Détail
                                                        </a>
                                                        <a 
                                                            href="{{route('produit.print.stock',['id_produit'=>$produit->id])}}"
                                                            class="btn btn-info">
                                                                <i class="fas fa-print"></i> Imprimer
                                                            </a>

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





@endsection

@section('scripts')
<script>

function onClient()
    {

        $('.clients').on('change', function (e) {
                var valueSelected = this.value;
                console.log(valueSelected)
                if (valueSelected=="all_clients") {
                    $('.client').show()
                    
                }else{
                    $('.client').hide()
                    $('.client-'+valueSelected).show()
                }                
        });

    }
$(document).ready(function () {
    onClient();
});


</script>
@endsection