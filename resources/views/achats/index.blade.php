@extends('layouts.admin')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4">Tables des Achats : </h1>

                             <div class="card mb-4">
                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <a class="btn btn-primary" href="{{route('achat.show.create')}}">Nouvelle Achat</a>
                                                    </div>
                                                    <div class="col-md-3">
                                                            <select class='form-control fournisseurs' name='produit' id="produit" >
                                                                        <option value="all" >
                                                                        tous
                                                                        </option>                    

                                                                @foreach($fournisseurs as $fournisseur)
                                                                        <option value="{{$fournisseur->id}}" >
                                                                        {{$fournisseur->nom_prenom}}
                                                                        </option>                    
                                                                @endforeach
                                                            </select>

                                                    </div>
                                </div>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>
                                                <th>ID </th>
                                                <th>Fournisseur </th>
                                                <th>Prooduits </th>
                                                <th>Date facture</th>                                              
                                                <th>Actions</th>                                              
                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($achats as $achat)                                            
                                                <?php
                                                        $fournisseur= json_decode($achat->fournisseur);
                                                    ?>
                                            <div class="modal fade" id="retourModal{{$achat->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                      <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Insérer qte retour :</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true"></span>
                                                      </button>
                                                      </div>
                                                      <div class="modal-body">
                                                                  <form id="form_type" action="{{route('achat.update.retour')}}" method="post">
                                                                  @csrf
                                                                      <div class="form-row">
                                                                          <div class="col-md-6">
                                                                          <div class="form-group">
                                                                              <input type="hidden" value="" name="achat" id="id_achat"/>
                                                                          </div>
                                                                      <div class="form-group">
                                                                              <label class="small mb-1" for="inputFirstName">Produit : </label>
                                                                                  <select class='form-control' name='produit' >
                                                                                      <?php
                                                                                    $produits = json_decode($achat->produits);
                                                                                    foreach($produits as $produit){
                                                                                        $produit = json_decode(json_encode($produit), true);
                                                                                        ?>
                                                                                                  <option value="{{$produit['id']}}">{{$produit['nom']}} </option>
                                                                                          <?php } ?>
                                                                                  </select>
                                                                          </div>

                                                                      <div class="form-group">
                                                                              <label class="small mb-1" for="inputFirstName">Quantité retour : </label>
                                                                              <input type="text" value="" name="retour" id="retour" class="form-control"/>
                                                                          </div>
                                                                      </div>
                                                                      <br>
                                                                      <button class="btn btn-primary btn-block" type="submit" >insérer</button>
                                                                  </form>
                                                              </div>


                                                  </div>
                                              </div>
                                        </div>



                                            <tr class="fournisseur fournisseur-{{$fournisseur->id}}">

                                                <td>{{$achat->id ?? ''}}<br>
                                                <span class="badge badge-success">{{$achat->state ?? ''}}</span>
                                                </td>
                                                <td> <i class=" fas fa-user	"></i> {{$fournisseur->nom_prenom ?? ''}} - {{$fournisseur->telephone ?? ''}}  </td>
                                                <td width="20%">                                                 
                                                    <?php
                                                        $total_produit = 0;$total= 0;
                                                        $produits = json_decode($achat->reste);
                                                        foreach($produits as $produit){
                                                            $produit = json_decode(json_encode($produit), true);

                                                                                                                    
                                                    ?>
                                                        <i class=" fas fa-box	"></i>  produit : 
                                                        {{str_limit($produit['nom'], $limit = 10, $end = '')}} -- 
                                                        {{$produit['quantite']}}
                                                        
                                                        <br>
                                                        <?php  } ?>
                                                            <br>
                                                            <i class=" fas fa-money-bill	"></i> prix :{{$achat->total}} DA<br>
                                                 </td>



                                                <td>{{$achat->created_at ?? ''}} </td>
                                                <td >

                                                    <div class="table-action">  
                                                        <a 
                                                        href="{{route('achat.facture',['id_Achat'=>$achat->id])}}"
                                                        class="text-white btn btn-primary">
                                                                <i class="fas fa-eye"></i> Facture 
                                                        </a>
                                                        @if($achat->state == "credit")
                                                            <a 
                                                            href="{{route('payment.index',['achat'=>$achat->id])}}"
                                                            class="text-white btn btn-primary">
                                                                    <i class="fas fa-list"></i> Payments
                                                            </a>
                                                        @endif

                                                        <a 
                                                        href="{{route('payment.list',['achat'=>$achat->id])}}"
                                                        class="text-white btn btn-primary">
                                                                <i class="fas fa-list"></i>voir Payments
                                                        </a>


                                                        <a 
                                                        class="text-white btn btn-primary retour-modal"
                                                        data-toggle="modal" data-target="#retourModal{{$achat->id}}"  id="{{$achat->id}}">  <i class="fas fa-cart-plus"></i> retour </a>
                                                        <!-- <a 
                                                        href="#"
                                                        class="btn btn-primary text-white"
                                                        id="{{$achat->id}}">  Marquer comme payé </a> -->


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





@endsection
@section('scripts')
    <script>
    function onChangefournisseur()
    {
        $('.fournisseurs').on('change', function (e) {
                var valueSelected = this.value;
                console.log(valueSelected)
                if (valueSelected =="all") {
                    $('.fournisseur').show()
                    
                }else{
                    $('.fournisseur').hide()
                    $('.fournisseur-'+valueSelected).show()
                }                
        });
    }

            $(document).ready(function () {
                onChangefournisseur();
            });
        $(document).on("click", ".retour-modal", function () {
        var myCommandeId = $(this).attr('id');
        console.log(myCommandeId)
        $("#id_achat").val(myCommandeId);
        });



    </script>
@endsection
