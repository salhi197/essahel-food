@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord </h1>        
                                <div class="card-header">
                                        <a class="btn btn-info" href="{{route('commande.show.create')}}">
                                            <i class="fas fa-plus"></i>
                                            Ajouter 
                                        </a>
                                        <a class="btn btn-info" href="#" id="pritnA4">
                                            <i class="fas fa-print"></i>
                                            A4
                                        </a>

                                        <a class="btn btn-info" href="#" id="printTicket">
                                            <i class="fas fa-print"></i>
                                            Ticket
                                        </a>


                                </div>  

                           <div class="card mb-4">
                                     <div class="card-header">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                            <label class="control-label">Wilaya : </label>
                                                            <select class="form-control wilayas" id="wilayas" name="wilaya_id">
                                                                <option value="commande-wilaya-all">{{ __('Tous...') }}</option>
                                                                @foreach ($wilayas as $wilaya)
                                                                    <option value="{{$wilaya->id}}">
                                                                        {{$wilaya->name}}
                                                                    </option>
                                                                @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                            <label class="control-label">{{ __('Etat') }}:</label>
                                                            <select class="form-control tous" id="tous" name="">
                                                                    <option value="">------------</option>
                                                                    <option value="en_cours">en cours</option>
                                                                
                                                                    <option value="confirmer">Confirmé</option>
                                                                    <option value="ne_reponds_pas">Ne repond pas</option>
                                                                    <option value="annule">Annule</option>
                                                                    <option value="en_preparation">en préparation</option>
                                                                    <option value="reporte">Reporté</option>
                                                            </select>
                                                    </div>
                                                    <div class="col-md-5" style="padding:35px;">
                                                            <a class="btn btn-danger" href="" id="hrefDelete">
                                                                Supprimer la séléction 
                                                            </a>
                                                            <a class="btn btn-danger" href="{{route('commande.confirmer',['fournisseur'=>$fournisseur])}}">
                                                                confirmer 
                                                            </a>
                                                    </div>
                                                    <div class="col-md-2" style="">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="checkAll">
                                                            <label class="form-check-label" for="exampleCheck">Tout</label>
                                                        </div>
                                                    </div>

                                                </div>
                                </div>




                            <div class="card-body">
                                <div class="table-responsive">                               
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>date</th>
                                                <th>Fournisseur</th>
                                                <th>Consomateur</th>
                                                <th>produit</th>
                                                <th>wilaya </th>
                                                <th>Commune</th>
                                                <th>état</th>

                                                <th>actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($commandes as $commande)                                            

                                            <tr class="
                                            commande-wilaya-{{$commande->wilaya}} commande-wilaya-all
                                            commande-tous-{{$commande->wilaya}} commande-tous
                                            commande-state-all
                                            commande-tous-{{$commande->state}}
                                            
                                            ">
                                                <td>
                                                    <input type="checkbox" value="{{$commande->id}}" class="form-check-input all commande-checkbox" id="exampleCheck{{$commande->wilaya }}">
                                                    {{ Carbon\Carbon::parse($commande->date_livraison)->format('Y-m-d') }}
                                                    <br>
                                                    <span class="badge badge-info"> {{$commande->state ?? ''}}  </span>

                                                </td>
                                                <td >                                                 
                                                    <?php
                                                        $fournisseur = json_decode($commande->fournisseur); 
                                                    ?>
                                                    {{$fournisseur->nom_prenom ?? ''}}                                                    
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
                                                    <i class=" fas fa-money-bill	"></i> prix :{{$commande->total}} DA<br>
                                                </td>
                                                <td>                                                 
                                                    {{App\Commande::getWilaya($commande->wilaya) ?? 'non définie'}} 
                                                </td>

                                                <td>                                                 
                                                    {{App\Commande::getCommune($commande->commune) ?? 'non définie'}} 
                                                </td>
                                                <td>                                                 
                                                    <span class="badge badge-info btn btn-info" style=""> 
                                                        {!! str_replace('_', ' ', $commande->state) !!}
                                                    </span>

                                                </td>

                                                <td >
                                                   
                                                    <div class="dropdown">
                                                        <!-- <a href="{{route('commande.download.single',['id_comamnde'=>$commande->id,'type'=>'a4'])}}" class="btn btn-success">
                                                            <i class="fa fa-download"></i> A4
                                                        </a> -->
                                                        <button class="btn btn-primary" data-toggle="modal" data-target="#Open{{$commande->id}}"><i class="fa fa-phone"></i> </button>
                                                        <a class="btn btn-info" href="{{route('commande.edit',['commande'=>$commande->id])}}"><i class="fa fa-pen"></i> </a>
                                                        <a href="{{route('commande.show',['id_commande'=>$commande->id])}}" class="btn btn-danger"><i class="fa fa-plus"></i> </a>
                                                        <a href="{{route('commande.timeline',['id_commande'=>$commande->id])}}" class="btn btn-success"><i class="fa fa-list"></i> </a>
                                                        <div class="modal fade" id="Open{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="Open{{$commande->id}}Label" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title" id="Open{{$commande->id}}Label">Modifier Commande:</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                            <div class="col-md-8">
                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">{{$commande->telephone}}</label>
                                                                                </div>
                                                                                

                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">{{$commande->nom_client}}</label>
                                                                                </div>
                                                                                
                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">{{App\Commande::getWilaya($commande->wilaya)}}</label>
                                                                                </div>
                                                                                
                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">{{$commande->commune}}</label>
                                                                                </div>
                                                                                
                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">Remarque :{{$commande->note}} </label>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <div class="form-group">
                                                                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal{{$commande->id}}">
                                                                                        Reporter
                                                                                    </button>
                                                                                    <br>
                                                                                    <div class="modal fade" id="exampleModal{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModal{{$commande->id}}Label" aria-hidden="true">
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
                                                                                                                    <label  for="inputFirstName">Nouvelle Date : </label>
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
                                                                                <br>
                                                                                <div class="form-group">
                                                                                    <a href="{{route('commande.set.state',['state'=>'annule','commande'=>$commande->id])}}" class="btn btn-danger" >
                                                                                        Annuler
                                                                                    </a>
                                                                                </div>
                                                                                <div class="form-group">                                                                                
                                                                                    <a href="{{route('commande.set.state',['state'=>'ne_reponds_pas','commande'=>$commande->id])}}" class="btn btn-primary" >
                                                                                        ne reponde pas
                                                                                    </a>
                                                                                </div>
                                                                                <a href="{{route('commande.confirmerOne',['commande'=>$commande->id])}}" class="btn btn-info" >
                                                                                    <i class="fa fa-check"></i> Confirmer
                                                                                </a>
                                                                            </div>

                                                                            </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                                        <label class="small mb-1" for="inputFirstName">Montant de créd</label>
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
                                    <br>


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
                                            <label class="small mb-1" for="inputFirstName">ty</label>
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

function onChangeState()
    {
        $('.states').on('change', function (e) {
                var valueSelected = this.value;
                if (valueSelected=="commande-state-all") {
                    $('.commande-state-all').show()
                }else{
                    $('.commande-state-all').hide()
                    $('.commande-state-'+valueSelected).show()
                }                
        });
    }

    
    function onChangeWilaya()
    {
        $('.tous').on('change', function (e) {
                var valueSelected = this.value;
                var item = 'commande-tous-'+valueSelected  
                console.log(item)

                if (valueSelected=="commande-tous") {
                    $('.commande-tous').show()
                }else{
                    $('.commande-tous').hide()
                    $('.'+item).show()
                }                
        });
    }



    function onChangeTous()
    {
        $('.wilayas').on('change', function (e) {
                var valueSelected = this.value;
                if (valueSelected=="commande-wilaya-all") {
                    $('.commande-wilaya-all').show()
                }else{
                    $('.commande-wilaya-all').hide()
                    $('.commande-wilaya-'+valueSelected).show()
                }                
        });
    }
    
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
            onChangeWilaya();
            onChangeTous();


            $('.commande-checkbox').change(function(){
                console.log('test')
                var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
                var hrefDelete = "/commande/supprimer/list?id=";
                var hrefConfirmer = "/commande/confirmer/list?id=";
                var pritnA4 = "/commande/print/a4?id=";
                var printTicket = "/commande/print/ticket?id=";
                for(var i=0; i<checks.length; i++){
                    hrefConfirmer =hrefConfirmer +$(checks[i]).val()+",";
                    hrefDelete =hrefDelete +$(checks[i]).val()+",";
                    pritnA4 =pritnA4+$(checks[i]).val()+",";
                    printTicket =printTicket+$(checks[i]).val()+",";
                    $('#hrefDelete').attr('href',hrefDelete)
                    $('#hrefConfirmer').attr('href',hrefConfirmer)
                    $('#pritnA4').attr('href',pritnA4)
                    $('#printTicket').attr('href',printTicket)
                }
            });


            $("#checkAll").click(function(){
                $('input:checkbox').not(this).prop('checked', this.checked);
                var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
                var hrefDelete = "/commande/supprimer/list?id=";
                var hrefConfirmer = "/commande/confirmer/list?id=";
                var pritnA4 = "/commande/print/a4?id=";
                var printTicket = "/commande/print/ticket?id=";
                for(var i=0; i<checks.length; i++){
                    pritnA4 =pritnA4+$(checks[i]).val()+",";
                    printTicket =printTicket+$(checks[i]).val()+",";
                    hrefDelete =hrefDelete +$(checks[i]).val()+",";
                    hrefConfirmer =hrefConfirmer +$(checks[i]).val()+",";
                    $('#hrefDelete').attr('href',hrefDelete)
                    $('#hrefConfirmer').attr('href',hrefConfirmer)
                    $('#pritnA4').attr('href',pritnA4)
                    $('#printTicket').attr('href',printTicket)
                }
            
            });

            




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