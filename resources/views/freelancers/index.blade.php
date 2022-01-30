@extends('layouts.admin')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> liste des freelancers</h1>

                             <div class="card mb-4">

                            <div class="card-header">

                            <a class="btn btn-info" href="{{route('freelancer.show.create')}}">

                                    <i class="fas fa-plus"></i>

                                    Ajouter un freelancer

                                </a>



                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>

                                                <th>ID Commercial</th>

                                                <th>Nom et Prénom  </th>

                                                <th>N°Téléphone</th>

                                                <th>Email</th>

                                                <th>wilaya - commune</th>

                                                <th>actions</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @if(count($freelancers) > 0)

                                                @foreach($freelancers as $freelancer)                                            

                                                <tr>

                                                    <td>{{$freelancer->id ?? ''}}</td>

                                                        <td>{{$freelancer->nom_prenom ?? ''}}</td>

                                                    <td>{{$freelancer->telephone ?? ''}}</td>

                                                    <td>{{$freelancer->email ?? ''}}</td>

                                                    <td>{{$freelancer->grade ?? ''}}</td>


                                                    <td >

                                                        <div class="table-action">  

                                                        <a  

                                                        href="{{route('user.destroy',['id_user'=>$freelancer->id])}}"

                                                        onclick="return confirm('etes vous sure  ?')"

                                                        class="btn btn-danger">

                                                                <i class="fas fa-trash"></i> supprimer 

                                                        </a>

                                                        <a 

                                                        href="{{route('freelancer.edit',['id_freelancer'=>$freelancer->id])}}"

                                                        class="btn btn-info">

                                                                <i class="fas fa-edit"></i> Modifer 

                                                        </a>

                                                        </div>

                                                    </td>



                                                </tr>

                                                @endforeach

                                            

                                            @else

                                            <tr>

                                                <td colspan="7" class="text-center">

                                                <p>la liste des commerciaux est vide </p>



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