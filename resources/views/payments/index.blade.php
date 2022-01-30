@extends('layouts.admin')

@section('content')





                  <div class="container-fluid">
                      <?php $fournisseur= json_decode($achat->fournisseur);?>

                        <h1 class="mt-4"> Historique de Payment pour le fourisseur : 
                            {{$fournisseur->nom_prenom ?? ''}} 
                         </h1> 
                        <div class="row">

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Solde en cours </div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800">{{$payed}} DA </div>
                                </div>
                                <div class="col-auto">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-2 mb-4">
                          <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                              <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                  <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Solde</div>
                                  <div class="h5 mb-0 font-weight-bold text-gray-800"> {{$debt}} DA</div>
                                </div>
                                <div class="col-auto">
                                </div>
                              </div>
                            </div>
                          </div>
                          </div>
                        </div>


                           <div class="card mb-4">
                                <div class="card-header">
                                    @if(Auth::guard('admin')->user() != null)
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                            Ajouter Payment
                                        </button>

                                    @endif
                                </div>  
 
                      <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>
                                                <th>ID </th>
                                                <th>Quantité payés</th>

                                                <th>Montant</th>
                                                <th>Date de payment </th>
                                                <th>Commentaire </th>
                                                <th>Créer le</th>                                              
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @foreach($payments as $payment)                                            
                                            <tr class="">
                                                <td>{{$payment->id ?? ''}}</td>
                                                <?php 
                                                    $produit = json_decode($payment->produit, true);
                                                ?>
                                                <td width="20%">                                                 
                                                    <?php
                                                        $produits = json_decode($payment->quantite);
                                                        foreach($produits as $produit){
                                                            $produit = json_decode(json_encode($produit), true);

                                                                                                                    
                                                    ?>
                                                        <i class=" fas fa-box	"></i>  produit : 
                                                        {{str_limit($produit['nom'], $limit = 10, $end = '')}} => Qte 
                                                        {{$produit['quantite']}}
                                                        
                                                        <br>
                                                        <?php  } ?>
                                                 </td>


                                                <td>{{$payment->montant ?? ''}}   </td>
                                                <td width="20%">                                                 
                                                    {{$payment->date_payment}}
                                                 </td>
                                                 <td>{{$payment->commentaire ?? ''}}   </td>

                                                 <td>
                                                 {{$payment->created_at ?? 'non définie'}}
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
                                    <h5 class="modal-title" id="exampleModalLabel">Ajouter payment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <form action="{{route('payment.create')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                        <div class="form-group">
                                            <input type="hidden" class="form-control"  value="{{ $achat->id }}"  name="achat">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Montant payé:</label>
                                            <input type="text" value="{{ old('montant') }}" name="montant"
                                            class="form-control" id="" placeholder=" ">
                                        </div>
                                        <?php
                                                $produits = json_decode($achat->produits);
                                                foreach($produits as $produit){
                                                    $p = json_encode($produit);
                                                    $_produit = json_decode($p, true);                      
                                            ?>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Quantite payé dans le Produit {{$_produit['nom']}} :</label>
                                                <input type="number" max="{{$_produit['quantite']}}" value="0" name="quantites[]" class="form-control" id="" placeholder="">

                                            </div>
                                        <?php  } ?>


                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Commentaire :</label>
                                            <input type="text" value="{{ old('commnetaire') }}" name="commentaire"
                                            class="form-control" id="" placeholder="commnetaire : ">
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">date payment</label>
                                            <input type="date" name="date_payment" class="form-control" id="date_payment" placeholder="">
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button type="submit" id="saveImage" class="btn btn-primary" data-action="save" role="button">Save</button>
                                        </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>

@endsection



