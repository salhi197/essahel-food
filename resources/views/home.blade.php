@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord</h1>
        

                       <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-info" href="{{route('commande.show.create')}}">
                                    <i class="fas fa-plus"></i>
                                    Ajouter une commande
                                </a>
                            </div>



                      <div class="row">

                        <!-- Earnings (Monthly) Card Example -->

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total commandes</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['commandes']}}</div>
                                </div>
                                <div class="col-auto">
                                  <a href="{{route('commande.index')}}">
                                  <i class="fas fa-calendar fa-2x text-gray-300"></i>
</a>
                                </div>

                              </div>

                            </div>

                          </div>

                        </div>



                        <!-- Earnings (Monthly) Card Example -->

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Livreur</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['livreurs']}}</div>
                                </div>

                                <div class="col-auto">
                                  <a href="{{route('livreur.index')}}">
                                  <i class="fas fa-truck fa-2x text-gray-300"></i>
</a>
                                </div>

                              </div>

                            </div>

                          </div>

                        </div>



                        <!-- Earnings (Monthly) Card Example -->

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total des produits</div>
                                  <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$data['produits']}}</div>    
                                    </div>


                                  </div>

                                </div>

                                <div class="col-auto">
                                  <a href="{{route('produit.index')}}">
                                  <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
</a>
                                </div>

                              </div>

                            </div>

                          </div>

                        </div>



                        <!-- Pending Requests Card Example -->

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Commerciaux</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['users']}}</div>
                                </div>
                                <div class="col-auto">                                  
                                <a href="{{route('user.index')}}">
                                  <i class="fas fa-user-shield fa-2x text-gray-300"></i>
</a>                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Free-lanceurs</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['users']}}</div>
                                </div>
                                <div class="col-auto">
                                <a href="{{route('freelancer.index')}}">
                                  <i class="fas fa-user-shield fa-2x text-gray-300"></i>
</a>                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Boutiques</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{$data['users']}}</div>
                                </div>
                                <div class="col-auto">                                  <a href="{{route('boutique.index')}}">
                                  <i class="fas fa-user-shield fa-2x text-gray-300"></i>
</a>                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Stocks</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">--</div>
                                </div>
                                <div class="col-auto">                                  <a href="#">
                                  <i class="fas fa-user-shield fa-2x text-gray-300"></i>
</a>                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>

                      <div class="card-body">
                                        <form method="post" action="{{route('commande.search')}}">
                                        @csrf
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">id commande : </label>
                                                        <input  class="form-control" id="quantite" 
                                                        name="id_commande" type="text" placeholder="" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">nom et prenom</label>
                                                        <input  class="form-control py-4" name="nom" id="nom" type="text" placeholder="enter surname : " />
                                                    </div> 
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">Type livraison: </label>
                                                        <select class="form-control" name="wilaya_id">
                                                                <option value="">{{ __('Choisisez ...') }}</option>
                                                                    <option value="express_24" >
                                                                    Express 24h 
                                                                    </option>
                                                                    <option value="livraison_domicile">
                                                                    livraison à domicile (3jours)
                                                                    </option>
                                                            </select>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">Téléphone : </label>
                                                        <input  class="form-control py-4" id="telephpone"  name="telephone" type="text" placeholder="Enter phone number e.g : (+213) 659-43-96-77" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">date livraison : </label>
                                                        <input  class="form-control py-4" id="telephpone" 
                                                         name="date_livraison" type="date" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">{{ __('Wilaya') }}: </label>
                                                            <select class="form-control" id="wilaya_select" name="wilaya_id">
                                                                <option value="">{{ __('Please choose...') }}</option>
                                                                @foreach ($wilayas as $wilaya)
                                                                    <option value="{{$wilaya->id}}" {{$wilaya->id == (old('wilaya_id') ?? ($member->wilaya_id ?? '')) ? 'selected' : 'non définie'}}>
                                                                        {{$wilaya->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('wilaya_id'))
                                                                <p class="help-block">{{ $errors->first('wilaya_id') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="control-label">{{ __('Commune') }}: </label>
                                                            <select class=" form-control" name="commune_id" id="commune_select">
                                                                <option value="">{{ __('Please choose...') }}</option>
                                                                @foreach ($communes as $commune)
                                                                    <option value="{{$commune->id}}" {{$commune->id == (old('commune_id') ?? ($member->commune_id ?? '')) ? 'selected' : 'non définie'}}>
                                                                        {{$commune->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input class="form-control valid" id="commune_select_loading" value="{{ __('Loading...') }}"
                                                                readonly style="display: none;"/>
                                                            @if ($errors->has('commune_id'))
                                                                <p class="help-block">{{ $errors->first('commune_id') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                            </div>
                                                <div class="col-md-2">
                                                     <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">
                                                        checher- cette focntion est à développé 
                                                        </button>
                                                    </div>
                                                </div>
                                        </form>
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
                                                <th>retour au produit</th>
                                                <th>payment clicntic </th>
                                                <th>timelines</th>
                                                <th>actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($commandes as $commande)                                            

                                            <tr>
                                                <td>
                                                    {{$commande->id ?? ''}}
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

                                                 <td></td>
                                                 <td></td>
                                                 <td></td>
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
                                                    onclick="return confirm('etes vous sure  ?')"
                                                    href="{{route('commande.destroy',['id_commande'=>$commande->id])}}"
                                                    class=" ">
                                                             <i class="fa fa-trash"></i
                                                    </a>
                                                    <a data-toggle="modal" data-target="#exampleModal" class="open-AddBookDialog" id="{{$commande->id}}">
                                                    <i class="fa fa-pen"></i>
                                                    </a>


                                                    <a 
                                                    href="{{route('commande.show',['id_commande'=>$commande->id])}}"
                                                     class="">
                                                     <i class="fa fa-eye"></i
                                                    </a>
                                                    </div>
                                                </td>

                                            </tr>

                                            @endforeach


                                        </tbody>
                                        {{ $commandes->links() }}

                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier l'etat de la commande :</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_type" action=" {{route('commande.update.state')}}" method="post">
        @csrf
            <div class="form-row">
                <div class="col-md-6">
                <div class="form-group">
                <input type="hidden" value="" name="commande" id="commande_id"/>
                </div>
                    <div class="form-group">
                    <label class="small mb-1" for="inputFirstName">type: </label>
                        <select class='form-control produits' name='state' >
                            <option>veuillez séélctionner </option>
                            <option value="en attente">en attente</option>
                            <option value="accepte">accepte</option>
                            <option value="expedier">expedier</option>
                            <option value="en attente paiement">en attente paiement</option>
                            <option value="livree">livree</option>
                        </select>

                </div>
            </div>
            <br>
            <button class="btn btn-primary btn-block" type="submit" >modifer type</button>
        </form>
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
$(document).on("click", ".open-AddBookDialog", function () {
  var myCommandeId = $(this).attr('id');
  console.log(myCommandeId)
  $("#commande_id").val(myCommandeId);

  // As pointed out in comments, 
     // it is unnecessary to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});



</script>
@endsection