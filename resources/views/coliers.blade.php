@extends('layouts.master')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> Fournisseurs</h1>

                             <div class="card mb-4">
                                <div class="card-header">

                                    <a class="btn btn-info" href="{{route('commande.show.create')}}">

                                    <i class="fas fa-box"></i>

                                    Nouveau

                                </a>



                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>

                                                <th>fournisseur</th>
                                                <th>Coliers</th>

                                                <th>actions</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @if(count($fournisseurs) > 0)

                                                @foreach($fournisseurs as $fournisseur)                                            

                                                <tr>


                                                    <td>{{$fournisseur->nom_prenom ?? ''}}</td>

                                                    <td>{{$fournisseur->NbrColiers() ?? ''}}</td>

                                                    <td >

                                                        <div class="table-action">  

                                                            <a  
                                                            href="{{route('fournisseur.coliers',['id_fournisseur'=>$fournisseur->id])}}"
                                                            class="btn btn-danger text-white">
                                                                <i class="fas fa-list"></i>
                                                                Voir la liste
                                                            </a>
                                                        </div>

                                                    </td>



                                                </tr>

                                                @endforeach

                                            

                                            @else

                                            <tr>

                                                <td colspan="7" class="text-center">

                                                <p>la liste des coliers est vide </p>



                                                </td>

                                            </tr>
                                            @endif
                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>



@endsection