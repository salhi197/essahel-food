@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord </h1>        
                           <div class="card mb-4">
                               <div class="card-header">
                                    Confirmer commande 
                                </div>

                               <div class="card-header">

                                    <div class="row">
                                        <input 
                                        onkeyup="myFunction()" 
                                        class="col-md-2 form-control" id="search"  placeholder="filter avec Code Bar" />

                                        <!-- <div class="col-md-2" style="">
                                            <div class="form-check">
                                                <input type="checkbox"  class="form-check-input" id="checkAll">
                                                <label class="form-check-label" for="checkAll">séléctionner tout :</label>
                                            </div>
                                        </div> -->
                                        &nbsp;
                                        <a  onclick="return confirm('etes vous sure  ?')"
                                            id="hrefConfirmer" href="#" class="btn btn-danger" >
                                                confirmation   
                                        </a>                                                                                                        
                                    </div>



                                </div>







                            <div class="card-body">
                                <div class="table-responsive">
                                

                                    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
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
                                        <tbody >
                                            @foreach($commandes as $commande)                                            
                                            <tr 
                                            id="{{$commande->id}}"
                                            class="tr-code commande-tracking-{{$commande->code_tracking}} commande-code-tracking-all
                                            commande-state-all
                                            commande-state-{{$commande->state}}
                                            ">
                                                <td>
                                                    <!-- <input type="checkbox" value="{{$commande->id}}" class="form-check-input commande-checkbox all" id="exampleCheck{{$commande->wilaya }}"> -->

                                                    {{ Carbon\Carbon::parse($commande->created_at)->format('Y-m-d') }}<br>
                                                    <span class="badge badge-info"> {{$commande->state ?? ''}}  </span>
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
                                                                <a href="{{route('commande.show',['id_commande'=>$commande->id])}}" class="btn btn-danger"><i class="fa fa-plus"></i> </a>
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
    
    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        var fournisseur = <?php echo json_encode($_fournisseur); ?>;

        var hrefConfirmer = "/commande/confirmer/list/fournisseur/"+fournisseur+"/list?id=";

        console.log(hrefConfirmer)

        if(filter.length==0){
            for (i = 1; i < tr.length; i++) {
                tr[i].classList.add("tr-code");
                $('#hrefConfirmer').attr('href',"#")   
            }
        } else {
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                txtValue=td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    // .style.display="inline";
                    tr[i].classList.remove("tr-code");
                    hrefConfirmer =hrefConfirmer +tr[i].id+",";
                } else {
                    tr[i].classList.add("tr-code");
                }
            }   
            $('#hrefConfirmer').attr('href',hrefConfirmer)   
            }        
        }
    }


</script>
@endsection
@section('styles')
<style>
.tr-code{
    display:none;
}
</style>
@endsection
