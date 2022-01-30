@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <h1 class="mt-4"> Liste de boutiques</h1>
                       <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-info" href="{{route('boutique.show.create')}}">
                                    <i class="fas fa-plus"></i>
                                    Ajouter une boutique
                                </a>

                            </div>
                        
 

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>id </th>
                                                <th>nom</th>
                                                <th>email</th>
                                                <th>liste produits | quantité | prix</th>
                                                <th>crér le</th>
                                                <th>actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($boutiques as $boutique)                                            
                                            <tr>
                                            <td> 
                                                        {{$boutique->id ?? 'non définie'}}
                                                </td>
                                                <td> 
                                                        {{$boutique->name ?? 'non définie'}}
                                                </td>

                                                <td>                                                 
                                                    {{$boutique->email}}
                                                 </td>

                                                 <td>
                                                 <?php 
                                                    $produits = json_decode($boutique->produits);
                                                    foreach($produits as $produit){
                                                        $produit = json_decode(json_encode($produit), true);                                                 
                                                     ?>
                                                    <i class=" fas fa-box	"></i>  produit : 
                                                    {{str_limit($produit['nom'] ?? '', $limit = 10, $end = '')}}
                                                    | {{$produit['quantite'] ?? 'non définie'}}
                                                    | {{$produit['prix_vente'] ?? 'non définie'}} DA<br>
                                                        <?php  } ?>

                                                
                                                    </td>
                                                    <td>
                                                    
                                                    {{$boutique->created_at}}
                                                
                                                    </td>
                                                        <td>                                                 
                                                    <i class="fa fa-user"></i>: {{$boutique->nom_client ?? 'non définie'}}
                                                 </td>                                                 
                                                <td >
                                                <div class="table-action">  
                                                <a  
                                                    onclick="return confirm('etes vous sure  ?')"
                                                    href="{{route('boutique.destroy',['id_boutique'=>$boutique->id])}}"
                                                    class="btn btn-danger">
                                                            <i class="fas fa-trash"></i> Annuler 
                                                    </a>
                                                    <br>
                                                    <br>
                                                    <a 
                                                    href="{{route('boutique.edit',['id_boutique'=>$boutique->id])}}"
                                                     class="btn btn-info text-white">
                                                            <i class="fas fa-edit"></i> Modifer 
                                                    </a>
                                                    </div>
                                                </td>

                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    {{ $boutiques->links() }}

                                </div>

                            </div>
                        </div>
                    </div>



@endsection


@section('scripts')
<script>
function watchWilayaChanges() {
            $('#wilaya_select').on('change', function (e) {
                e.preventDefault();
                var $communes = $('#commune_select');
                var $communesLoader = $('#commune_select_loading');
                var $iconLoader = $communes.parents('.input-group').find('.loader-spinner');
                var $iconDefault = $communes.parents('.input-group').find('.material-icons');
                $communes.hide().prop('disabled', 'disabled').find('option').not(':first').remove();
                $communesLoader.show();
                $iconDefault.hide();
                $iconLoader.show();
                $.ajax({
                    dataType: "json",
                    method: "GET",
                    url: "/api/static/communes/ " + $(this).val()
                })
                    .done(function (response) {
                        $.each(response, function (key, commune) {
                            $communes.append($('<option>', {value: commune.id}).text(commune.name));
                        });
                        $communes.prop('disabled', '').show();
                        $communesLoader.hide();
                        $iconLoader.hide();
                        $iconDefault.show();
                    });
            });
        }

        $(document).ready(function () {
            watchWilayaChanges();
        });

</script>
@endsection