@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card mt-2">
                                    <div class="card-header"><h3 class="font-weight-light my-4">nouveau news-letter:  </h3></div>
                                    <div class="card-body">
                                        <form method="post" action="{{route('newsletter.store')}}" enctype="multipart/form-data">
                                        @csrf
                                            <div class="form-row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">Objet : </label>
                                                        <input type="text" value="{{ old('objet') }}" name="objet"  class="form-control"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                <div class="form-group">
                                                        <label class="small mb-1">fichier :</label>
                                                        <input  class="form-control-file" name="image" type="file" placeholder="telephone" />
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="small mb-1">Type d'acteur :</label>
                                                        <br>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input"  value="livreur" type="checkbox" id="livreur" name="type[]">
                                                                <label class="form-check-label"  for="livreur">livreur</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input"  value="commercial" type="checkbox" id="commercial" name="type[]">
                                                                <label class="form-check-label"  for="commercial">commercial</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input"  value="boutique" type="checkbox" id="boutique" name="type[]">
                                                                <label class="form-check-label"  for="boutique">boutique</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input"  value="fournisseur" type="checkbox" id="fournisseur" name="type[]">
                                                                <label class="form-check-label"  for="fournisseur">fournisseur</label>
                                                            </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-10">
                                                <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">contenu :</label>
                                                        <textarea name="content" class="form-control"></textarea>  
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">envoyer </button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

@endsection


