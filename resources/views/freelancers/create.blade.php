@extends('layouts.admin')



@section('content')

<div class="container-fluid">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="card mt-2">

                                    <div class="card-header"><h3 class="font-weight-light my-4">nouveau Freelancer : tout les champs sont obligatoires  </h3></div>

                                    <div class="card-body">

                                        <form method="post" action="{{route('freelancer.create')}}">

                                        @csrf

                                            <div class="form-row">

                                                <div class="col-md-4">

                                                    <div class="form-group">

                                                        <label class="small mb-1" for="inputFirstName">nom et prenom: </label>

                                                        <input type="text" value="{{ old('nom_prenom') }}" name="nom_prenom"  class="form-control"/>

                                                    </div>

                                                </div>

                                                <div class="col-md-4">

                                                    <label class="small mb-1" for="inputEmailAddress">N°Téléphone : </label>

                                                    <input  class="form-control" id="quantite" value="" value="{{ old('telephone') }}" name="telephone" type="text" placeholder="telephone" />

                                                </div>

                                                <div class="col-md-4">

                                                    <label class="small mb-1" for="inputEmailAddress">pièce d'identité : </label>

                                                    <input  class="form-control-file"  name="identite" type="file" placeholder="telephone" />

                                                </div>

                                            </div>

                                            <div class="form-row">

                                            <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label class="small mb-1" >email</label>

                                                        <input  class="form-control py-4" value="{{ old('email') }}" name="email" id="email" type="email" placeholder="" />

                                                    </div>

                                                </div>

                                                <div class="col-md-6">

                                                    <div class="form-group">

                                                        <label class="small mb-1" for="inputConfirmPassword">mot de passe : </label>

                                                        <input  class="form-control py-4" value="{{ old('password') }}" name="password" id="email" type="text" placeholder="" />

                                                        <small>il doit etre transmis au Freelancer , NB:il peut etre changer </small>

                                                    </div>

                                                </div>






                                            </div>

                                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">ajouter Freelancer</button></div>

                                        </form>

                                    </div>

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