@extends('layouts.admin')



@section('content')

<div class="container">
  <div class="row">
    <div class="col-12 col-offset-2">
      <div class="card mt-3 tab-card">
        <div class="card-header tab-card-header">
          <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">Commande reçue !</a>
            </li>
          </ul>
        </div>

        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
          <div class="row">

          <div class="col-4">
              <h5 class="card-title">comande N : {{$commande->id}}</h5>
          <p class="card-text">
          <i class="fa fa-user" style="color:green"></i>
          <i class="fa fa-volume-up" style="color:green"></i>
          {{$commande->prix_livraison}} DA 
        </p>
        <p class="card-text">
               {{$commande->getWilaya() ?? 'non définie'}} - {{$commande->getCommune() ?? 'non définie'}}
            </p>
            <p class="card-text">
               {{$commande->created_at ?? ''}}
            </p>
            <p class="card-text">
               Produit :
            </p>

              
              </div>
              
              
              <div class="col-8">
              <table class="table">
  <tbody>
                                                <?php
                                                    $produit = json_decode($commande->produit); 
                                                ?>


                                                    <br>

    <tr>
      <td><i class="fa fa-box"></i> {{$produit->nom ?? 'non définie'}}</td>
      <td><i class="fa fa-money"></i>quantité :   {{$commande->quantite ?? 'non définie'}}</td>
      <td><i class="fa fa-money"></i>prix:{{$commande->prix}}</td>
    </tr>
    <tr>
      <td>1*</td>
      <td>livraison : {{$commande->command_express}}</td>
      <td>{{$commande->prix_livraison}}</td>
    </tr>
    <tr>
      <td colspan="3" class="text-right">
      prix total: <strong style="color:green;">{{$commande->prix + $commande->prix_livraison}}</strong>  
      DA</td>
    </tr>

</tbody>
</table>

              
</div>
</div>


<br>
            <a href="{{route('commande.accepter',['id_comamnde'=>$commande->id])}}" class="btn btn-primary">Accepter</a>              
            <a href="{{route('livreur.index')}}" class="btn btn-danger">Rejeter</a>              
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