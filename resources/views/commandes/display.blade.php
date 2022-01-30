@extends('layouts.master')



@section('content')
<?php $total_produit = 0;$total= 0;?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-offset-2">
                <div class="card mt-3 tab-card">
                    <div class="card-header tab-card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">Commande reçue !</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <div class="row">

                                <div class="col-4">
                                    <h5 class="card-title">comande N : {{$commande->code_tracking}}</h5>
                                    <p class="card-text">
                                        <i class="fa fa-user" style="color:green"></i>
                                        <i class="fa fa-volume-up" style="color:green"></i>
                                        prix de livrasion : {{$commande->getWilayaLivreurTarif($commande->wilaya)}} DA
                                    </p>

                                    <p class="card-text">
                                        <i class="fa fa-fa-motorcycle" style="color:green"></i>  {{$commande->nom_client ?? ''}}<br>
                                        <i class="fa fa-phone"></i> <a href="tel:{{$commande->telephone}}">{{$commande->telephone ?? 'non définie'}}</a><br>
                                    </p>
                                    <p class="card-text">
                                        <i class="fa fa-fa-motorcycle" style="color:green"></i>  {{$commande->note ?? ''}}<br>
                                    </p>
                                    <p class="card-text">
                                        à livrée le : 
                                        {{ Carbon\Carbon::parse($commande->date_livraison)->format('Y-m-d') }}
                                    </p>
                                    <p class="card-text">
                                        {{App\Commande::getWilaya($commande->wilaya) ?? 'non définie'}} 
                                    </p>
                                    <p class="card-text">
                                        adress : {{$commande->adress ?? 'non définie'}}
                                    </p>
                                    <p class="card-text">
                                        Etat actuelle  :<span class="badge badge-info">
                                        {!! str_replace('_', ' ', $commande->state) !!}
                                        </span> 
                                    </p>
                                </div>
                                <div class="col-8">
                                    <p class="card-text">
                                        Liste des Produit :
                                    </p>

                                    <table class="table">
                                        <tbody>
                                        <?php
                                            $produits = json_decode($commande->produit);
                                            foreach($produits as $produit){
                                                $produit = json_decode(json_encode($produit), true);
                                            ?>                                         
                                        <tr>
                                            <td><i class="fa fa-box"></i> {{$produit['nom'] ?? 'non définie'}}</td>
                                            <td><i class="fa fa-money"></i>quantité :   {{$produit['quantite'] ?? 'non définie'}}</td>
                                            <td class="text-right"><i class="fa fa-money"></i>
                                            <?php $total_produit = 1*$produit['prix_vente'];
                                            $total = $total + $total_produit;
                                            ?>
                                            prix total:{{$produit['prix_vente'] }}</td>
                                        </tr>
                                        <?php  } ?>
                                        <tr>
                                            <td></td>
                                            <td>livraison</td>
                                            <td class="text-right">
                                            prix de livrasion : {{$commande->getWilayaLivreurTarif($commande->wilaya)}} DA
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right">
                                                prix total: <strong style="color:green;">{{$total + $commande->prix_livraison + $commande->getWilayaLivreurTarif($commande->wilaya)}}</strong>
                                                DA</td>
                                        </tr>

                                        </tbody>
                                    </table>


                                </div>
                            </div>


                            <br>
                            @auth('livreur')
                                @if($commande->livreur_id == Auth::guard('livreur')->user()['id'] )
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                        Reporter
                                    </button>
                                    <a href="{{route('commande.set.state',['state'=>'annule','commande'=>$commande->id])}}" class="btn btn-info" >
                                        Annuler
                                    </a>
                                    <a href="{{
                                        route('commande.set.state',['state'=>'ne_reponds_pas','commande'=>$commande->id])
                                    }}" class="btn btn-info" >
                                            Ne Réponds Pas
                                    </a>
                                    <a href="{{route('commande.non.abouti',['commande'=>$commande->id])}}" class="btn btn-info">Non Abouti</a>
                                    <a href="{{route('commande.set.state',['state'=>'Livree','commande'=>$commande->id])}}" class="btn btn-info" >
                                        Livree
                                    </a>
                                @else
                                    <a href="{{route('commande.accepter',['id_comamnde'=>$commande->id])}}" class="btn btn-success">Accepter</a>
                                    <a href="{{route('livreur.index')}}" class="btn btn-info">Rejeter</a>

                                @endif

                            @else
                                <!-- <a href="{{route('commande.download.single',['id_comamnde'=>$commande->id,'type'=>'a4'])}}" class="btn btn-success">
                                    <i class="fa fa-download"></i> A4
                                </a> -->
                                <a href="{{route('commande.download.single',['id_comamnde'=>$commande->id,'type'=>'ticket'])}}" class="btn btn-success">
                                    <i class="fa fa-download"></i> Ticket
                                </a>

                                <a href="{{route('commande.set.state',['state'=>'annule','commande'=>$commande->id])}}" class="btn btn-danger">
                                    <i class="fa fa-trash"></i> Annuler
                                </a>
                                <a href="{{route('commande.set.state',['state'=>'confirmer','commande'=>$commande->id])}}" class="btn btn-info" >
                                    <i class="fa fa-check"></i> Confirmer
                                </a>
                                <a href="{{route('commande.set.state',['state'=>'ne_repond_pas','commande'=>$commande->id])}}" class="btn btn-primary" >
                                    <i class="fa fa-check"></i> ne reponde pas
                                </a>
                                <a href="{{route('commande.non.abouti',['commande'=>$commande->id])}}" class="btn btn-danger">Non Abouti</a>



                            @endif
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Changer la date :</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form_type" action=" {{route('commande.update.date')}}" method="post">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="hidden" value="{{$commande->id}}" name="commande" id="commande_id"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputFirstName">Nouvelle Date : </label>
                                                            <input type="date" value="" name="date_livraison" id="" class="form-control"/>
                                                        </div>
                                                    </div>
                                                   <br>
                                                </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" type="submit" >enregistrer</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection


@section('scripts')
    <script>
        $('#print').on("click", function () {
            console.log('sa')
            $('#commande').printThis({
                base: "https://jasonday.github.io/printThis/"
            });
        });


    </script>


@endsection