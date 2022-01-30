@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord acteur boutique / list des commandes</h1>
                       <div class="card mb-4">
                            <div class="card-header">


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

                                            <div class="modal fade" id="retourModal{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                      <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">
                                                        Saisir quantité retour pour chaque produit :
                                                        </h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                      </div>
                                                      <div class="modal-body">
                                                                  <form id="commande_update_retour" action=" {{route('commande.update.retour')}}" method="post">
                                                                  @csrf
                                                                      <div class="form-row">
                                                                          <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <input type="hidden" value="" name="my_commande_id" id="my_commande_id"/>
                                                                            </div>
                                                                    <?php
                                                                        $produits = json_decode($commande->produit);                                                                                      
                                                                        foreach($produits as $produit){
                                                                            $produit = json_decode(json_encode($produit), true); ?>
                                                                      <div class="form-row">
                                                                                <div class="form-group">
                                                                                    <label class="small mb-1" for="inputFirstName">Quantité retour dans {{$produit['nom']}} : </label>
                                                                                    <input type="text" value="" name="quantites[]" class="form-control"/>
                                                                                </div>
                                                                      </div>
                                                                      <?php } ?>

                                                                  </form>
                                                                  <button onclick="document.getElementById('commande_update_retour').submit();" class="btn btn-primary btn-block" type="submit" >insérer</button>

                                                              </div>


                                                  </div>
                                              </div>
                                        </div>




                                            <tr>
                                                <td>
                                                    {{$commande->id ?? ''}} 
                                                    <br>crée par : {{$commande->acteur ?? ''}}
                                                    <br>
                                                    <?php  if($commande->command_express == "express"){echo '<i class="fa fa-star style="color:yellow;"></i>'.$commande->command_express.'<br>';}else{echo $commande->command_express;}?>

                                                    @if($commande->state == "annule")
                                                    <p>
                                                    <i class="fas fa-frown" style="font-size:40px;color:red;"></i><br> Annulé :  {{$commande->motif ?? '--/--/--' }}<br>
                                                    </p>
                                                    @endif


                                                @if($commande->state == 'en attente')
                                                <br> <i class="fa fa-volume-up" style="font-size:40px;color:green"></i><br> {{$commande->state ?? ''}} <br>
                                                @endif
                                                @if($commande->state == 'accepte')
                                                <br> <i class="fa fa-walking" style="font-size:40px;color:red"></i><br> {{$commande->state ?? ''}} <br>
                                                @endif
                                                @if($commande->state == 'expedier')
                                                <br> <i class="fa fa-motorcycle" style="font-size:40px;color:blue"></i><br> {{$commande->state ?? ''}} <br>
                                                @endif
                                                @if($commande->state == 'en attente paiement')
                                                <br> <i class="fa fa-hourglass-start" style="font-size:40px;color:blue"></i><br> {{$commande->state ?? ''}}<br> <i class="fa fa-money-bill-alt" style="font-size:40px;color:green"></i><br> {{$commande->state ?? ''}}
                                                @endif
                                                @if($commande->state == 'livree')
                                                <i class="fa fa-thumbs-up" style="font-size:40px;color:green"></i><br> {{$commande->state ?? ''}} <br>
                                                @endif


                                                    
                                                </td>
                                                <td width="10%">                                                 
                                                    <i class="fa fa-user"></i>: {{$commande->nom_client ?? 'non définie'}}<br>
                                                    <i class="fa fa-phone"></i>: {{$commande->telephone ?? 'non définie'}}<br>
                                                    {{App\Commande::getWilaya($commande->wilaya) ?? 'non définie'}}<br>
                                                    {{App\Commande::getCommune($commande->commune) ?? 'non définie'}}<br>

 
 

                                                 </td>

                                                 <td width="20%">                                                 
                                                <?php
                                                    $livreur = json_decode($commande->livreur); 
                                                ?>
                                                <?php  if(isset($livreur->name)){echo '<i class="fa fa-user" style="color:yellow;"></i>'.$livreur->name.'<br>';}else{echo '<i class="fa fa-user" style="color:yellow;"></i> ';}?>
                                                <?php  if(isset($livreur->prenom)){echo $livreur->prenom.'<br>';}?>
                                                <?php  if(isset($livreur->telephone)){echo '<i class="fa fa-phone"></i> '.$livreur->telephone.'<br>';}?>
                                                <?php  if(isset($livreur->adress)){echo '<i class="fa fa-map-marker"></i> '.$livreur->adress.'<br>';}?>
                                                 - type de livraison : {{$commande->command_express ?? ''}}

                                                
                                                </td>


                                                <td width="20%">                                                 
                                                <?php
                                                    $total_produit = 0;$total= 0;
                                                    $produits = json_decode($commande->produit);
                                                    foreach($produits as $produit){
                                                        $produit = json_decode(json_encode($produit), true);

                                                                                                                
                                                ?>
                                                  <i class=" fas fa-box	"></i>  produit : 
                                                   {{$produit['nom']}}
                                                    | {{$produit['quantite'] ?? 'non définie'}}<br>

                                                    <?php
                                                        }                                        
                                                    ?>

                                                <br>
                                                        <br>
                                                        <i class=" fas fa-money-bill	"></i> prix :{{$commande->total}} DA<br>
                                                        <i class=" fas fa-money-bill	"></i> prix livraison:{{$commande->prix_livraison}} DA <br>
                                                        <i class=" fas fa-money-bill	"></i> prix total: <strong style="color:green;">{{$commande->total + $commande->prix_livraison}}</strong> DA <br>
                                                 </td>

                                                 <td style="color:green;"> {{$commande->credit_livreur.' DA' ?? 'non'}} 
                                                         <a>
                                                         
                                                         </a>
                                                         <a>
                                                         
                                                         </a>                                                     
                                                 </td>
                                                 <td>
                                                     {{$commande->retour_au_depot ?? 'pas de retour au dépot'}}
                                                 </td>

                                                 <td width="20%">                                                 
                                                crée  :  {{$commande->created_at ?? 'non définie'}}<br>
                                                <i class="fa fa-volume-up" style="color:green"></i>{{$commande->en_attente ?? '--/--/--' }}<br>
                                                <i class="fa fa-walking" style="color:red"></i> {{$commande->accepte ?? '--/--/--' }}<br>
                                                <i class="fa fa-motorcycle" style="color:green"></i> {{$commande->expedier ?? '--/--/--' }}<br>
                                                <i class="fa fa-hourglass-start" style="color:blue"></i><i class="fa fa-money-bill-alt" style="color:green"></i>
                                                 {{$commande->en_attente_paiement ?? '--/--/--' }}<br>
                                                <i class="fa fa-thumbs-up" style="color:green"></i> {{$commande->livree ?? '--/--/--' }}<br>
                                                </td>
                                                 
                                                <td >
                                                   
                                                <div class="dropdown">
                                                    <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    actions
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a onclick="return confirm('etes vous sure  ?')" href="{{route('commande.destroy',['id_commande'=>$commande->id])}}"class="dropdown-item"><i class="fa fa-trash"></i> supprimer</a>
                                                    <a class="dropdown-item" href="{{route('commande.edit',['commande'=>$commande->id])}}"><i class="fa fa-pen"></i> éditer  </a>

                                                    <a class="dropdown-item open-AddBookDialog" id="{{$commande->id}}" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-edit"></i> modifier état  </a>
                                                    
                                                    <a data-toggle="modal" data-target="#retourModal{{$commande->id}}" class="dropdown-item btn btn-info retour-modal" id="{{$commande->id}}">  <i class="fas fa-cart-plus"></i> retour </a>
                                                    <a data-toggle="modal" data-target="#creditModal" class="dropdown-item btn btn-info credit-modal" id="{{$commande->id}}">  <i class="fas fa-cart-plus"></i> Crédit </a>
                                                    <a href="{{route('commande.show',['id_commande'=>$commande->id])}}" class="dropdown-item"><i class="fa fa-eye"></i> consulter</a>

                                                    </div>
                                                </div>                                                
                                                </td>

                                            </tr>

                                            @endforeach
                                            <div class="modal fade" id="creditModal" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Saisir le crédit  :</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <form id="commande_update_credit" action=" {{route('commande.update.credit')}}" method="post">
                                                        @csrf
                                                            <div class="form-row">
                                                                <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="" name="commande" id="commande_credit"/>
                                                                </div>
                                                                    <div class="form-group">
                                                                        <label class="small mb-1" for="inputFirstName">Montant de crédit: </label>
                                                                        <input type="text" class="form-control" value="" name="montant_credit" id=""/>                                        
                                                                    </div>

                                                            </div>
                                                            <br>
                                                        </form>
                                                        <button class="btn btn-primary btn-block" type="button" onclick="document.getElementById('commande_update_credit').submit();" >envoyer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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