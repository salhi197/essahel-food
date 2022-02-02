@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord </h1>        
                           <div class="card mb-4">
                               <div class="card-header">
                                    Retour  commande 
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
                                            id="hrefRetour" href="#" class="btn btn-danger" >
                                                retour 
                                        </a>                                                                                                        
                                        <!-- <a  onclick="return confirm('etes vous sure  ?')"
                                            id="hrefRetour" href="#" class="btn btn-danger" >
                                                retour fournisseur  
                                        </a>                                                                                                         -->
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
                                                <th>Etat</th>
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
                                                <td>                                    
                                                    <span class="badge badge-info btn btn-info" style=""> 
                                                         {{$commande->state ?? ''}}  
                                                    </span>                                                

                                                </td>

                                            </tr>

                                            @endforeach
                                        </tbody>

                                    </table>
                                    <br>


                                </div>
                            </div>


                        </div>
                    </div>


                    
@endsection


@section('scripts')
<script>
    
        $(document).ready(function () {
            // $('.commande-checkbox').change(function(){
            //     var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
            //     var hrefRetour = "/commande/affecter/list?id=";
            //     var pritnA4 = "/commande/print/a4?id=";
            //     var printTicket = "/commande/print/ticket?id=";
            //     for(var i=0; i<checks.length; i++){
            //         hrefRetour =hrefRetour +$(checks[i]).val()+",";
            //         pritnA4 =pritnA4+$(checks[i]).val()+",";
            //         printTicket =printTicket+$(checks[i]).val()+",";

            //         $('#hrefRetour').attr('href',hrefRetour)
            //         $('#pritnA4').attr('href',pritnA4)
            //         $('#printTicket').attr('href',printTicket)
            //     }
            // });



            // $("#checkAll").click(function(){
            //     $('input:checkbox').not(this).prop('checked', this.checked);
            //     var checks = $(".commande-checkbox:checked"); // returns object of checkeds.
            //     var hrefRetour = "/commande/affecter/list?id=";

            //     for(var i=0; i<checks.length; i++){
            //         hrefRetour =hrefRetour +$(checks[i]).val()+",";
            //         $('#hrefRetour').attr('href',hrefRetour)
            //     }        
            // });       





        });

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        var livreur = <?php echo json_encode($_livreur); ?>;

        var hrefRetour = "/commande/retour/list/livreur/"+livreur+"/list?id=";
        console.log(hrefRetour)

        if(filter.length==0){
            for (i = 1; i < tr.length; i++) {
                tr[i].classList.add("tr-code");
                $('#hrefRetour').attr('href',"#")   
            }
        } else {
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                txtValue=td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    // .style.display="inline";
                    tr[i].classList.remove("tr-code");
                    hrefRetour =hrefRetour +tr[i].id+",";
                } else {
                    tr[i].classList.add("tr-code");
                }
            }   
            $('#hrefRetour').attr('href',hrefRetour)   
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
