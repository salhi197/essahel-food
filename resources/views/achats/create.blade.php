@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mt-2">
                                    <div class="card-header"><h3 class="font-weight-light my-4">nouveau commande : </h3></div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('achat.create')}}" enctype="multipart/form-data" id="Commandeform">
                                        @csrf
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
                                                        <input type="text" class="form-control" name="prix" id="prix" readonly="true" placeholder="Entere Quantité Produit ";>
                                                    </div>
                                                    <div class="button-group" style="padding: 27px;">
                                                        <a href="javascript:void(0)" class="btn btn-primary" id="plus5"><i class="fa fa-plus"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-danger" id="minus5"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">

                                            <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">date achat : </label>
                                                        <input  class="form-control py-4" id="telephpone" 
                                                         name="date_livraison" type="date" />
                                                    </div>
                                                </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                        <label class="small mb-1">choisir fournisseur:</label>
                                                        <select class="form-control" name="fournisseur">
                                                            @foreach($fournisseurs as $fournisseur)
                                                                <option value="{{$fournisseur}}">{{$fournisseur->nom_prenom ?? ''}}</option>
                                                            @endforeach
                                                        </select>

                                                    </div>


                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">Joindre fichier  : </label>
                                                        <input  class="form-file py-4"  
                                                         name="file" type="file" />
                                                    </div>
                                                </div>

                                                    </div>
                                                    <div class="col-md-3">
                                                    <label class="small mb-1" for="inputConfirmPassword">état avec le fournisser : </label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="state" id="payee" value="payee">
                                                            <label class="form-check-label" for="payee">
                                                                payé 
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="state" id="credit" value="credit">
                                                            <label class="form-check-label" for="credit">
                                                                crédit
                                                            </label>
                                                        </div>
                                                </div>


                                            </div>
                                            <div class="form-group mt-4 mb-0">
                                                <button class="btn btn-primary btn-block" type="submit">ajouter achat</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="modal fade" id="example" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ajouter fournisseur</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                        <div class="modal-body">
                                    <form id="form_fournisseur">
                                        <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">nom et prenom: </label>
                                                        <input type="text" name="nom_prenom"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="small mb-1" for="inputEmailAddress">N°Téléphone : </label>
                                                    <input  class="form-control" value="" name="telephone" type="text" placeholder="telephone" />
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">email</label>
                                                        <input  class="form-control py-4" name="email" id="email" type="email" placeholder="" />
                                                    </div>
                                                </div>

                                                    <div class="col-md-4">

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

                                                    </div>

                                                    <div class="col-md-4">

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

                                                    </div>

                                                    <div class="col-md-4">

                                                        <div class="form-group">

                                                        <label class="small mb-1" for="inputConfirmPassword">adress</label>

                                                        <input  class="form-control py-4" name="adress" id="adress" type="text" placeholder="" />

                                                        </div>

                                                    </div>



                                            </div>

                                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="button" id="ajax_fournisseur">ajouter fournisseur</button></div>

                                    </form>

                        </div>

                        </div>

                    </div>


@endsection

@section('scripts')
<script>
function onChangeProduit()
{
    $('.produits').on('change', function (e) {
        $('.produits').each(function(i, obj) {
            var valueSelected = this.value;
            var obj = JSON.parse(valueSelected);
            $('#fournisseur').val(obj.fournisseur)
            $('#prix'+i).val(obj.prix_fournisseur)        
            $('#quantite'+i).attr('max',obj.quantite)
            $('#quantite'+i).attr('min',0)
        });
    });
}

        $(document).ready(function () {
            onChangeProduit();
        });

</script>
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

        $(document).ready(function(){
            $("#ajax_fournisseur").click(function(){
                var data  = $('#form_fournisseur').serialize()
                console.log(data)
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    /* the route pointing to the post function */
                    url: '{{route("fournisseur.store.ajax")}}',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {_token: CSRF_TOKEN, data:data},
                    dataType: 'JSON',
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        $(function(){
                            console.log(data)
                            toastr.success(data.msg)
                            $("#fournisseurs").append(new Option(data.fournisseur.nom_prenom, data.fournisseur));
                            $('#example').modal('toggle');
                       })
                    },error: function(err){
                        $(function(){
                            console.log(err)
                            toastr.error(err.message)
                        })
                    }
                }); 
            });

       });    





    </script>


@endsection