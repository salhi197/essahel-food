@extends('layouts.master')

@section('content')
<div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mt-2">
                                    <div class="card-header"><h3 class="font-weight-light my-4">nouveau colis : </h3></div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('commande.create-for-fournisseur')}}" enctype="multipart/form-data" id="Commandeform">
                                        @csrf


                                            <input type="hidden" name="fournisseur" value="{{$fournisseur ?? ''}}" />
                                            <div class="form-group items" id="dynamic_form">
                                                <div class="row">
                                                <div class="button-group" style="padding: 27px;">
                                                        <a href="javascript:void(0)" class="btn btn-primary" id="plus5"><i class="fa fa-plus"></i></a>
                                                        <a href="javascript:void(0)" class="btn btn-danger" id="minus5"><i class="fa fa-minus"></i></a>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="small mb-1" for="inputFirstName">Produit: </label>
                                                        <select class='form-control produits' name='produit' id="produit" >
                                                            <option value="">Séléctionner un produit</option>
                                                            @foreach($produits as $produit)
                                                            <option class="product fournisseur_{{$produit->fournisseur_id ?? ''}}" value="{{$produit}}">
                                                            {{$produit->nom}} - quantité  : {{$produit->quantite}}  
                                                            </option>
                                                            @endforeach 
                                                        </select>   
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="small mb-1" for="inputEmailAddress">Quantité : </label>
                                                        <input type="number" class="form-control quantites" name="quantite" id="quantite" placeholder="Entere Quantité Produit ";>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="small mb-1" for="inputEmailAddress">Prix : </label>
                                                        <input type="number" class="form-control prixs" name="prix" id="prix" placeholder="Entere Quantité Produit ";>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-row">
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">nom et prenom</label>
                                                        <input  class="form-control py-4" name="nom_client" id="nom" type="text" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">Téléphone Client : </label>
                                                        <input  class="form-control py-4" id="telephpone" value="{{$comamnde->telephone ?? ''}}" name="telephone" type="text" placeholder="" />
                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">adress de livraison : </label>
                                                        <input  class="form-control py-4" name="adress" id="adress" type="text" placeholder="entrer l'adress complete  : " />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Code Tracking : </label>
                                                        <input  class="form-control py-4" name="code_tracking" 
                                                        value="{{$code}}"
                                                        readonly="true"
                                                        id="code_tracking" type="text" placeholder="code tracking ... " />
                                                    </div>
                                                </div>
                                                
                                                
                                                    <div class="col-md-3">
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
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">{{ __('Commune') }}: </label>
                                                            <input class="form-control " placeholder="Commune ..." name="commune" />
                                                        </div>
                                                    </div>
                                                    <!-- <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="small mb-1">choisir livreur:</label>
                                                            <select class="form-control" name="livreur" id="">
                                                            <option value="">
                                                                Séléctionner livreur
                                                            </option>                    

                                                            @foreach($livreurs as $livreur)
                                                                    <option value="{{$livreur}}" >
                                                                    {{$livreur->nom}} {{$livreur->prenom}}
                                                                    </option>                    
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
 -->

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="small mb-1">Type Livraison:</label>
                                                            <select class="form-control" name="type" id="">
                                                                <option value="nouveau" >Nouveau</option>                    
                                                                <option value="Echange" >Echange</option>                    
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                        <label class="small mb-1">autre Type :</label>
                                                            <select class="form-control" id="">
                                                                <option value="standard">standard</option>                    
                                                                <option value="offert">offert</option>                    
                                                            </select>
                                                        </div>
                                                    </div>



                                                    <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">note au livreur </label>
                                                        <textarea name="note" class="form-control">

                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                <table class="table table-condensed">
                                        
                                    </table>


                                                </div>

                                            </div>
                                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">Ajouter Commande</button></div>
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
                console.log('sasas')
                $.ajax({
                    dataType: "json",
                    method: "POST",
                    data:{action:'send-sms',api_key:'TyJdYcN1rIyLhYJDOYMq4HkvMQuvy43ID4QqLKvhuZM6KYog5ZGycNreAOIwpiMJ',to:'+213794498727',sms:'YourMessage'},
                    url: "https://sms-01.oksweb.com/api/v1/sms",
                    success:function(){
                            console.log('dz')
                    },
                    error:function(err){
                            console.log('rer')
                    }
                })
            });
        }
function co(text){
    console.log(text)
}
function onChangeProduit()
{
    
    $('.produits').on('change', function (e) {
        let pro = ''
        let produits = $('.produits')
        let prixs = $('.prixs')
        let quantities = $('.quantites')
        co("re")
        $('#_table').empty()

        $('.produits').each(function(i, obj) {
            var valueSelected = this.value;
            var obj = JSON.parse(valueSelected);
            console.log(valueSelected)
            var image = obj.image;
            let prix_vente = obj.prix_fournisseur 

            var elt = '<tr><td><img src="/storage/app/public/'+image+'" width="70px"/>'+obj.nom +'</td><td id=_prix'+i+'>'+prix_vente+'</td><td id=_quantite'+i+'>';
                elt+= '0</td><td id=_total'+i+'></td></tr>'
            $('#_table').prepend(elt)   
            pro = pro+'<br>'+'<img src="/storage/app/public/'+image+'" width="70px"/>'+obj.nom

            // $('#prix'+i).val(prix_vente)        
            // $('#quantite'+i).attr('max',obj.quantite)
            // $('#quantite'+i).attr('min',0)
        });
        setTimeout(function(){ 
            $('#_produit').html(pro)
        }, 1000);
        
    });

}
function onChangeQte()
{
    $('.quantites').on('change', function (e) {
        var valueSelected = this.value;
        $('#_'+this.id).html(valueSelected)
        co(this.id)

        var total = 0    
        var numItems = $('.produits').length
        for (let index = 0; index < numItems; index++) {
            var qte = parseInt($('#quantite'+index).val())
            var prix = parseInt($('#prix'+index).val())
            var countProduit = qte*prix
            $('#_total'+index).html(countProduit)
            total+=countProduit
        }
        $('#total').html(total)
        $('#prix_total_sans_livraison').val(total)
        $('#total_final').html(total)

    });


}
function onChangePrix()
{
    $('.prixs').on('change', function (e) {
        var valueSelected = this.value;
        $('#_'+this.id).html(valueSelected)

        var total = 0    
        var numItems = $('.produits').length
        for (let index = 0; index < numItems; index++) {
            var qte = parseInt($('#quantite'+index).val())
            var prix = parseInt($('#prix'+index).val())
            var countProduit = qte*prix
            $('#_total'+index).html(countProduit)

            total+=countProduit
        }
        $('#total').html(total)
        $('#prix_total_sans_livraison').val(total)
        $('#total_final').html(total)

    });


}

function onChangeLivraison()
{
    $('#type_livraison').on('change', function (e) {
        var valueSelected =$('.types option:selected').attr('id');
        var obj = JSON.parse(valueSelected);
        $('#_livraison').html(obj.label)        
    });
    $(".total").on("change", function() {
        var ret = parseInt($("#prix").val()) + parseInt($("#prix_livraison").val() || '0')
        $("#total").html(ret);
    })
}

function onTypeLivraison()
{
    $('.types').on('change', function (e) {
        var valueSelected =$('.types option:selected').attr('id');
        console.log(valueSelected)
        var obj = JSON.parse(valueSelected);
        $('#temps').val(obj.temps)
        $('#prix_livraison').val(obj.prix)        
        $('#comission').val(obj.comission)        
    });

}

function onChangePrixLivraison()
{
    $('#prix_livraison').on('change', function (e) {
        var valueSelected =this.value;//$('.types option:selected').attr('id');
        $('#livraison_row').html(valueSelected)
        var t = parseInt($('#total_final').html())
        t = t+parseInt(valueSelected)
        $('#total_final').html(t)

    });

}


function onChangeClient()
{
    $('.fournisseurs').on('change', function (e) {
        var valueSelected =$('.fournisseurs option:selected').val();
        var obj = JSON.parse(valueSelected);
        console.log(obj)
        $('.product').hide()
        $('.fournisseur_'+obj.id).show()
        
    });
}



        $(document).ready(function () {
            watchWilayaChanges();
            onChangeClient();
            onChangePrixLivraison();
            onChangeProduit();
            onChangeQte();
            onTypeLivraison();
            onChangeLivraison();
            onChangePrix();
        });

</script>
<script>
$(document).ready(function(){
    $("#ajax_type").click(function(){
        var data  = $('#form_type').serialize()
        console.log(data)
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            /* the route pointing to the post function */
            url: '{{route("type.store.ajax")}}',
            type: 'POST',
            /* send the csrf-token and the input to the controller */
            data: {_token: CSRF_TOKEN, data:data},
            dataType: 'JSON',
            /* remind that 'data' is the response of the AjaxController */
            success: function (data) { 
                $(function(){
                    console.log(data.type)
                    toastr.success(data.msg)
                        var obj = JSON.stringify(data.type)
                    $("#type_livraison").append(new Option(data.type.type,obj ));
                    $('#exampleModal').modal('toggle');
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