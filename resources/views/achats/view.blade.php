@extends('layouts.admin')



@section('content')
<?php $total_produit = 0;$total= 0;?>
    <div class="container">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="invoice-title">
                            <h2></h2><h3 class="pull-right">Facture : {{$achat->id}}</h3>
                        </div>
                        <hr>
                       
                        <div class="row">
                            <div class="col-xs-6 text-right">
                                <?php
                                    $fournisseur= json_decode($achat->fournisseur);
                                ?>

                                <address>
                                    <strong>Fournisseur :
                                    
                                     {{$fournisseur->nom_prenom ?? ''}} - {{$fournisseur->telephone ?? ''}}  

                                    </strong><br>
                                    {{$achat->created_at}}<br><br>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row" id="commande">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <td><strong>element</strong></td>
                                                <td class="text-center"><strong>prix</strong></td>
                                                <td class="text-center"><strong>Quantité</strong></td>
                                                <td class="text-right"><strong>Totals</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $produits = json_decode($achat->produits);
                                            foreach($produits as $produit){
                                                $produit = json_decode(json_encode($produit), true);
                                            ?>     
                                            <?php $total_produit = $produit['quantite']*$produit['prix_vente'];
                                            $total = $total + $total_produit;
                                            ?>

                                            <tr>
                                                <td>{{$produit['nom'] ?? 'non définie'}}</td>
                                                <td class="text-center">{{$produit['prix_vente'] ?? 'non définie'}}</td>
                                                <td class="text-center">{{$produit['quantite'] ?? 'non définie'}}</td>
                                                <td class="text-right">{{ $total_produit }}</td>
                                            </tr>
                                            <?php  } ?>
                                            <tr>
                                                <td class="thick-line"></td>
                                                <td class="thick-line"></td>
                                                <td class="thick-line text-center"><strong>Total </strong></td>
                                                <td class="thick-line text-right">{{$total}} DA</td>
                                            </tr>
                                            <tr>
                                                <td class="no-line"></td>
                                                <td class="no-line"></td>
                                                <td class="no-line text-center"><strong>Total final </strong></td>
                                                <td class="no-line text-right">{{$total}} DA</td>
                                            </tr>
                                        </tbody>
                                    </table>
                <div class="invoice-title">
                            <h2></h2><h3 class="pull-right">Historique de payments</h3>
                        </div>
                        <hr>
 
                                    <table class="table table-condensed">
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


                                            <tr>
                                                <td class="thick-line text-center"><strong>Total payé</strong></td>
                                                <td class="thick-line text-right">{{$payed}} DA</td>
                                            </tr>
                                            <tr>
                                                <td class="no-line text-center"><strong>Total A payé</strong></td>
                                                <td class="no-line text-right">{{$debt}} DA</td>
                                            </tr>
                                        </tbody>
                                    </table>



                                    <button class="btn btn-success" id="print">
                                        Imprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>


@endsection


@section('scripts')
    <script>
        $('#print').on("click", function () {
            console.log('sa')
            $('#commande').printThis({
                base: "https://jasonday.github.io/printThis/"
            });
        });
    </script>


@endsection