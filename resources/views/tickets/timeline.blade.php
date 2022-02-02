@extends('layouts.master')



@section('content')
<?php $total_produit = 0;$total= 0;?>
    <div class="container">
        <div class="row">
            <div class="col-12 col-offset-2">
                <div class="card mt-3 tab-card">
                    <div class="card-header tab-card-header">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">Historique : </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Etat</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Acteur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>en prépartion</td>
                                                <td>
                                                    {{$commande->en_preparation ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>en cours</td>
                                                <td>
                                                    {{$commande->en_cours ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>Sortie</td>
                                                <td>
                                                    {{$commande->sortie ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr><td>
                                                  Annule                                                    
                                                </td>
                                                <td>
                                                    {{$commande->annule ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    reporte                                           
                                                </td>
                                                <td>
                                                    {{$commande->reporte ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>ne repodn pas</td>
                                                <td>
                                                    {{$commande->ne_reponds_pas ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>non abouti</td>
                                                <td>
                                                    {{$commande->non_abouti ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>
                                            <tr>
                                                <td>livree</td>
                                                <td>
                                                    {{$commande->livree ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>

                                            <tr>
                                                <td>retour ls</td>
                                                <td>
                                                    {{$commande->retour ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>

                                            <tr>
                                                <td>retour client</td>
                                                <td>
                                                    {{$commande->retour ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>

                                        </tbody>



                                    </table>

                                </div>
                            </div>


                            <br>
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