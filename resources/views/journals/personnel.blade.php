@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                        <h1 class="mt-4"> Journal personnel </h1>        
                           <div class="card mb-4">

                           <div class="card mb-4">
                                     <div class="card-header">
                                             <form method="post" action="/journal/filter/personnel">                                                    
                                                @csrf
                                                <div class="row">


                                                    <div class="col-md-2">
                                                            <label class="control-label">{{ __('Personnel') }}: </label>
                                                            <select class="form-control" id="" name="admin">
                                                                <option value="">{{ __('Please choose...') }}</option>
                                                                @foreach ($admins as $admin)
                                                                    <option value="{{$admin->id}}" <?php if($_admin ==$admin->id){ ?> selected <?php } ?>>
                                                                    {{$admin->name ?? ''}} 
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                    </div>

                                                    <div class="col-md-2" style="padding:35px;">
                                                        <button name="" class="btn btn-info" >Actualiser</button>
                                                    </div>
                                                    <div class="col-md-2" >
                                                        <label class="control-label">Valeur Rapporté: </label>
                                                        <input type="text"  name="commande" class="form-control" 
                                                        readonly="true" value="{{$total}} DA"
                                                        />
                                                    </div>
                                                    <div class="col-md-2" style="padding:35px;">
                                                        <a href="{{route('admin.remise.zero',['id'=>$_admin])}}" class="btn btn-info" >remise à zero</a>
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
                                                    <?php  if(isset($livreur->name)){echo '<i class="fa fa-admin" style="color:green;"></i>'.$livreur->name.'<br>';}else{echo '<i class="fa fa-admin" style="color:green;"></i> ';}?>
                                                    <?php  if(isset($livreur->prenom)){echo $livreur->prenom.'<br>';}?>
                                                    <?php  if(isset($livreur->telephone)){echo '<i class="fa fa-phone"></i> '.$livreur->telephone.'<br>';}?>
                                                 </td>

                                                <td >                                                 
                                                    {{$commande->total}} DA<br>
                                                </td>
                                                <td>              

                                                {{App\Commande::getWilaya($commande->wilaya) ?? 'non définie'}} 
                                                </td>

                                                <td>

                                                    {{App\Commande::getWilayaLivreurTarif($commande->wilaya) ?? 'null'}}DA 
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
            // if ($(this).is(':checked')) {
            //     console.log($(this).val());
            // } else {
            //     console.log($(this).val());
            // }
            var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
                var hrefSolder = "/commande/solder?id=";
                var hrefNonSolder = "/commande/nonsolder?id=";

            for(var i=0; i<checks.length; i++){
                hrefSolder =hrefSolder +$(checks[i]).val()+","
                hrefNonSolder =hrefNonSolder +$(checks[i]).val()+",";
                console.log(hrefSolder,hrefNonSolder);
                    $('#solder').attr('href',hrefSolder)
                    $('#nonsolder').attr('href',hrefNonSolder)
            }

        });


         $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
            var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
                var hrefSolder = "/commande/solder?id=";
                var hrefNonSolder = "/commande/nonsolder?id=";

            for(var i=0; i<checks.length; i++){
                // if ($(this).is(':checked')) {
                //     console.log($(this).val());
                // } else {
                //     console.log($(this).val());
                // }
                hrefSolder =hrefSolder +$(checks[i]).val()+","
                hrefNonSolder =hrefNonSolder +$(checks[i]).val()+",";
                console.log(hrefSolder,hrefNonSolder);
                    $('#solder').attr('href',hrefSolder)
                    $('#nonsolder').attr('href',hrefNonSolder)
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