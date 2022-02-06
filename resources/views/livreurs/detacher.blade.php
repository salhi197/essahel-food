@extends('layouts.master')

@section('content')




    <div class="container-fluid">
        <h1 class="mt-4"> Tableau de bord </h1>
        <div class="card mb-4">


            <div class="card mb-4">
                <div class="card-header">
                    <div class="row">

                        <div class="col-md-3">
                            <label class="control-label">{{ __('Wilaya') }}: </label>
                            <select class="form-control" id="wilaya_select" name="wilaya_id">
                                <option value="">{{ __('Please choose...') }}</option>
                                @foreach ($wilayas as $wilaya)
                                    <option value="{{$wilaya->id}}" {{$wilaya->id == (old('wilaya_id') ?? ($member->wilaya_id ?? '')) ? 'selected' : ''}}>
                                        {{$wilaya->name}}
                                    </option>
                                @endforeach
                            </select>

                        </div>


                        <div class="col-md-2" style="padding:35px;">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                détacher
                            </button>
                        </div>

                        <div class="col-md-1" style="padding:35px;">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Retour
                            </button>
                        </div>
                        <div class="col-md-3" style="padding:35px;">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Affecter Colis
                            </button>
                        </div>

                    </div>
                </div>





                <div class="card-body">
                    <div class="table-responsive">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck">
                            <label class="form-check-label" for="exampleCheck">séléctionner tout</label>
                        </div>


                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>date</th>
                                <th>client</th>
                                <th>Tracking</th>
                                <th>Consomateur</th>
                                <th>produit</th>
                                <th>wilaya</th>
                                <th>Livreur</th>
                                <th>actions</th>
                            </tr>
                            </thead>
                            <tbody style="display:none;">
                            @foreach($commandes as $commande)

                                <tr>
                                    <td>
                                        <input type="checkbox" class="form-check-input" id="exampleCheck{{$commande->id }}">

                                        {{$commande->created_at ?? ''}}
                                    </td>
                                    <td >
                                        <?php
                                        $fournisseur = json_decode($commande->fournisseur);
                                        ?>
                                        {{$fournisseur->nom_prenom ?? ''}}


                                    </td>

                                    <td style="text-transform: uppercase;">
                                        {{$commande->code_tracking ?? ''}}

                                    </td>


                                    <td >
                                        {{$commande->nom_client ?? 'non définie'}}<br>
                                        {{$commande->telephone ?? 'non définie'}}<br>
                                    </td>


                                    <td >
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
                                        <i class=" fas fa-money-bill	"></i> prix :{{$commande->total}} DA<br>

                                    </td>
                                    <td>
                                        {{App\Commande::getWilaya($commande->wilaya) ?? 'non définie'}}

                                    </td>

                                    <td>
                                        <?php
                                        $livreur = json_decode($commande->livreur);
                                        ?>
                                        <?php  if(isset($livreur->name)){echo '<i class="fa fa-user" style="color:green;"></i>'.$livreur->name.'<br>';}else{echo '<i class="fa fa-user" style="color:green;"></i> ';}?>
                                        <?php  if(isset($livreur->prenom)){echo $livreur->prenom.'<br>';}?>
                                        <?php  if(isset($livreur->telephone)){echo '<i class="fa fa-phone"></i> '.$livreur->telephone.'<br>';}?>

                                    </td>
                                    <td >

                                        <div class="dropdown">
                                            <a class="btn btn-info" href="{{route('commande.edit',['commande'=>$commande->id])}}"><i class="fa fa-pen"></i> </a>
                                            <a href="{{route('commande.show',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-eye"></i> </a>
                                            <a href="{{route('commande.retirer',['id_commande'=>$commande->id])}}" class="btn btn-info">retirer </a>
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

                });
                $(document).on("click", ".credit-modal", function () {
                    var myCommandeId = $(this).attr('id');
                    console.log(myCommandeId)
                    $("#commande_credit").val(myCommandeId);

                });
                $(document).on("click", ".retour-modal", function () {
                    var myCommandeId = $(this).attr('id');
                    console.log(myCommandeId)
                    $("#my_commande_id").val(myCommandeId);

                });




            </script>
@endsection