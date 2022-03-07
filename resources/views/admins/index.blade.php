@extends('layouts.ui')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> liste des Personnels</h1>

                             <div class="card mb-4">

                            <div class="card-header">

                            <a class="btn btn-info" href="{{route('admin.show.create')}}">

                                    <i class="fas fa-plus"></i>

                                    Ajouter 

                                </a>



                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>
                                                <th>ID Commercial</th>
                                                <th>Nom et Prénom  </th>
                                                <th>Login</th>
                                                <th>mot de passe</th>
                                                <th>actions</th>
                                            </tr>

                                        </thead>

                                        <tbody>

                                            @if(count($admins) > 0)

                                                @foreach($admins as $admin)                                            

                                                <tr>

                                                    <td>{{$admin->id ?? ''}}</td>

                                                    <td>{{$admin->name ?? ''}}</td>
                                                    <td>{{$admin->email ?? ''}}</td>

                                                    <td>{{$admin->password_text ?? ''}}</td>




                                                    <td >

                                                        <div class="table-action">  

                                                        <a  

                                                        href="{{route('admin.destroy',['id_admin'=>$admin->id])}}"

                                                        onclick="return confirm('etes vous sure  ?')"

                                                        class="btn btn-danger">

                                                                <i class="fas fa-trash"></i> supprimer 

                                                        </a>

                                                        <a 

                                                        href="{{route('admin.edit',['id_admin'=>$admin->id])}}"

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

                                                <p>la liste des admins est vide </p>



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