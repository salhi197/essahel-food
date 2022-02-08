@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord </h1>        
                           <div class="card mb-4">
                               <div class="card-header">
                                    Les Tickets : 
                                </div>

                               <div class="card-header">

                               <form method="post" action="{{route('ticket.filter.extra')}}">
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
                                                            <button type="submit" style="margin-top:9%;" class="form-control btn-sm btn btn-success">
                                                                Filtrer
                                                            </button>
                                                    </div>
                                            </form>
                                </div>







                            <div class="card-body">
                                <div class="table-responsive">
                                

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th style="cursor:pointer;">créé le</th>
                                                <th style="cursor:pointer;">Mis à jour le : </th>
                                                <th style="cursor:pointer;"> nom de produit</th>
                                                <th style="cursor:pointer;">code bar </th>
                                                <th style="cursor:pointer;">Staut </th>
                                                <th style="cursor:pointer;">N°ticket_produit </th>
                                            </tr>
                                        </thead>
                                        <tbody >
                                            @foreach($tickets as $ticket)
                                                <tr id="{{$ticket->id}}">
                                                    <td>{{date('d-m-Y h:m:s',strtotime($ticket->created_at))}}</td>
                                                    <td>{{date('d-m-Y h:m:s',strtotime($ticket->updated_at))}}</td>
                                                    <td>{{$ticket->nom ?? $ticket->getProduit()['nom']}}</td>
                                                    <td>{{$ticket->codebar ?? ''}}</td>
                                                    
                                                    <td style="color:rgb({!! ord($ticket->satut) !!},{!! (ord($ticket->satut)**2)%256 !!},{!! (ord($ticket->satut)**3)%256 !!});">

                                                        {!! $ticket->satut=='0' ? 'Vient d\'étre créé' : $ticket->satut !!}
                                                    </td>
                                                    
                                                    <td>{{$ticket->num_ticket_produit ?? ''}}</td>                                                
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
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

</script>
@endsection
@section('styles')
<style>
.tr-code{
    display:none;
}
</style>
@endsection
