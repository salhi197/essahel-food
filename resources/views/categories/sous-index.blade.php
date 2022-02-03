@extends('layouts.admin')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> sub categories</h1>

                             <div class="card mb-4">

                            <div class="card-header">

                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                add sub category
                            </button>




                            </div>


                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class=" text-primary">


                                            <tr>
                                                <th>ID sub</th>
                                                <th>label</th>
                                                <th>parent catgory</th>
                                                <th>actions</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            @if(count($subs) > 0)
                                                @foreach($subs as $sub)                                            
                                                <tr>
                                                    <td>{{$sub->id ?? ''}}</td>
                                                    <td>{{$sub->label ?? ''}}</td>
                                                    <td>{{$sub->getParent() ?? ''}}</td>
                                                    <td >
                                                        <div class="table-action">  
                                                            <a  
                                                            href="{{route('sub.destroy',['sub'=>$sub->id])}}"
                                                            onclick="return confirm('etes vous sure  ?')"
                                                            class="btn btn-danger text-white"><i class="fa fa-trash"></i>delete 
                                                            </a>
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$sub->id}}">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="exampleModal{{$sub->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit sub category: </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{route('sub.update')}}" method="post">
                                                                @csrf
                                                                    <div class="form-group">
                                                                        <label class="small mb-1" for="inputFirstName">label: </label>
                                                                        <input type="text" name="label" value="{{$sub->label ?? ''}}"  class="form-control"/>
                                                                    </div>    

                                                                    <div class="form-group">
                                                                        <label class="small mb-1" for="inputFirstName">parent Categorie: </label>
                                                                        <select class="form-control" name="categorie">
                                                                            @foreach($categories as $categorie)
                                                                                <option <?php if($sub->categorie == $categorie->label) echo "selected";?>
                                                                                value="{{$categorie->id}}">
                                                                                    {{$categorie->label ?? ''}}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>    

                                                                    <div class="form-group">
                                                                        <input type="hidden" value="{{$sub->id}}" name="id_sub"  class="form-control"/>
                                                                    </div>    
                                                                    <button class="btn btn-primary btn-block" type="submit" id="ajax_categorie">edit sub category</button>
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
                                    <form id="categorieFform" action="{{route('sub.create')}}" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputFirstName">sub Categorie: </label>
                                            <input type="text" name="label"  class="form-control"/>
                                        </div>    
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputFirstName">parent Categorie: </label>
                                            <select class="form-control" name="categorie">
                                                @foreach($categories as $categorie)
                                                    <option value="{{$categorie->id}}">{{$categorie->label ?? ''}}</option>
                                                @endforeach
                                            </select>
                                        </div>    
                                        <button class="btn btn-primary btn-block" type="submit" id="ajax_categorie">Add</button>
                                    </form>        
                            </div>
                            </div>
                        </div>
                    </div>



@endsection

