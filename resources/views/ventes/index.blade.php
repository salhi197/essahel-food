@extends('layouts.admin')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4">Tables de Achat</h1>

                             <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-primary" href="{{route('produit.create')}}">Nouvelle Achat</a>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>

                                                <th>ID produit</th>

                                                <th>Nom produit </th>


                                                <th>prix achat </th>

                                                <th>prix vente </th>

                                                <th>qunatité-stock</th>

                                                <th>marge bénéficiare clicNtic</th>

                                                <th>marge bénéficiare freelance</th>
                                                <th>marge bénéficiare commercial </th>

                                                <th>actions</th>

                                                

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @foreach($produits as $produit)                                            

                                            <tr>

                                                <td>{{$produit->id ?? ''}}</td>

                                                <td> <i class=" fas fa-box	"></i> {{$produit->nom ?? ''}}</td>

                                                <td>{{$produit->prix_fournisseur ?? ''}} DA</td>
                                                <td>{{$produit->prix_vente ?? ''}} DA</td>


                                                <td>{{$produit->prix_vente-$produit->prix_fournisseur}} DA</td>




                                                <td>{{$produit->quantite ?? ''}} DA</td>

                                                <td>{{$produit->prix_freelance ?? ''}} DA</td>

                                                <td>{{$produit->prix_clicntic ?? ''}} DA</td>

                                                <td >

                                                    <div class="table-action">  

                                                    <a  

                                                    href="{{route('produit.destroy',['id_produit'=>$produit->id])}}"

                                                    onclick="return confirm('etes vous sure  ?')"

                                                    class="text-white btn btn-danger">

                                                            <i class="fas fa-trash"></i> Supprimer 

                                                    </a>

                                                    <a 

                                                    href="{{route('produit.edit',['id_produit'=>$produit->id])}}"

                                                     class="text-white btn btn-info">

                                                            <i class="fas fa-edit"></i> Modifer 

                                                    </a>

                                                    <a 

                                                    href="{{route('produit.show',['id_produit'=>$produit->id])}}"

                                                     class="text-white btn btn-primary">

                                                            <i class="fas fa-eye"></i> bon réception 

                                                    </a>

                                                    </div>

                                                </td>



                                            </tr>

           

                                            @endforeach





                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>





@endsection

