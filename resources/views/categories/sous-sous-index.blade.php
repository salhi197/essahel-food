@extends('layouts.admin')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> sub-sub categories</h1>

                             <div class="card mb-4">

                            <div class="card-header">

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                add sub-sub category
                            </button>




                            </div>


                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">


                                            <tr>
                                                <th>ID subsub</th>
                                                <th>label</th>
                                                <th>parent subsub catgory</th>
                                                <th>parent catgory</th>
                                                <th>actions</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @if(count($subsubs) > 0)
                                                @foreach($subsubs as $subsub)                                            
                                                <tr>
                                                    <td>{{$subsub->id ?? ''}}</td>
                                                    <td>{{$subsub->label ?? ''}}</td>
                                                    <td>{{$subsub->getSub() ?? ''}}</td>
                                                    <td>{{$subsub->getCategorie() ?? ''}}</td>
                                                    <td >
                                                        <div class="table-action">  
                                                            <a  
                                                            href="{{route('subsub.destroy',['subsub'=>$subsub->id])}}"
                                                            onclick="return confirm('etes vous sure  ?')"
                                                            class="btn btn-danger text-white"><i class="fa fa-trash"></i>delete 
                                                            </a>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$subsub->id}}">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="exampleModal{{$subsub->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit subsub category: </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('subsub.update')}}" method="post">
                                                                @csrf
                                                                    <div class="form-group">
                                                                        <label class="small mb-1" for="inputFirstName">label: </label>
                                                                        <input type="text" name="label" value="{{$subsub->label ?? ''}}"  class="form-control"/>
                                                                    </div>    

                                                                    <div class="form-group">
                                                                        <label class="small mb-1" for="inputFirstName">sub Categorie: </label>
                                                                        <select class="form-control" name="sub">
                                                                            @foreach($subs as $sub)
                                                                                <option @if($subsub->sub == $sub->label) selected  @endif value="{{$sub->label}}">
                                                                                    {{$sub->label ?? ''}}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>    

                                                                    <div class="form-group">
                                                                        <label class="small mb-1" for="inputFirstName">parent Categorie: </label>
                                                                        <select class="form-control" name="categorie">
                                                                            @foreach($categories as $categorie)
                                                                                <option @if($subsub->categorie == $categorie->label) selected  @endif value="{{$categorie->label}}">
                                                                                    {{$categorie->label ?? ''}}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>    

                                                                    <div class="form-group">
                                                                        <input type="hidden" value="{{$subsub->id}}" name="id_subsub"  class="form-control"/>
                                                                    </div>    
                                                                    <button class="btn btn-primary btn-block" type="subsubmit" id="ajax_categorie">edit subsub category</button>
                                                                </form>


                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                @endforeach

                                            

                                            @else

                                            <tr>

                                                <td colspan="7" class="text-center">

                                                <p>empty list </p>



                                                </td>

                                            </tr>



                                            @endif





                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <form id="categorieFform" action="{{route('subsub.create')}}" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputFirstName">subsub Categorie: </label>
                                            <input type="text" name="label"  class="form-control"/>
                                        </div>    
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputFirstName">parent sub Categorie: </label>
                                            <select class="form-control" name="sub">
                                                @foreach($subs as $sub)
                                                    <option value="{{$sub->id}}">{{$sub->label ?? ''}}</option>
                                                @endforeach
                                            </select>
                                        </div>    

                                        <div class="form-group">
                                            <label class="small mb-1" for="inputFirstName">parent Categorie: </label>
                                            <select class="form-control" name="categorie">
                                                @foreach($categories as $categorie)
                                                    <option value="{{$categorie->id}}">{{$categorie->label ?? ''}}</option>
                                                @endforeach
                                            </select>
                                        </div>    
                                        <button class="btn btn-primary btn-block" type="subsubmit" id="ajax_categorie">Add</button>
                                    </form>        
                            </div>
                            </div>
                        </div>
                    </div>



@endsection

