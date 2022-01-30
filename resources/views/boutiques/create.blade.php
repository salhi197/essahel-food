@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mt-2">
                                    <div class="card-header"><h3 class="font-weight-light my-4">nouveau boutique: </h3></div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('boutique.create')}}" enctype="multipart/form-data">
                                        @csrf

                                            <div class="form-row">
                                            <div class="col-md-6">
                                                    <label class="small mb-1" for=" inputEmailAddress">Nom: </label>
                                                    <input  class="form-control" id="name" value="{{$boutique->name ?? ''}}" name="name" type="text" placeholder="" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputEmailAddress">email : </label>
                                                    <input  class="form-control" id="email" value="{{$boutique->email ?? ''}}" name="email" type="email" placeholder="" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="small mb-1" for="inputEmailAddress">password : </label>
                                                    <input  class="form-control" id="password" value="{{$boutique->password ?? ''}}" name="password" type="text" placeholder="" />
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="small mb-1" for="inputEmailAddress">téléphone : </label>
                                                    <input  class="form-control" id="telephone" value="{{$boutique->telephone ?? ''}}" name="telephone" type="text" placeholder="" />
                                                </div>

                                                <div class="col-md-4">
                                                    <label class="small mb-1" for="inputEmailAddress"> Adress : </label>
                                                    <input  class="form-control" id="adress" value="{{$boutique->adress ?? ''}}" name="adress" type="text" placeholder="" />
                                                </div>

                                            </div>


                                            <div class="form-group" id="dynamic_form">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label class="small mb-1" for="inputFirstName">Produit: </label>
                                                        <select class='form-control produits' name='produit' id="produit" >
                                                            <option>veuillez séélctionner </option>
                                                            @foreach($produits as $produit)
                                                            <option value="{{$produit}}">
                                                                {{$produit->nom}} - quantite : {{$produit->quantite}}
                                                            </option>
                                                            @endforeach 
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="small mb-1" for="inputEmailAddress">Quantité : </label>
                                                        <input type="text" class="form-control" name="quantite" id="quantite" placeholder="Entere Quantité Produit ";>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="small mb-1" for="inputEmailAddress">Prix : </label>
                                                        <input type="text" class="form-control" name="prix" id="prix" placeholder="Entere le prix pour boutique: ">
                                                    </div>
                                                    <div class="button-group" style="padding: 27px;">
                                                        <a href="javascript:void(0)" class="btn btn-primary" id="plus5"><i class="fa fa-plus"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-danger" id="minus5"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                </div>
                                            </div>




                                                <div class="form-group mt-4 mb-0">
                                                    <button class="btn btn-primary btn-block" type="submit">ajouter au boutique</button>
                                                </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


@endsection

@section('scripts')
<script>
        $(document).ready(function() {
        	var dynamic_form =  $("#dynamic_form").dynamicForm("#dynamic_form","#plus5", "#minus5", {
		        limit:10,
		        formPrefix : "dynamic_form",
		        normalizeFullForm : false
		    });


		    $("#dynamic_form #minus5").on('click', function(){
		    	var initDynamicId = $(this).closest('#dynamic_form').parent().find("[id^='dynamic_form']").length;
		    	if (initDynamicId === 2) {
		    		$(this).closest('#dynamic_form').next().find('#minus5').hide();
		    	}
		    	$(this).closest('#dynamic_form').remove();
		    });

		    $('#Commandeform').on('submit', function(event){
	        	var values = {};
				$.each($('#Commandeform').serializeArray(), function(i, field) {
				    values[field.name] = field.value;
				});
				console.log(values)
        	})
        });
    </script>


@endsection
