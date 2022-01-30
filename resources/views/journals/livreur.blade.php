@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                           <div class="card mb-4">
                           <div class="card-header">
                                    Journal Livreur
                                </div>

                           <div class="card mb-4">
                                     <div class="card-header">
                                             <form method="post" action="{{route('journal.filter.livreur')}}">                                                    
                                                @csrf

                                                <div class="row">
                                                @auth('admin')

                                                    <div class="col-md-2" >
                                                        <label class="control-label">{{ __('Début') }}: </label>
                                                        <input class="form-control" value="{{$debut_entre ?? ''}}" name="debut_entre" type="date" />
                                                    </div>

                                                    <div class="col-md-2" >
                                                        <label class="control-label">{{ __('Fin') }}: </label>
                                                        <input class="form-control" value="{{$fin_entre ?? ''}}" name="fin_entre" type="date" />
                                                    </div>

                                                        <div class="col-md-2">
                                                            <label class="control-label">{{ __('Livreur') }}: </label>
                                                            <select class="form-control js-example-basic-single" id="" name="livreur">
                                                                <option value="">{{ __('Please choose...') }}</option>
                                                                @foreach ($livreurs as $livreur)
                                                                    <option value="{{$livreur->id}}" <?php if($_livreur ==$livreur->id){ ?> selected <?php } ?>>
                                                                    {{$livreur->prenom ?? ''}} 
                                                                    {{$livreur->name ?? ''}} 
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <label class="control-label">{{ __('Créance') }}: </label>
                                                        <select class="form-control"  name="creance">
                                                            <option value="">Sélctionner Type</option>
                                                            <option value="solder livreur" <?php if($creance == "solder livreur"){ ?> selected <?php } ?>>Soldé</option>
                                                                <option value="non solder" <?php if($creance == "non solder"){ ?> selected <?php } ?>>non Soldé</option>
                                                        </select>
                                                    </div>


                                                    <div class="col-md-4" style="padding:35px;">
                                                        <a href="#" id="solder" class="row btn btn-primary" >
                                                        Solder pour Livreur
                                                        </a>            
                                                        &nbsp;                                                                                            

                                                        <a href="#" id="nonsolder" class="row btn btn-primary" >
                                                            <i class="fa fa-check"></i>&nbsp;  Non Solder
                                                        </a>    
                                                        &nbsp;                                                                                                    
                                                        <button type="submit" class="row btn btn-primary" >
                                                            Filtrer
                                                        </button>                                                                                                        
                                                    </div>
                                                    @endif

                                                    <div class="col-md-2" >
                                                        <label class="control-label">Nbr de coliers: </label>
                                                        <input type="text" name="commande" class="form-control" readonly="true" value="{{count($commandes) ?? ''}}" />
                                                    </div>

                                                    <div class="col-md-2" >
                                                        <label class="control-label">Valeur Rapporté: </label>
                                                        <input type="text"  name="commande" class="form-control" 
                                                        readonly="true" value="{{$RapporteAuLsRapide}} DA"
                                                        />
                                                    </div>
                                                        <div class="col-md-2" >
                                                        <label class="control-label">Livreur: </label>
                                                        <input type="text"  name="commande" class="form-control"
                                                        readonly="true" value="{{$LivreurMontant}} DA"
                                                     />
                                                    </div>

                                                    <div class="col-md-2" >
                                                        <label class="control-label">LsRapide: </label>
                                                        <input type="text"  name="commande" class="form-control" 
                                                        readonly="true" value="{{$RapporteAuLsRapide-$LivreurMontant}} DA"
                                                        />
                                                    </div>

                                                    <div class="col-md-2" >
                                                        <label class="control-label">Non Abouti: </label>
                                                        <input type="text"  name="commande" class="form-control" 
                                                        readonly="true" value="{{$LivreurMontantNonAbouti}} DA"
                                                        />
                                                    </div>
                                                    <div class="col-md-2" style="padding:35px;">    
                                                        <a class="btn btn-info" href="#" id="pritnA4">
                                                            <i class="fas fa-print"></i>
                                                            Reçu

                                                        </a>
                                                    </div>
                                                </div>
                                            </form>
                                </div>





                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkAll">
                                        <label class="form-check-label" for="exampleCheck">séléctionner tout</label>
                                    </div>
                                

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                            <th></th>
                                            <th>date</th>
                                                <th>Fournisseur</th>
                                                <th>Livreur</th>
                                                <th>Total</th>

                                                <th>wilaya</th>
                                                <th>Creance livreur</th>
                                                
                                                <th>Colis U</th>
                                                <th>actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $TotalLivreur = 0;
                                                $ValeurReporte = 0;
                                                $ValeurReporteLsrapide = 0;
                                                
                                            ?>
                                            @foreach($commandes as $commande)                                            
                                            <tr>
                                                <td >
                                                    <input type="checkbox" value="{{$commande->id}}" class="form-check-input commande-checkbox" id="exampleCheck{{$commande->id }}">
                                                </td>
                                                <td>
                                                    {{$commande->created_at ?? ''}} 
                                                    <br>
                                                        <span class="badge badge-info"> {{$commande->state ?? ''}}  </span> 

                                                </td>
                                                <td >                                                 
                                                    <?php
                                                        $fournisseur = json_decode($commande->fournisseur); 
                                                    ?>
                                                    {{$fournisseur->nom_prenom ?? ''}}                                                    
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
                                                    {{$commande->total}} DA

                                                </td>
                                                <td>              
                                                {{App\Commande::getWilaya($commande->wilaya) ?? 'non définie'}} 
                                                </td>

                                                <td>               
                                                    <span class="badge badge-info"> {{$commande->creance_livreur}}  </span> 

                                                </td>

                                                <td>
                                                @if($commande->state=="Livree")
                                                    {{App\Commande::getWilayaLivreurTarif($commande->wilaya) ?? 'null'}}DA 
                                                @endif
                                                @if($commande->state=="non abouti")
                                                    {{App\Commande::getWilayaLivreurNonAboutiTarif($commande->wilaya) ?? 'null'}}DA 
                                                @endif
                                                </td>

                                                <td >
                                                   
                                                    <div class="dropdown">
                                                            <a class="btn btn-info" href="{{route('commande.edit',['commande'=>$commande->id])}}"><i class="fa fa-pen"></i> </a>
                                                            <a href="{{route('commande.show',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-eye"></i> </a>
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
        /**
         * 
         */
            $('.commande-checkbox').change(function(){
                var livreur = <?php echo json_encode($livreur->id ?? 0); ?>;
                console.log(livreur)
                var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
                var hrefDetacher = "/commande/detacher/list/livreur/"+livreur+"/list?id=";
                var pritnA4 = "/commande/print/a4?id=";
                var printTicket = "/commande/print/ticket?id=";
                var hrefSolder = "/commande/solder/livreur?id=";
                var hrefNonSolder = "/commande/nonsolder/livreur?id=";


                for(var i=0; i<checks.length; i++){
                    hrefDetacher =hrefDetacher +$(checks[i]).val()+",";
                    pritnA4 =pritnA4+$(checks[i]).val()+",";
                    printTicket =printTicket+$(checks[i]).val()+",";
                    hrefSolder =hrefSolder +$(checks[i]).val()+","
                    hrefNonSolder =hrefNonSolder +$(checks[i]).val()+",";
                    $('#solder').attr('href',hrefSolder)
                    $('#nonsolder').attr('href',hrefNonSolder)

                    $('#hrefDetacher').attr('href',hrefDetacher)
                    $('#pritnA4').attr('href',pritnA4)
                    $('#printTicket').attr('href',printTicket)

                }
            });


            $("#checkAll").click(function(){
                var livreur = <?php echo json_encode($livreur->id ?? 0); ?>;
                $('input:checkbox').not(this).prop('checked', this.checked);
                var checks = $(".commande-checkbox:checked"); // returns object of checkeds.

                var hrefDetacher = "/commande/detacher/list/livreur/"+livreur+"/list?id=";
                var pritnA4 = "/commande/print/a4?id=";
                var printTicket = "/commande/print/ticket?id=";

                var hrefSolder = "/commande/solder/livreur?id=";
                var hrefNonSolder = "/commande/nonsolder/livreur?id=";


                for(var i=0; i<checks.length; i++){
                    // if ($(this).is(':checked')) {
                    //     console.log($(this).val());
                    // } else {
                    //     console.log($(this).val());
                    // }
                    pritnA4 =pritnA4+$(checks[i]).val()+",";
                    printTicket =printTicket+$(checks[i]).val()+",";
                    hrefDetacher =hrefDetacher +$(checks[i]).val()+",";
                    hrefSolder =hrefSolder +$(checks[i]).val()+","
                    hrefNonSolder =hrefNonSolder +$(checks[i]).val()+",";
                    $('#solder').attr('href',hrefSolder)
                    $('#nonsolder').attr('href',hrefNonSolder)

                    $('#hrefDetacher').attr('href',hrefDetacher)
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