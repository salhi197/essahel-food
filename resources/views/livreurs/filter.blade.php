@extends('layouts.ui')

@section('content')




  <div class="container-fluid">
                                    <div class="card-header">
                                        <h4>
                                            Les Tickets de Livreur : {{$livreur->name ?? ''}} {{$livreur->prenom ?? ''}}
                                        </h4>
                                    </div>

                           <div class="card mb-4">
                                     <div class="card-header">
                                         <form method="post" action="{{route('ticket.filter.livreur',['livreur'=>$livreur->id])}}">
                                            @csrf
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputEmailAddress">date début : </label>
                                                            <input  class="form-control py-4" id="telephpone"
                                                             name="date_debut" value="{{$date_debut}}"
                                                             type="date" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="small mb-1" for="inputEmailAddress">date fin: </label>
                                                            <input  class="form-control py-4" id="telephpone"
                                                             name="date_fin" value="{{$date_fin}}"
                                                             type="date" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <button type="submit" style="margin-top:9%;" class="form-control btn btn-info">
                                                                Filtrer
                                                            </button>
                                                        </div>
                                                    </div>


                                            </form>


                                                    <div class="col-md-12" style="padding-top:3%;">
                                                        <a class="btn btn-success col-md-4" href="{{route('ticket.affecter',['livreur'=>$livreur])}}">
                                                            Affecter Colis
                                                        </a>
                                                        <a class="btn btn-warning col-md-4" href="{{route('ticket.detacher',['livreur'=>$livreur])}}">
                                                            Détacher Colis
                                                        </a>
                                                        <a class="btn btn-danger col-md-3" href="{{route('ticket.retour',['livreur'=>$livreur])}}">
                                                            Retour
                                                        </a>
                                                        <button id="btnPrint" style="display: block; margin-left: auto; margin-right: auto; width: 50%;" class="btn btn-outline-info  text-center col-md-6" >
                                                            Imprimer
                                                        </button>

                                                    </div>
                                                </div>
                                </div>





                            <div class="card-body">
                                
                                <div class="table-responsive">                               
                                    <table class="table table-bordered" id="dataTable001" width="100%" cellspacing="0">
                                        
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="cursor:pointer;">Id_Livreur</th>
                                                <th class="text-center" style="cursor:pointer;">Prénom</th>
                                                <th class="text-center" style="cursor:pointer;">Produit</th>
                                                <th class="text-center" style="cursor:pointer;">Quantité</th>
                                                <th class="text-center" style="cursor:pointer;">D-F</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>

                                            @foreach($produits_qte as $produit_qte)
                                                <tr>
                                                    <td class="text-center">{{ $produit_qte->id ?? '' }}</td>
                                                    <td class="text-center">{{ $produit_qte->prenom ?? '' }}</td>
                                                    <td class="text-center">{{ $produit_qte->nom ?? ''}}</td>
                                                    <td class="text-center">{{ $produit_qte->nb_ticket ?? ''}}</td>
                                                    <td class="text-center">{{ $date_debut ?? ''}} | {{ $date_fin ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                    <br>

                                </div>

                                
                                <div class="table-responsive">                               
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="cursor:pointer;">date Création</th>
                                                <th class="text-center" style="cursor:pointer;">date Affectation</th>
                                                <th class="text-center" style="cursor:pointer;">Id</th>
                                                <th class="text-center" style="cursor:pointer;">Nom Produit</th>
                                                <th class="text-center" style="cursor:pointer;">Code bare</th>
                                                <th class="text-center" style="cursor:pointer;">Statut </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($tickets as $ticket)
                                                <tr>
                                                    <td class="text-center">{{ $ticket->created_at ?? '' }}</td>
                                                    <td class="text-center">{{ $ticket->updated_at ?? '' }}</td>
                                                    <td class="text-center">{{$ticket->id ?? ''}}</td>
                                                    <td class="text-center">{{App\Produit::getNomProduit($ticket->id_produit) ?? ''}}</td>
                                                    <td class="text-center">{{$ticket->codebar ?? ''}}</td>
                                                    <td class="text-center">{{--($ticket->satut=='0') ? 'Vient d\'étre créé' : $ticket->satut--}} Sortie </td>
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
        $(document).ready(function (e){   
            $("#btnPrint").on('click',function(e){
                e.preventDefault()
                console.log('sa')
                $('#dataTable001').printThis();
            })
        });
</script>
@endsection