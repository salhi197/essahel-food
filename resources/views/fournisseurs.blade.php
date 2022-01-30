@extends('layouts.master')



@section('content')
<div class="container-fluid">

                        <h1 class="mt-4"> Tableau de bord </h1>        

                           <div class="card mb-4">

                                <div class="card-header">
                                <form method="post" action="{{route('fournisseur.filter')}}">
                                        @csrf

                                        <div class='row'>

                                                <a href="{{route('commande.show.create')}}" 
                                                style="height:40px;"
                                                class="btn btn-info text-white" >

                                                    <i class="fa fa-plus"></i> Ajouter 

                                                </a>
                                                <a class="btn btn-info" style="height:40px;" href="#" id="pritnA4">
                                                    <i class="fas fa-print"></i>
                                                    A4
                                                </a>
                                        
                                                <div class="col-md-2" style="padding:35px;">
                                                        <input class="form-control" value="{{$debut_entre ?? ''}}" name="debut_entre" type="date" />
                                                </div>
                                                <div class="col-md-2" style="padding:35px;">
                                                    <input class="form-control" value="{{$fin_entre ?? ''}}" name="fin_entre" type="date" />
                                                </div>

                                                    <div class="col-md-2">
                                                            <label class="control-label">{{ __('Wilaya') }}: </label>
                                                            <select class="form-control" id="wilaya_select" name="wilaya_id">
                                                                <option value="tous">{{ __('Please choose...') }}</option>
                                                                @foreach ($wilayas as $wilaya)
                                                                    <option value="{{$wilaya->id}}" {{$wilaya->id == (old('wilaya_id') ?? ($member->wilaya_id ?? '')) ? 'selected' : ''}}>
                                                                        {{$wilaya->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                    </div>


                                         <div class="col-md-2">

                                                <label class="control-label">{{ __('Etats') }}:</label>

                                                <select class="form-control states" id="states" name="">

                                                        <option value="tous">Tous</option>
                                                        <option value="en_cours">en cours</option> 

                                                        <option value="ne_reponds_pas">Ne repond pas</option>

                                                        <option value="Livree">livree</option>

                                                        <option value="en_preparation">en préparation</option>

                                                        <option value="reporte">Reporté</option>
                                                </select>
                                        </div>
                                        @if($confirmation==1)
                                            <div class="col-md-2">
                                                <select class="form-control states" id="states" name="">
                                                        <option value="tous">CallCenter</option>
                                                        <option value="en_cours">Confirmé</option> 
                                                        <option value="ne_reponds_pas">Ne repond pas</option>
                                                        <option value="reporte">Annulé</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="col-md-2" style="padding:35px;">
                                            <button class="text-white btn btn-primary" type="submit">
                                                    envoyer
                                                </button>                                                                                                        
                                        </div>

                                    </form>
                                    



                                    </div>




                                        

                                        <br>

                                            <div class="form-check">

                                                <input type="checkbox" class="form-check-input" id="checkAll">

                                                <label class="form-check-label" for="exampleCheck">Tout</label>

                                            </div>

                                            

                                                



                                </div>  

                      <div class="card-body">

                                <div class="table-responsive">

                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>

                                            <th>Id</th>

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

                                        <tbody>

                                            @foreach($commandes->reverse() as $commande)

                                            <tr

                                            class="

                                            tous

                                            commande-state-{{$commande->state}}
                                            commande-wilaya-{{$commande->wilaya}}


                                            "

                                            >

                                                <td>

                                                    <input type="checkbox" value="{{$commande->id}}" class="form-check-input all commande-checkbox" id="exampleCheck{{$commande->wilaya }}">

                                                    {{ $commande->id}}<br>
                                                    {{ $commande->state}}<br>
                                                    
                                                    @if($commande->state == "en_preparation")
                                                        <span class="badge badge-info btn btn-info" style=""> 

                                                            {{$commande->state ?? ''}}  

                                                        </span>                                                
                                                    @endif
                                                    @if($commande->state == "reporte")
                                                        <span class="badge badge-info btn btn-info" style=""> 

                                                            {{$commande->state ?? ''}}  

                                                        </span>                                                
                                                    @endif
                                                    
                                                    @if($commande->state == "sortie")
                                                        <span class="badge badge-info btn btn-info" style=""> 

                                                            {{$commande->state ?? ''}}  

                                                        </span>                                                
                                                    @endif


                                                    @if($commande->state == "annule")

                                                    <span class="badge badge-info btn btn-danger" style=""> 

                                                         {{$commande->state ?? ''}}  

                                                    </span>                                                

                                                    @endif



                                                    @if($commande->state == "en_cours")

                                                    <span class="badge badge-info btn btn-info" style=""> 

                                                         {{$commande->state ?? ''}}  

                                                    </span>                                                

                                                    @endif





                                                    @if($commande->state == "no_abouti")

                                                    <span class="badge badge-success btn btn-success" style=""> 

                                                         {{$commande->state ?? ''}}  

                                                    </span>                                                

                                                    @endif



                                                    @if($commande->state == "retour")

                                                    <span class="badge badge-success btn btn-success" style=""> 

                                                         {{$commande->state ?? ''}}  

                                                    </span>                                                

                                                    @endif





                                                    @if($commande->state == "Livree")

                                                    <span class="badge badge-success btn btn-success" style=""> 

                                                         {{$commande->state ?? ''}}  

                                                    </span>                                                

                                                    @endif



                                                    @if($commande->state == "ne_reponds_pas")

                                                    <span class="badge badge-warning" style=""> 

                                                         {{$commande->state ?? ''}}  

                                                    </span>                                                

                                                    @endif





                                                </td>



                                            <td>

                                                    {{ Carbon\Carbon::parse($commande->created_at)->format('Y-m-d') }}<br>



                                                </td>

                                                <td >                                                 

                                                    <?php

                                                        $fournisseur = json_decode($commande->fournisseur); 

                                                    ?>

                                                    {{$fournisseur->nom_prenom ?? ''}}



                                                    

                                                </td>



                                                 <td>                                                 

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

                                                   | {{$produit['quantite'] ?? 'non définie'}}

                                                   | {{$produit['prix_vente'] ?? 'non définie'}}

                                                    <br>

                                                    <?php

                                                        }                                        

                                                    ?>

                                                <br>

                                                        <i class=" fas fa-money-bill	"></i> prix :{{$commande->total}} D.A<br>



                                                </td>

                                                <td>                                                 

                                                    {{App\Commande::getWilaya($commande->wilaya) ?? ' '}} 

                                                    {{$commande->commune ?? ''}} 

                                                </td>

                                                <td>                                                 

                                                    <?php

                                                        $livreur = json_decode($commande->livreur); 

                                                    ?>

                                                    <?php  

                                                        if(isset($livreur->name)){echo '<i class="fa fa-user" style="color:green;"></i> <strong> '.$livreur->name.' </strong><br>';}else{echo '<i class="fa fa-user" style="color:green;"></i> ';}?>

                                                    <?php  

                                                        if(isset($livreur->prenom)){echo $livreur->prenom.'<br>';}?>

                                                </td>



                                                <td>

                                                   

                                                    <div class="dropdown">

                                                        <button class="btn btn-info" data-toggle="modal" data-target="#Open{{$commande->id}}">Historique </button>



                                                        <a class="btn btn-info" href="{{route('commande.edit',['commande'=>$commande->id])}}"><i class="fa fa-edit"></i> </a>

                                                        <div class="modal fade" id="Open{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="Open{{$commande->id}}Label" aria-hidden="true">

                                                            <div class="modal-dialog modal-lg" role="document">

                                                                <div class="modal-content">

                                                                    <div class="modal-header">

                                                                    <h5 class="modal-title" id="Open{{$commande->id}}Label">Historique:</h5>

                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                                        <span aria-hidden="true">&times;</span>

                                                                    </button>

                                                                    </div>

                                                                        <div class="modal-body">

                                                                            <div class="row">

                                                                                <div class="col-md-12">

                                                                                    <table class="table">

                                                                                        <thead>

                                                                                            <tr>

                                                                                                <th scope="col">Etat</th>

                                                                                                <th scope="col">Date</th>

                                                                                                <th scope="col">Acteur</th>

                                                                                            </tr>

                                                                                        </thead>

                                        <tbody>

                                            <tr>

                                                <td>en prépartion</td>

                                                <td>

                                                    {{$commande->en_prepartion ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>





                                            <tr>

                                                <td>en cours</td>

                                                <td>

                                                    {{$commande->en_cours ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>





                                            <tr>

                                                <td>Sortie</td>

                                                <td>

                                                    {{$commande->sortie ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>





                                            <tr><td>

                                                  Annule                                                    

                                                </td>

                                                <td>

                                                    {{$commande->annule ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>





                                            <tr>

                                                <td>

                                                    reporte                                           

                                                </td>

                                                <td>

                                                    {{$commande->reporte ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>





                                            <tr>

                                                <td>ne repodn pas</td>

                                                <td>

                                                    {{$commande->ne_reponds_pas ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>





                                            <tr>

                                                <td>non abouti</td>

                                                <td>

                                                    {{$commande->non_abouti ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>

                                            <tr>

                                                <td>livree</td>

                                                <td>

                                                    {{$commande->livree ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>



                                            <tr>

                                                <td>retour ls</td>

                                                <td>

                                                    {{$commande->retour ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>



                                            <tr>

                                                <td>retour client</td>

                                                <td>

                                                    {{$commande->retour ?? '--/--/--'}}

                                                </td>

                                                <td>{{$commande->acteur ?? "" }}</td>

                                            </tr>



                                        </tbody>





                                                                                    </table>





                                                                                </div>



                                                                            </div>



                                                                        </div>

                                                                </div>

                                                            </div>

                                                        </div>





<!--                                                        <a href="{{route('commande.destroy',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-trash"></i> </a>

-->

                                                        <a href="{{route('commande.show',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-eye"></i> </a>

                                                        <!-- <a href="{{route('commande.timeline',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-list"></i> </a> -->







                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editState{{$commande->id}}">

                                                            <i class="fa fa-pen"></i> 

                                                        </button>

                                                        <!-- <a onclick="return confirm('etes vous sure  ?')" href="{{route('commande.destroy',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-trash"></i> </a> -->



                                                        <div class="modal fade" id="editState{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="editState{{$commande->id}}Label" aria-hidden="true">

                                                            <div class="modal-dialog" role="document">

                                                                <div class="modal-content">

                                                                    <div class="modal-header">

                                                                    <h5 class="modal-title" id="editState{{$commande->id}}Label">Modifier l'etat de la commande :</h5>

                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                                                        <span aria-hidden="true">&times;</span>

                                                                    </button>

                                                                    </div>

                                                                    <div class="modal-body">

                                                                    <form id="form_type" action=" {{route('commande.update.state')}}" method="post">

                                                                        @csrf

                                                                        <div class="form-row">

                                                                            <div class="col-md-6">

                                                                                <input type="hidden" value="{{$commande->id}}" name="commande"/>

                                                                                <div class="form-group">

                                                                                    <label class="small mb-1" for="inputFirstName">type: </label>

                                                                                        <select class='form-control produits' name='state' >

                                                                                            <option>veuillez séélctionner </option>

                                                                                            <option value="en preparation">en prépartion</option>

                                                                                            <option value="en_cours">en cours</option>

                                                                                            <option value="sortie">sortie</option>

                                                                                            <option value="annule">annule</option>

                                                                                            <option value="reporte">reporte</option>

                                                                                            <option value="non_abouti">non abouti</option>

                                                                                            <option value="ne_repond_pas">ne repond pas</option>

                                                                                            <option value="livree">livree</option>

                                                                                            <option value="retour">retour</option>

                                                                                        </select>

                                                                            </div>

                                                                        </div>

                                                                        <button class="btn btn-primary btn-block" type="submit" >modifer type</button>

                                                                    </form>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>









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

  function onChangeState()
  {
    $('#states').on('change', function (e) {
            var valueSelected = this.value;
            var item = 'commande-state-'+valueSelected  
            console.log(item)
            if (valueSelected=="tous") {
                $('.tous').show()
            }else{
                $('.tous').hide()
                $('.'+item).show()
            }                
    });
  }

  function onChangeWilaya()
  {
    $('#wilaya_select').on('change', function (e) {
            var valueSelected = this.value;
            var item = 'commande-wilaya-'+valueSelected  
            console.log(item)
            if (valueSelected=="tous") {
                $('.tous').show()
            }else{
                $('.tous').hide()
                $('.'+item).show()
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
            onChangeWilaya();
            onChangeState();
            watchWilayaChanges();


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