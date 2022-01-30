@extends('layouts.admin')



@section('content')

<div class="container-fluid">

                        <h1 class="mt-4"> types</h1>

                             <div class="card mb-4">

                            <div class="card-header">

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Ajouter un type
                                    </button>




                            </div>

                            <div class="card-body">

                                <div class="table-responsive">

                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                                        <thead>

                                            <tr>

                                                <th>ID type</th>
                                                <th>label</th>
                                                <th>prix / commission /temps</th>
                                                <th>actions</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            @if(count($types) > 0)

                                                @foreach($types as $type)                                            

                                                <tr>

                                                    <td>{{$type->id ?? ''}}</td>

                                                    <td>{{$type->label ?? ''}}</td>
                                                    <td>{{$type->prix ?? ''}} - {{$type->commission ?? ''}} - {{$type->temps ?? ''}}</td>

                                                    <td >

                                                        <div class="table-action">  

                                                            <a  

                                                            href="{{route('type.destroy',['type'=>$type->id])}}"

                                                            onclick="return confirm('etes vous sure  ?')"

                                                            class="btn btn-danger text-white">

                                                                    <i class="fas fa-trash"></i> supprimer 
                                                            </a>
                                                            <button type="button" class="btn btn-primary" 
                                                            data-toggle="modal" 
                                                            data-target="#exampleModal{{$type->id}}">
                                                                Modifer
                                                            </button>


                                                            <div class="modal fade" id="exampleModal{{$type->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" id="edit_type_form_{{$type->id}}" action="{{route('type.update')}}">
                                                                        @csrf
                                                                            <input type="hidden" name="id_type" value="{{$type->id}}"  class="form-control"/>
                                                                            <div class="form-group">
                                                                                <label class="small mb-1" for="inputFirstName">type: </label>
                                                                                <input type="text" value="{{$type->label ?? ''}}" name="label"  class="form-control"/>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="small mb-1" for="inputFirstName">temps de livraison: </label>
                                                                                <input type="text" value="{{$type->temps ?? ''}}" name="temps"  class="form-control"/>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="small mb-1" for="inputFirstName">prix : </label>
                                                                                <input type="text" value="{{$type->prix ?? ''}}" name="prix" class="form-control"/>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="small mb-1" for="inputFirstName">Commission: </label>
                                                                                <input type="text" value="{{$type->commission ?? ''}}" name="commission" class="form-control"/>
                                                                            </div>
                                                                        </form>
                                                                        <button class="btn btn-primary btn-block edit_type" type="button" id="{{$type->id}}">modifier type</button>

                                                                    </div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                        </div>

                                                    </td>



                                                </tr>

                                                @endforeach

                                            

                                            @else

                                            <tr>

                                                <td colspan="7" class="text-center">

                                                <p>la liste des commerciaux est vide </p>



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
        <h5 class="modal-title" id="exampleModalLabel">Ajouter type livraison</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_type">
                    <div class="form-group">
                        <label class="small mb-1" for="inputFirstName">type: </label>
                        <input type="text" name="type"  class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="inputFirstName">temps de livraison: </label>
                        <input type="text" name="temps"  class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="inputFirstName">prix : </label>
                        <input type="text" name="prix" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1" for="inputFirstName">Commission: </label>
                        <input type="text" name="commission" class="form-control"/>
                    </div>
    
            <button class="btn btn-primary btn-block" type="button" id="ajax_type">ajouter type</button>

        </form>
      </div>
    </div>
  </div>
</div>



@endsection


@section('scripts')

<script>
$(document).ready(function(){
    $(".edit_type").click(function(){
        var id = this.id;
        console.log(id)
        $('#edit_type_form_'+id).submit()
    })


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
                    console.log(data)
                    toastr.success(data.msg)
                    location.reload();

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