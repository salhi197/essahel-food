@extends('layouts.ui')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> Agents Productions</h1>

                             <div class="card mb-4">

                             <div class="card-header">
                                <button data-toggle="modal" data-target="#squarespaceModal" class="btn btn-primary center-block">
                                    Ajouter Agent de Production
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID production</th>
                                            <th>Login</th>
                                            <th>Password</th>
                                            <th>actions</th>
                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach($productions as $production)
                                            <tr>
                                                <td>{{$production->id}}</td>
                                                <td>{{$production->name ?? ''}}</td>
                                                <td>{{$production->password_text?? ''}}</td>
                                                <td>
                                                    <div class="table-action">
                                                        <a  href="{{route('production.destroy',['production'=>$production->id])}}"
                                                            onclick="return confirm('etes vous sure  ?')"
                                                            class="btn btn-danger text-white"><i class="fa fa-trash"></i> &nbsp; </a>




                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$production->id}}">
                                                            <i class="fa fa-plus"></i> Modifier
                                                        </button>
                                                            <div class="modal fade" id="exampleModal{{$production->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Modifier Agent Production</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form action="{{route('production.update',['production'=>$production->id])}}" method="post" enctype="multipart/form-data">
                                                                            @csrf
                                                                            <div class="form-group">
                                                                                <label for="exampleInputEmail1">Nom </label>
                                                                                <input type="text" value="{{ $production->name ?? '' }}" name="name" class="form-control"
                                                                                       id="exampleInputEmail1" placeholder=" ">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="exampleInputEmail1">Login </label>
                                                                                <input type="text" value="{{ $production->email ?? '' }}" name="email" class="form-control"
                                                                                       id="exampleInputEmail1" placeholder=" ">
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <label for="exampleInputEmail1">Password </label>
                                                                                <input type="text" value="{{ $production->password_text ?? '' }}" name="password" class="form-control"
                                                                                       id="exampleInputEmail1" placeholder=" ">
                                                                            </div>

                                                                            <div class="btn-group" role="group">
                                                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                                            </div>
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Fermer</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

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





<div class="modal fade " id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Ajouter Agent de production : </h3>
            </div>
            <div class="modal-body">
                <form action="{{route('production.create')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nom </label>
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                            id="exampleInputEmail1" placeholder=" ">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Login </label>
                        <input type="text" value="{{ old('email') }}" name="email" class="form-control"
                            id="exampleInputEmail1" placeholder=" ">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Password </label>
                        <input type="text" value="{{ old('password') }}" name="password" class="form-control"
                            id="exampleInputEmail1" placeholder=" ">
                    </div>

                    <div class="btn-group" role="group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" role="button">Fermer</button>
                </form>
            </div>
        </div>
    </div>
</div>









@endsection





