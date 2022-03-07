@extends('layouts.ui')



@section('content')

    <h1 class="mt-2"> Impression des Tickets</h1>
        <div class="card mb-4">
            <div class="row">
                @foreach($produits as $produit)
                    <div class="col-md-4" style="margin-top: 2%;">
                        <div class="card">
                            <div class="card-header mx-4 p-3 text-center">
                                <div class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                    <i class="fas fa-drumstick-bite	 opacity-10" aria-hidden="true"></i>

                                </div>
                            </div>
                            <div class="card-body pt-0 p-3 text-center">
                                <h6 class="text-center mb-0">{{$produit->nom ?? ''}}/ {!! $produit->id_categorie ?? '' !!}</h6>
                                <span class="text-xs"></span>
                                <hr class="horizontal dark my-3">
                                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal{{$produit->id}}">
                                        Imprimer
                                    </button>
                            </div>
                        </div>
                    </div>
                
                    

                    <div class="modal fade" id="exampleModal{{$produit->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Imprimer Ticket {{ $produit->nom ?? '' }} :</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route('impression.tickets')}}">
                                    @csrf
                                    <input type="hidden" value="{{$produit->id}}" name="id_produit" />
                                    <div class="form-group">
    
                                        <label for="nombre">Nombre de tickets à imprimer :</label>
                                        <input type="number" id="nombre" value="" name="tickets" class="form-control nombre_ticket" placeholder="Nombre de ticket à imprimer ">
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button onclick="cacher(this)" type="submit" class="btn btn-primary">Imprimer</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>        
    </div>

    <script>
        
        function cacher(objet)
        {
            
            $(objet).hide(500,function(){ setTimeout( function(){$(objet).show(1000)} ,10000)});
            
        }
        
        
    </script>



@endsection

