@extends('layouts.master')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"></h1>

                       <div class="card mb-4">

                            <div class="card-header">

                                <p>

                                
                                </p>
                                <a class="btn btn-info" href="">

                                    <i class="fas fa-plus"></i>
                                    Add nouvelle Commande

                                </a>



                            </div>

                            <div class="card-body">

                            <form method="post" action="{{route('commande.search')}}">
                                        @csrf
                                            <div class="form-row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">Code Tracking : </label>
                                                        <input  class="form-control py-4" id="code_tracking" 
                                                         name="code_tracking" type="text" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">date de : </label>
                                                        <input  class="form-control py-4" id="telephpone" 
                                                         name="date_debut" type="date" />
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputEmailAddress">dataà: </label>
                                                        <input  class="form-control py-4" id="telephpone" 
                                                         name="date_fin" type="date" />
                                                    </div>
                                                </div>

                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">{{ __('Client') }}: </label>
                                                            <select class=" form-control" name="fournisseur">
                                                                <option value="">{{ __('Please choose...') }}</option>
                                                                @foreach ($fournisseurs as $fournisseur)
                                                                    <option value="{{$fournisseur->id}}"
                                                                    <?php if($fournisseur->id == $fournisseur_id) echo "selected"; ?>
                                                                    >
                                                                        {{$fournisseur->nom_prenom}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-2">
                                                            <label class="control-label">{{ __('Tous') }}:</label>
                                                            <select class="form-control tous" id="tous" name="state">
                                                                    <option value="">Tous les états</option>
                                                                    <option value="confirmer">Confirmé</option>
                                                                    <option value="ne_reponds_pas">Ne repond pas</option>
                                                                    <option value="annule">Annule</option>
                                                                    <option value="en_preparation">en préparation</option>
                                                                    <option value="reporte">Reporté</option>
                                                                    <option value="livree">livree</option>
                                                            </select>
                                                    </div>


                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <label class="control-label">{{ __('Livreur') }}: </label>
                                                            <select class=" form-control" >
                                                                <option value="">{{ __('Choisir Livreur ...') }}</option>
                                                                @foreach ($livreurs as $livreur)
                                                                    <option value="{{$livreur->id}}" {{$livreur->id == (old('livreur_id') ?? ($member->livreur_id ?? '')) ? 'selected' : 'non définie'}}>
                                                                        {{$livreur->name ?? ''}} {{$livreur->prenom ?? ''}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    


                                                    <div class="col-md-2">
                                                            <label class="control-label">{{ __('Wilaya') }}: </label>
                                                            <select class="form-control" id="wilaya_select" name="wilaya_id">
                                                                <option value="">{{ __('Please choose...') }}</option>
                                                                @foreach ($wilayas as $wilaya)
                                                                    <option value="{{$wilaya->id}}" {{$wilaya->id == (old('wilaya_id') ?? ($member->wilaya_id ?? '')) ? 'selected' : 'non définie'}}>
                                                                        {{$wilaya->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if ($errors->has('wilaya_id'))
                                                                <p class="help-block">{{ $errors->first('wilaya_id') }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button class="btn btn-info btn-block" type="submit">
                                                        checher 
                                                        </button>
                                                    </div>



                                                <!-- <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">nom et prenom</label>
                                                        <input  class="form-control py-4" name="nom_client" id="nom" type="text" placeholder="enter surname : " />
                                                    </div> 
                                                </div>

 -->
                                            </div>
                                            <div class="row">
                                        </form>


                                <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                              <th>date</th>
                                              <th>client</th>
                                              <th>Tracking</th>
                                              <th>Consomateur</th>
                                                <th>produit</th>
                                                <th>wilaya</th>
                                                <th>Livreur</th>
                                                <th>Etat</th>
                                                <th>actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($commandes->reverse() as $commande)
                                            <tr>
                                                <td>
                                                    {{ Carbon\Carbon::parse($commande->created_at)->format('Y-m-d') }}<br>

                                                </td>
                                                <td >                                                 
                                                    <?php
                                                        $fournisseur = json_decode($commande->fournisseur); 
                                                    ?>
                                                    {{$fournisseur->nom_prenom ?? ''}}

                                                    
                                                </td>

                                                 <td>                                                 
                                                 {{$commande->code_tracking ?? ''}}
                                                
                                                </td>


                                                <td >             
                                                    {{$commande->nom_client ?? 'non définie'}}<br>
                                                    {{$commande->telephone ?? 'non définie'}}<br>
                                                 </td>


                                                 <td >                                                 
                                                 <?php
                                                    $total_produit = 0;$total= 0;
                                                    $produits = json_decode($commande->produit);
                                                    foreach($produits as $produit){
                                                        $produit = json_decode(json_encode($produit), true);

                                                                                                                
                                                ?>
                                                  <i class=" fas fa-box	"></i>  produit : 
                                                   {{$produit['nom']}}
                                                    | {{$produit['quantite'] ?? 'non définie'}}<br>
                                                    <?php
                                                        }                                        
                                                    ?>
                                                <br>
                                                        <i class=" fas fa-money-bill	"></i> prix :{{$commande->getTotal()}} D.A<br>

                                                </td>
                                                <td>                                                 
                                                    {{App\Commande::getWilaya($commande->wilaya) ?? ' '}} 
                                                    {{$commande->commune ?? ''}} 
                                                </td>
                                                <td>                                                 
                                                    <?php
                                                        $livreur = json_decode($commande->livreur); 
                                                    ?>
                                                    <?php  
                                                        if(isset($livreur->name)){echo '<i class="fa fa-user" style="color:green;"></i>'.$livreur->name.'<br>';}else{echo '<i class="fa fa-user" style="color:green;"></i> ';}?>
                                                    <?php  
                                                        if(isset($livreur->prenom)){echo $livreur->prenom.'<br>';}?>
                                                    <?php  
                                                        if(isset($livreur->telephone)){echo '<i class="fa fa-phone"></i> '.$livreur->telephone.'<br>';}?>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info btn btn-info" style=""> 
                                                         {{$commande->state ?? ''}}  
                                                    </span>                                                
                                                </td>
                                                <td>
                                                   
                                                    <div class="dropdown">
                                                        <button class="btn btn-info" data-toggle="modal" data-target="#Open{{$commande->id}}">Historique </button>

                                                        <a class="btn btn-info" href="{{route('commande.edit',['commande'=>$commande->id])}}"><i class="fa fa-edit"></i> </a>
                                                        <div class="modal fade" id="Open{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="Open{{$commande->id}}Label" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title" id="Open{{$commande->id}}Label">Historique:</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    </div>
                                                                        <div class="modal-body">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th scope="col">Etat</th>
                                                                                                <th scope="col">Date</th>
                                                                                                <th scope="col">Acteur</th>
                                                                                            </tr>
                                                                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>en prépartion</td>
                                                <td>
                                                    {{$commande->en_prepartion ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>en cours</td>
                                                <td>
                                                    {{$commande->en_cours ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>Sortie</td>
                                                <td>
                                                    {{$commande->sortie ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr><td>
                                                  Annule                                                    
                                                </td>
                                                <td>
                                                    {{$commande->annule ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    reporte                                           
                                                </td>
                                                <td>
                                                    {{$commande->reporte ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>ne repodn pas</td>
                                                <td>
                                                    {{$commande->ne_reponds_pas ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>


                                            <tr>
                                                <td>non abouti</td>
                                                <td>
                                                    {{$commande->non_abouti ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>
                                            <tr>
                                                <td>livree</td>
                                                <td>
                                                    {{$commande->livree ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>

                                            <tr>
                                                <td>retour ls</td>
                                                <td>
                                                    {{$commande->retour ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>

                                            <tr>
                                                <td>retour client</td>
                                                <td>
                                                    {{$commande->retour ?? '--/--/--'}}
                                                </td>
                                                <td>{{$commande->acteur ?? "" }}</td>
                                            </tr>

                                        </tbody>


                                                                                    </table>


                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <a href="{{route('commande.destroy',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-trash"></i> </a>
                                                        <a href="{{route('commande.show',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-eye"></i> </a>
                                                        <!-- <a href="{{route('commande.timeline',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-list"></i> </a> -->



                                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#editState{{$commande->id}}">
                                                            <i class="fa fa-pen"></i> 
                                                        </button>
                                                        <!-- <a onclick="return confirm('etes vous sure  ?')" href="{{route('commande.destroy',['id_commande'=>$commande->id])}}" class="btn btn-info"><i class="fa fa-trash"></i> </a> -->

                                                        <div class="modal fade" id="editState{{$commande->id}}" tabindex="-1" role="dialog" aria-labelledby="editState{{$commande->id}}Label" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title" id="editState{{$commande->id}}Label">Modifier l'etat de la commande :</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <form id="form_type" action=" {{route('commande.update.state')}}" method="post">
                                                                        @csrf
                                                                        <div class="form-row">
                                                                            <div class="col-md-6">
                                                                                <input type="hidden" value="{{$commande->id}}" name="commande"/>
                                                                                <div class="form-group">
                                                                                    <label class="small mb-1" for="inputFirstName">type: </label>
                                                                                        <select class='form-control produits' name='state' >
                                                                                            <option>veuillez séélctionner </option>
                                                                                            <option value="en preparation">en prépartion</option>
                                                                                            <option value="en_cours">en cours</option>
                                                                                            <option value="sortie">sortie</option>
                                                                                            <option value="annule">annule</option>
                                                                                            <option value="reporte">reporte</option>
                                                                                            <option value="non_abouti">non abouti</option>
                                                                                            <option value="ne_repond_pas">ne repond pas</option>
                                                                                            <option value="livree">livree</option>
                                                                                            <option value="retour">retour</option>
                                                                                        </select>
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn btn-primary btn-block" type="submit" >modifer type</button>
                                                                    </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>




                                                    </div>                                                
                                                </td>

                                            </tr>

                                            @endforeach
                                            <div class="modal fade" id="creditModal" tabindex="-1" role="dialog" aria-labelledby="example" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Saisir le crédit  :</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <form id="commande_update_credit" action=" {{route('commande.update.credit')}}" method="post">
                                                        @csrf
                                                            <div class="form-row">
                                                                <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <input type="hidden" value="" name="commande" id="commande_credit"/>
                                                                </div>
                                                                    <div class="form-group">
                                                                        <label class="small mb-1" for="inputFirstName">Montant de crédit: </label>
                                                                        <input type="text" class="form-control" value="" name="montant_credit" id=""/>                                        
                                                                    </div>

                                                            </div>
                                                            <br>
                                                        </form>
                                                        <button class="btn btn-primary btn-block" type="button" onclick="document.getElementById('commande_update_credit').submit();" >envoyer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tbody>
                                    </table>

                                </div>

                            </div>

 

                        </div>

                    </div>







@endsection