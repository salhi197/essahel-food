@extends('layouts.master')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> Fournisseurs</h1>

                             <div class="card mb-4">
                                <div class="card-header">

                                    <a class="btn btn-info" href="{{route('fournisseur.show.create')}}">

                                    <i class="fas fa-plus"></i>

                                    Ajouter un fournisseur 

                                </a>



                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>

                                                <th>ID fournisseur</th>

                                                <th>Nom et Prénom  </th>

                                                <th>N°Téléphone</th>

                                                <th>Email</th>

                                                <th>Password</th>
                                                <th>confirmation telephonique</th>
                                                <th>gestion stock</th>

                                                <th>actions</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @if(count($fournisseurs) > 0)

                                                @foreach($fournisseurs as $fournisseur)                                            

                                                <tr>

                                                    <td>{{$fournisseur->id ?? ''}}</td>

                                                        <td>{{$fournisseur->nom_prenom ?? ''}}</td>

                                                    <td>
                                                    {{$fournisseur->telephone ?? ''}}
                                                    - 
                                                    {{$fournisseur->num_service ?? ''}}

                                                    </td>

                                                    <td>{{$fournisseur->email ?? ''}}</td>
                                                    <td style="text-transform: lowercase">{{$fournisseur->password_text ?? ''}}</td>

                                                    <td style="text-transform: lowercase">
                                                    @if($fournisseur->gestion_stock == 1)
                                                        Oui
                                                    @else
                                                        Non
                                                    @endif
                                                    </td>
                                                    <td style="text-transform: lowercase">
                                                    @if($fournisseur->confirmation_telephonique == 1)
                                                        Oui
                                                    @else
                                                        Non
                                                    @endif
                                                    </td>
                                                    
                                                    <td >

                                                        <div class="table-action">  

                                                            <a  

                                                            href="{{route('fournisseur.destroy',['id_fournisseur'=>$fournisseur->id])}}"

                                                            onclick="return confirm('etes vous sure  ?')"

                                                            class="btn btn-danger text-white">

                                                                    <i class="fas fa-trash"></i>  

                                                            </a>

                                                            <a 
                                                            href="{{route('fournisseur.edit',['fournisseur'=>$fournisseur])}}"
                                                            class="btn btn-info text-white">

                                                                    <i class="fas fa-edit"></i>  

                                                            </a>

                                                        </div>

                                                    </td>



                                                </tr>

                                                @endforeach

                                            

                                            @else

                                            <tr>

                                                <td colspan="7" class="text-center">

                                                <p>la liste des fournisseurs est vide </p>



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