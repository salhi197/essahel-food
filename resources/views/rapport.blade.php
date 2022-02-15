@extends('layouts.ui')

@section('content')

<div class="container-fluid">
    <h1 class="mt-4"> Rapport </h1>
    <div class="card mb-4">
       <div class="card-header">
            <form method="post" action="filter">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Date début : </label>
                            <input  class="form-control py-4"  
                            id="date_debut"  name="date_debut" type="date" value="{{date('Y-m-d')}}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1" for="inputEmailAddress">Date Fin : </label>
                            <input  class="form-control py-4"  
                            id="date_fin"  name="date_fin" type="date" value="{{date('Y-m-d')}}" />
                        </div>
                    </div>
                </div>  
            </form>
                                    
            <div class="row">
                    <div class="card col-md-3">
                        <h3>
                        Tickets Générés :
                        </h3>
                    </div>

                    <div class="card col-md-3">
                        <h3>
                        Tickets Vers Depot :
                        </h3>
                    </div>
                    <div class="card col-md-3">
                        <h3>
                        Tickets Au Depot :
                        </h3>
                    </div>
                    <div class="card col-md-3">
                        <h3>
                        Tickets Sortie :
                        </h3>
                    </div>

            </div>        

        
            <div class="row">
                @foreach($produits as $produit)
                    <div class="card col-md-3 " style="margin-top: 2%;">
                        <div class="card-body">
                            <h5 class="card-title">{{$produit->nom ?? ''}}</h5>
                            <p class="card-text text-center" id="produit_genere_{{$produit->id}}" >0</p>
                        </div>
                    </div>
                    <div class="card col-md-3 " style="margin-top: 2%;">
                        <div class="card-body">
                            <h5 class="card-title">{{$produit->nom ?? ''}}</h5>
                            <p class="card-text text-center" id="produit_vers_depot_{{$produit->id}}">0</p>
                        </div>
                    </div>
                    <div class="card col-md-3 " style="margin-top: 2%;">
                        <div class="card-body">
                            <h5 class="card-title">{{$produit->nom ?? ''}}</h5>
                            <p class="card-text text-center" id="produit_au_depot_{{$produit->id}}">0</p>
                        </div>
                    </div>
                    <div class="card col-md-3 " style="margin-top: 2%;">
                        <div class="card-body">
                            <h5 class="card-title">{{$produit->nom ?? ''}}</h5>
                            <p class="card-text text-center" id="produit_sortie_{{$produit->id}}">0</p>
                        </div>
                    </div>


                @endforeach
            </div>        
        </div>

        <div class="card-body">
            <div class="table-responsive">
            </div>
        </div>

    </div>

</div>




@endsection
@section('scripts')
<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    function getScannedTicket()
    {
      var date_debut = $('#date_debut').val();
      var date_fin = $('#date_fin').val();
      console.log(date_debut,date_fin)
      
      fetch('/get/scanned/tickets', {
        method: 'post', 
        headers: {
          'Accept': 'application/json, text/plain, */*',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          _token: CSRF_TOKEN,
          date_debut : date_debut,
          date_fin : date_fin        
        })  
      })
      .then(res => res.json())
        .then(res => {
          /** 
           * nbrTicketsGenerated
          */
          var nbrTicketsGenerated = res.nbrTicketsGenerated;
          nbrTicketsGenerated.map(obj=>{
            console.log(obj)
            $('#produit_genere_'+obj.id_produit).html(obj.nbrtickets).removeClass('alert alert-primary text-white').addClass('alert alert-primary text-white');
          })
          /** 
           * nbrTicketsVersDepot
          */
          var nbrTicketsVersDepot = res.nbrTicketsVersDepot;
          nbrTicketsVersDepot.map(obj=>{
            console.log(obj)
            $('#produit_vers_depot_'+obj.id_produit).html(obj.nbrtickets).removeClass('alert alert-primary text-white').addClass('alert alert-primary text-white');
          })
          /** 
           * nbrTicketsAUDepot
          */
          var nbrTicketsAuDepot = res.nbrTicketsAuDepot;
          nbrTicketsAuDepot.map(obj=>{
            console.log(obj)
            $('#produit_au_depot_'+obj.id_produit).html(obj.nbrtickets).removeClass('alert alert-primary text-white').addClass('alert alert-primary text-white');
          })

          /** 
           * nbrTicketsSortie
          */
          var nbrTicketsSortie = res.nbrTicketsSortie;
          nbrTicketsSortie.map(obj=>{
            console.log(obj)
            $('#produit_sortie_'+obj.id_produit).html(obj.nbrtickets).removeClass('alert alert-primary text-white').addClass('alert alert-primary text-white');
          })


          
        })
        .catch(err=>function (err) {
          console.log(err.message)
      });
    }
    $(document).ready(function () {
      setInterval(getScannedTicket,1000)
    });

</script>
@endsection

