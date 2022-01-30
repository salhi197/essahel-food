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
                                <a class="nav-link" id="three-tab" data-toggle="tab" href="#three" role="tab" aria-controls="Three" aria-selected="false">Stock Détail!</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active p-3" id="one" role="tabpanel" aria-labelledby="one-tab">
                            <div class="row">



                                <div class="col-12">
                                    <p class="card-text">
                                        Stock <span class="badge badge-info">{{$stock->operation}} </span> :
                                    le : {{$stock->created_at}}
                                    </p>


                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td><i class="fa fa-box"></i> {{$produit['nom'] ?? 'non définie'}}</td>
                                            <td><i class="fa fa-money"></i>quantité :   {{$produit['quantite'] ?? 'non définie'}}</td>
                                            <td class="text-right"><i class="fa fa-money"></i>
                                                <span class="badge badge-info">{{$stock->operation}} </span>     
                                            </td>
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