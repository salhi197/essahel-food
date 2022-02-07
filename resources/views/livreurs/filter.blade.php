@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord </h1>        
                                    <div class="card-header">
                                        <p>
                                            Les Tickets de Livreur : {{$livreur->name ?? ''}} {{$livreur->prenom ?? ''}}
                                        </p>
                                    </div>

                           <div class="card mb-4">
                                     <div class="card-header">
                                         <form method="post" action="{{route('ticket.filter.livreur',['livreur'=>$livreur->id])}}">
                                            @csrf
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputEmailAddress">date début : </label>
                                                            <input  class="form-control py-4" id="telephpone"
                                                             name="date_debut" value="{{$date_debut}}"
                                                             type="date" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputEmailAddress">data fin: </label>
                                                            <input  class="form-control py-4" id="telephpone"
                                                             name="date_fin" value="{{$date_fin}}"
                                                             type="date" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                            <button type="submit" class="btn-sm btn btn-success">
                                                                Filtrer
                                                            </button>

                                                    </div>

                                            </form>


                                                    <div class="col-md-5" style="padding:35px;">
                                                        <a class="btn btn-primary btn-sm" href="{{route('ticket.affecter',['livreur'=>$livreur])}}">
                                                            Affecter Colis
                                                        </a>
                                                        <a class="btn btn-primary btn-sm" href="{{route('ticket.detacher',['livreur'=>$livreur])}}">
                                                            Détacher Colis
                                                        </a>
                                                        <a class="btn btn-primary btn-sm" href="{{route('ticket.retour',['livreur'=>$livreur])}}">
                                                            Retour
                                                        </a>
                                                    </div>
                                                </div>
                                </div>





                            <div class="card-body">
                                <div class="table-responsive">                               
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                            <th>date Création</th>
                                            <th>date Affectation</th>
                                                <th>Id</th>
                                                <th>Code bare</th>
                                                <th>Statut </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($tickets as $ticket)
                                                <tr>
                                                    <td>{{ date('d/m/Y h:m:s', strtotime($ticket->created_at)) }}</td>
                                                    <td>{{ $ticket->updated_at ?? '' }}</td>
                                                    <td>{{$ticket->id ?? ''}}</td>
                                                    <td>{{$ticket->codebar ?? ''}}</td>
                                                    <td>{{$ticket->satut ?? ''}}</td>
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
        $('.states').on('change', function (e) {
                var valueSelected = this.value;
                console.log(valueSelected)
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
            onChangeState();
            onChangeWilaya();
            $('.commande-checkbox').change(function(){
                var livreur = <?php echo json_encode($livreur->id); ?>;
                console.log(livreur)
                var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
                var hrefDetacher = "/commande/detacher/list/livreur/"+livreur+"/list?id=";
                var pritnA4 = "/commande/print/a4?id=";
                var printTicket = "/commande/print/ticket?id=";


                for(var i=0; i<checks.length; i++){
                    hrefDetacher =hrefDetacher +$(checks[i]).val()+",";
                    pritnA4 =pritnA4+$(checks[i]).val()+",";
                    printTicket =printTicket+$(checks[i]).val()+",";

                    $('#hrefDetacher').attr('href',hrefDetacher)
                    $('#pritnA4').attr('href',pritnA4)
                    $('#printTicket').attr('href',printTicket)


                }
            });



            $("#checkAll").click(function(){
                var livreur = <?php echo json_encode($livreur->id); ?>;
                $('input:checkbox').not(this).prop('checked', this.checked);
                var checks = $(".commande-checkbox:checked"); // returns object of checkeds.

                var hrefDetacher = "/commande/detacher/list/livreur/"+livreur+"/list?id=";
                var pritnA4 = "/commande/print/a4?id=";
                var printTicket = "/commande/print/ticket?id=";

                for(var i=0; i<checks.length; i++){
                    // if ($(this).is(':checked')) {
                    //     console.log($(this).val());
                    // } else {
                    //     console.log($(this).val());
                    // }
                    pritnA4 =pritnA4+$(checks[i]).val()+",";
                    printTicket =printTicket+$(checks[i]).val()+",";
                    hrefDetacher =hrefDetacher +$(checks[i]).val()+",";
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