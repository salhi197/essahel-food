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

                                            <th>wilaya - Commune</th>

                                            <th>Nombre de Course</th>

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

                                            <td>{{$livreur->getWilaya() ?? ''}} - {{$livreur->getCommune() ?? ''}}</td>

                                            <td>{{$livreur->NbrCourse() ?? ''}}</td>

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


                <div class="form-group">

                    <label class="control-label">{{ __('Wilaya') }}: </label>

                    <select class="form-control" id="wilaya_select" name="wilaya_id">

                        <option value="">{{ __('Please choose...') }}</option>

                        @foreach ($wilayas as $wilaya)

                            <option value="{{$wilaya->id}}" {{$wilaya->id == (old('wilaya_id') ?? ($member->wilaya_id ?? '')) ? 'selected' : ''}}>

                                {{$wilaya->name}}

                            </option>

                        @endforeach

                    </select>

                    @if ($errors->has('wilaya_id'))

                        <p class="help-block">{{ $errors->first('wilaya_id') }}</p>

                    @endif

            </div>

                    <div class="form-group">

                    <label class="control-label">{{ __('Commune') }}: </label>

                    <select class="form-control" name="commune_id" id="commune_select">

                        <option value="">{{ __('Please choose...') }}</option>

                        @foreach ($communes as $commune)

                            <option value="{{$commune->id}}" {{$commune->id == (old('commune_id') ?? ($member->commune_id ?? '')) ? 'selected' : ''}}>

                                {{$commune->name}}

                            </option>

                        @endforeach

                    </select>

                    <input class="form-control valid" id="commune_select_loading" value="{{ __('Loading...') }}"

                        readonly style="display: none;"/>

                    @if ($errors->has('commune_id'))

                        <p class="help-block">{{ $errors->first('commune_id') }}</p>

                    @endif

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

<script>

function watchWilayaChanges() {

            $('#wilaya_select').on('change', function (e) {

                e.preventDefault();

                var $communes = $('#commune_select');

                var $communesLoader = $('#commune_select_loading');

                var $iconLoader = $communes.parents('.input-group').find('.loader-spinner');

                var $iconDefault = $communes.parents('.input-group').find('.material-icons');

                $communes.hide().prop('disabled', 'disabled').find('option').not(':first').remove();

                $communesLoader.show();

                $iconDefault.hide();

                $iconLoader.show();

                $.ajax({

                    dataType: "json",

                    method: "GET",

                    url: "/api/static/communes/ " + $(this).val()

                })

                    .done(function (response) {

                        $.each(response, function (key, commune) {

                            $communes.append($('<option>', {value: commune.id}).text(commune.name));

                        });

                        $communes.prop('disabled', '').show();

                        $communesLoader.hide();

                        $iconLoader.hide();

                        $iconDefault.show();

                    });

            });

        }



        $(document).ready(function () {

            watchWilayaChanges();

        });

</script>

@endsection