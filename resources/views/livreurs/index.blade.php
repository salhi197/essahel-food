@extends('layouts.ui')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> Liste des Livreurs</h1>

                             <div class="card mb-4">

                            <div class="card-header">
                                <button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary center-block">Ajouter livreur</button>
                            </div>

                            <div class="card-body">

                                <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Livreur</th>

                                            <th>Nom et Prénom </th>

                                            <th>N°Téléphone</th>

                                            <th>Login</th>
                                            <th>Password</th>

                                            <th>actions</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($livreurs as $livreur)                                            

                                        <tr>

                                            <td>{{$livreur->id ?? ''}}</td>

                                            <td>{{$livreur->name ?? ''}} {{$livreur->prenom ?? ''}}</td>

                                            <td>{{$livreur->telephone ?? ''}}</td>

                                            <td>{{$livreur->email ?? ''}}</td>
                                            <td>{{$livreur->password_text ?? ''}}</td>



                                            <td >

                                                <div class="table-action">  

                                                <a  

                                                href="{{route('livreur.destroy',['id_livreur'=>$livreur->id])}}"

                                                onclick="return confirm('etes vous sure  ?')"

                                                class="text-white btn btn-danger">

                                                        <i class="fas fa-trash"></i>  

                                                </a>

                                                <a href="{{route('livreur.edit',['livreur'=>$livreur])}}"
                                                class="btn btn-info text-white">
                                                <i class="fas fa-edit"></i>  
                                                </a>


                                                @if($livreur->state)

                                                    <a class="text-white btn btn-primary" href="{{route('livreur.change.state',['id_livreur'=>$livreur->id])}}">

                                                        X 

                                                    </a>

                                                @else

                                                    <a class="text-white btn btn-primary" href="{{route('livreur.change.state',['id_livreur'=>$livreur->id])}}">

                                                        <i class="fas fa-edit"></i> débloquer 

                                                    </a>

                                                @endif

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





                    <div class="modal fade "  id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
<div class="modal-dialog modal-lg" >
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="lineModalLabel">Ajouter livreur</h3>
        </div>

    <div class="modal-body">
        <form action="{{route('livreur.create')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Login</label>
            <input type="text" value="{{ old('email') }}" name="email" class="form-control" id="exampleInputEmail1" placeholder="Entrer clé de Login ">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">mot de passe : </label>
            <input type="text" value="{{ old('password') }}" name="password" class="form-control" placeholder="  ">
        </div>





        <div class="form-group">
            <label for="exampleInputEmail1">nom  : </label>

            <input type="text" class="form-control"  value="{{ old('name') }}" name="name" id="nom" placeholder="votre nom ">

        </div>

        <div class="form-group">

            <label for="exampleInputEmail1">prenom  : </label>

            <input type="text" class="form-control"  value="{{ old('prenom') }}" name="prenom" id="prenom" placeholder="votre prenom ">

        </div>

        



        <div class="form-group">

            <label for="exampleInputEmail1">N Téléphone :</label>

            <input type="text" value="{{ old('telephone') }}" name="telephone" class="form-control" id="" placeholder="Enter votre numero de téléphone ">

        </div>





        <div class="form-group">

            <label for="exampleInputEmail1">Adress : </label>

            <input type="text" value="{{ old('adress') }}" name="adress" class="form-control" id="adress" placeholder="Enter votre adress : ">

        </div>






        <!-- <div class="form-group">

            <label for="exampleInputPassword1">date naissance</label>

            <input type="date" name="birth" class="form-control" id="birth" placeholder="">

        </div> -->

        <div class="btn-group" role="group">

                <button type="submit" class="btn btn-primary">Save</button>

            </div>
            <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Fermer</button>

        </form>



    </div>


</div>

</div>

</div>










@endsection






@section('scripts')


@endsection