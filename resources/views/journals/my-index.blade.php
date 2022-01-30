@extends('layouts.master')



@section('content')

<div class="container-fluid">

                    <h1 class="mt-4">Esapce Livreur</h1>

                       <div class="card mb-4">

                            <div class="card-header">

                                List de tout les commande disponible , clikcer sur "prendre" pour délivrer

                            </div>

                           <div class="card-body">

                                <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                              <th>id</th>
                                              <th>client</th>

                                                <th>livreur</th>
                                                <th>produit</th>
                                                <th>crédit livreur </th>                                                
                                                <th>retour au dépot </th>
                                                <th>timelines</th>
                                                <th>actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($commandes as $commande)                                            

                                            <tr>
                                                <td>
                                                    {{$commande->id ?? ''}}
                                                    <?php  if($commande->command_express == "express"){echo '<i class="fa fa-star style="color:yellow;"></i>'.$commande->command_express.'<br>';}else{echo $commande->command_express;}?>

                                                    @if($commande->state == "annule")
                                                    <p>
                                                    <i class="fas fa-frown" style="font-size:40px;color:red;"></i><br> Annulé :  {{$commande->motif ?? '--/--/--' }}<br>
                                                    </p>
                                                    @endif


                                                @if($commande->state == 'en attente')
                                                <br> <i class="fa fa-volume-up" style="font-size:40px;color:green"></i> {{$commande->state ?? ''}} <br>
                                                @endif
                                                @if($commande->state == 'accepte')
                                                <br> <i class="fa fa-walking" style="font-size:40px;color:red"></i> {{$commande->state ?? ''}} <br>
                                                @endif
                                                @if($commande->state == 'expedier')
                                                <br> <i class="fa fa-fa-motorcycle" style="font-size:40px;color:green"></i> {{$commande->state ?? ''}} <br>
                                                @endif
                                                @if($commande->state == 'en attente paiement')
                                                <br> <i class="fa fa-hourglass-start" style="font-size:40px;color:blue"></i> {{$commande->state ?? ''}}<br> <i class="fa fa-money-bill-alt" style="font-size:40px;color:green"></i> {{$commande->state ?? ''}}
                                                @endif
                                                @if($commande->state == 'livree')
                                                <i class="fa fa-thumbs-up" style="font-size:40px;color:green"></i> {{$commande->state ?? ''}} <br>
                                                @endif


                                                    
                                                </td>
                                                <td width="10%">                                                 
                                                    <i class="fa fa-user"></i>: {{$commande->nom_client ?? 'non définie'}}<br>
                                                    <i class="fa fa-phone"></i>: {{$commande->telephone ?? 'non définie'}}<br>
                                                    {{$commande->wilaya ?? 'non définie'}}<br>
                                                    {{$commande->commune ?? 'non définie'}}<br>

                                                 </td>

                                                 <td width="20%">                                                 
                                                <?php
                                                    $livreur = json_decode($commande->livreur); 
                                                ?>

                                                <?php  if(isset($livreur->name)){echo '<i class="fa fa-user"></i>'.$livreur->name.'<br>';}else{echo '<i class="fa fa-user"></i> ';}?>
                                                <?php  if(isset($livreur->prenom)){echo $livreur->prenom.'<br>';}?>
                                                <?php  if(isset($livreur->telephone)){echo '<i class="fa fa-phone"></i> '.$livreur->telephone.'<br>';}?>
                                                <?php  if(isset($livreur->adress)){echo '<i class="fa fa-map-marker"></i> '.$livreur->adress.'<br>';}?>
                                                 - type de livraison : {{$commande->command_express ?? ''}}

                                                
                                                </td>
                                                <?php
                                                    $produit = json_decode($commande->produit); 
                                                ?>


                                                <td width="20%">                                                 
                                                    <i class="fa fa-box"></i>: {{$produit->nom ?? 'non définie'}}
                                                    <br>
                                                    <i class="fa fa-money"></i>quantité :   {{$commande->quantite ?? 'non définie'}}
                                                    <br>
                                                    prix :{{$commande->prix}} <i class=" fas fa-money-bill	"></i><br>
                                                    prix livraison:{{$commande->prix_livraison}} <i class=" fas fa-money-bill	"></i><br>
                                                    prix total: <strong style="color:green;">{{$commande->prix + $commande->prix_livraison}}</strong>  <i class=" fas fa-money-bill	"></i><br>
                                                 </td>

                                                 <td>{{$commande->credit_livreur ?? ''}}
                                                         <a>
                                                         
                                                         </a>
                                                         <a>
                                                         
                                                         </a>                                                     
                                                 </td>
                                                 <td></td>

                                                 <td width="20%">                                                 
                                                crée le :  {{$commande->created_at ?? 'non définie'}}<br>
                                                <i class="fa fa-volume-up" style="color:green"></i> en attente le :  {{$commande->en_attente ?? '--/--/--' }}<br>
                                                <i class="fa fa-walking" style="color:red"></i> accepté le :   {{$commande->accepte ?? '--/--/--' }}<br>
                                                <i class="fa fa-fa-motorcycle" style="color:green"></i> expédier le :  {{$commande->expedier ?? '--/--/--' }}<br>
                                                <i class="fa fa-hourglass-start" style="color:blue"></i><i class="fa fa-money-bill-alt" style="color:green"></i>
                                                 en attente de paiement le :  {{$commande->en_attente_paiement ?? '--/--/--' }}<br>
                                                <i class="fa fa-thumbs-up" style="color:green"></i> Livrée le : {{$commande->livree ?? '--/--/--' }}<br>
                                                </td>
                                                 
                                                <td >
                                                    <div class="table-action">  
                                                
                                                    <a 
                                                    href="{{route('commande.display',['id_commande'=>$commande->id])}}"
                                                     class="btn btn-success">
                                                     afficher
                                                     <i class="fa fa-eye"></i>
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

function watchWilayaChanges() {

            $('#wilaya_select').on('change', function (e) {

                e.preventDefault();

                var $communes = $('#commune_select');

                var $communesLoader = $('#commune_select_loading');

                var $iconLoader = $communes.parents('.input-group').find('.loader-spinner');

                var $iconDefault = $communes.parents('.input-group').find('.material-icons');

                $communes.hide().prop('disabled', 'disabled').find('option').not(':first').remove();

                $communesLoader.show();

                $iconDefault.hide();

                $iconLoader.show();

                $.ajax({

                    dataType: "json",

                    method: "GET",

                    url: "/api/static/communes/ " + $(this).val()

                })

                    .done(function (response) {

                        $.each(response, function (key, commune) {

                            $communes.append($('<option>', {value: commune.id}).text(commune.name));

                        });

                        $communes.prop('disabled', '').show();

                        $communesLoader.hide();

                        $iconLoader.hide();

                        $iconDefault.show();

                    });

            });

        }



        $(document).ready(function () {

            watchWilayaChanges();

        });



</script>

@endsection