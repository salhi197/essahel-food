@extends('layouts.master')



@section('content')

<div class="container-fluid">

    <h1 class="mt-4"> Fournisseurs</h1>

    <div class="card mb-4">
        <div class="card-header">
            <div class="row">
                @foreach(['kabab','vh','chawarma'] as $type)
                    <div class="card col-md-4" style="">
                        <div class="card-body">
                            <h5 class="card-title">{{$type}}</h5>
                            <p class="card-text">Clicker sur le button.</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$type}}">
                                Imprimer
                            </button>
                        </div>
                    </div>

                    


                    <div class="modal fade" id="exampleModal{{$type}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Imprimer Ticket {{ $type }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="{{route('impression.tickets')}}">
                                    @csrf
                                    <input type="hidden" value="{{$type}}" name="type" />
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nombre de ticket à imprimer :</label>
                                        <input type="text" value="" name="tickets" class="form-control nombre_ticket" placeholder="Nombre de ticket à imprimer ">
                                    </div>
                                    <div class="btn-group" role="group">
                                        <button type="submit" class="btn btn-primary">Imprimer</button>
                                    </div>
                                </form>
                            </div>
                            </div>
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

