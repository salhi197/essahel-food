@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <h1 class="mt-4"> Gestion Publicité</h1>
                             <div class="card mb-4">
                            <div class="card-header">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                changer la photo .. 
                            </button>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID </th>
                                                <th>etat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                <a>
                                                <img src="{{asset('pub.jpg')}}" width="300" >
                                                </a>
                                                </td>
                                                <td> Online</td>
                                            </tr>           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ajouter l'imge de pub</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <form method="post" action="{{route('pub.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputConfirmPassword">Image Pub : </label>
                                    <input  class="form-control" value="" name="image" type="file" 
                                    />
                                </div>
                            </div>                            
                            <button type="submit" class="btn btn-primary">Save changes</button>

                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                    </div>

@endsection
