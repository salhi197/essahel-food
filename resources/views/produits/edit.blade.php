@extends('layouts.master')



@section('content')

<div class="container-fluid">

                        <div class="row">

                            <div class="col-lg-12">

                                <div class="card mt-2">

                                    <div class="card-header"><h3 class="font-weight-light my-4">Modifier Produit :  </h3></div>

                                    <div class="card-body">

                                        <form method="post" action="{{route('produit.update',['produit'=>$produit->id])}}" enctype="multipart/form-data">

                                        @csrf

                                            <div class="form-row">

                                                <div class="col-md-4">

                                                    <div class="form-group">

                                                        <label class="small mb-1" for="inputFirstName">nom de produit: </label>

                                                        <input type="text" value="{{ $produit->nom }}" name="nom"  class="form-control"/>

                                                    </div>

                                                </div>

                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <label class="small mb-1">catégorie de produit :</label>
                                                        <select class="form-control" name="categorie" id="categories">
                                                                <option value="general" selected>elctrotechnique</option>                    
                                                                <option value="general" selected>electoménager</option>                    
                                                                <option value="general" selected>téléphonie  & accesssoires</option>                    
                                                                <option value="general" selected>Maison & Bureau </option>                    
                                                                <option value="general" selected>Santé & Beauté</option>                    
                                                                <option value="general" selected>Articles & sport</option>                    
                                                                <option value="general" selected>Jouets & Jeux</option>                    
                                                                <option value="general" selected>Formations</option>                    
                                                        </select>

                                                    <a style="cursor:pointer;"  data-toggle="modal" data-target="#exampleModal">

                                                    ajouter catégorie

                                                    </a>
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Ajouter Catégorie</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                    <div class="form-row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="small mb-1" for="inputFirstName">Catégorie :  </label>
                                                                                    <input type="text" name="nom_prenom"  class="form-control" id="new_categorie" />
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="button" id="add_new_categorie">ajouter categorie</button></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    </div>

                                                </div>
                                                @auth('admin')
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1">choisir fournisseur :</label>
                                                        <select class="form-control" name="fournisseur" id="fournisseurs">
                                                            @foreach($fournisseurs as $fournisseur)
                                                                    <option value="{{$fournisseur}}" selected>{{$fournisseur->nom_prenom ?? ''}}</option>                    
                                                            @endforeach
                                                        </select>
                                                        <a type="button" class="" data-toggle="modal" data-target="#example">
                                                           ajouter fournisseur
                                                        </a>
                                                    </div>
                                                </div>
                                                @endif
                                                @auth('fournisseur')
                                                                @foreach($fournisseurs as $fournisseur)
                                                                        <?php if(Auth::guard('fournisseur')->id() == $fournisseur->id){?> 
                                                                            <input  type="hidden" class="form-control py-4" value="{{ $fournisseur }}" name="fournisseur" type="number"  />
                                                                         <?php } ?>
                                                            @endforeach
                                                @endif
                                                

                                                @auth('admin')
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="small mb-1" >quantite réçue :</label>
                                                            <input  class="form-control py-4" value="{{ $produit->quantite ?? 1 }}" name="quantite" id="" type="number" placeholder="" />
                                                        </div>
                                                    </div>
                                                @endif


                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">prix  : </label>
                                                        <input  class="form-control py-4" value="{{ $produit->prix_fournisseur }}" name="prix_fournisseur" type="text" placeholder="" />
                                                    </div>
                                                </div> -->


                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">description de produit </label>
                                                        <textarea name="description" class="form-control">
                                                                            {{$produit->description ?? ''}}
                                                        </textarea>  
                                                    </div>
                                                </div>

                                                <div class="col-md-4">

                                                    <label class="small mb-1" for="inputEmailAddress">image: </label>

                                                    <input  class="form-control-file" name="image" type="file" placeholder="telephone" />

                                                </div>



                                            </div>


                                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">ajouter </button></div>

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
                                                        <label class="small mb-1" for="inputConfirmPassword">Login</label>
                                                        <input  class="form-control py-4" name="email" id="email" type="text" placeholder="" />
                                                    </div>
                                                </div>

                                                    <div class="col-md-4">

                                                        <div class="form-group">

                                                            <label class="control-label">{{ __('Wilaya') }}: </label>

                                                            <select class="form-control" id="wilaya_select" name="wilaya_id">

                                                                <option value="">{{ __('Please choose...') }}</option>

                                                                @foreach ($wilayas as $wilaya)

                                                                    <option value="{{$wilaya->id}}" {{$wilaya->id == ($produit->wilaya_id ?? ($member->wilaya_id ?? '')) ? 'selected' : ''}}>

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

                                                                    <option value="{{$commune->id}}" {{$commune->id == ($produit->commune_id ?? ($member->commune_id ?? '')) ? 'selected' : ''}}>

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

                    </div>









@endsection





@section('scripts')

<script>

$(document).ready(function() { 
    $('.variant').hide()

    $('#type_produit').on('change', function (e) {
        var valueSelected = this.value;
        console.log(valueSelected)
        if (valueSelected == 'standard') {
            $('.variant').hide()
        }else{
            $('.variant').show()
        }
    });


  $('#add_new_categorie').click(function() {

      var v = $('#new_categorie').val()

        if(v.length>0){

            $('#categories').append(new Option(v, v));

            $("#categories").val(v);



        }

        $('#exampleModal').modal('toggle');



  });

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

