
<div class="modal fade "  id="squarespaceModal{{$livreur->id}}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabel">Ajouter livreur</h3>
            </div>

        <div class="modal-body">
            <form action="{{route('livreur.update',['livreur'=>$livreur->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Login</label>
                <input type="text" value="{{ $livreur->email ?? '' }}" name="email" class="form-control" id="exampleInputEmail1" placeholder="Entrer clé de Login ">
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">mot de passe : </label>
                <input type="text" value="{{ $livreur->password_text ?? '' }}" name="password" class="form-control" placeholder="  ">
            </div>





            <div class="form-group">
                <label for="exampleInputEmail1">nom  : </label>

                <input type="text" class="form-control"  value="{{ $livreur->name ?? '' }}" name="name" id="nom" placeholder="votre nom ">

            </div>

            <div class="form-group">

                <label for="exampleInputEmail1">prenom  : </label>

                <input type="text" class="form-control"  value="{{ $livreur->prenom ?? '' }}" name="prenom" id="prenom" placeholder="votre prenom ">

            </div>

            



            <div class="form-group">

                <label for="exampleInputEmail1">N Téléphone :</label>

                <input type="text" value="{{ $livreur->telephone ?? '' }}" name="telephone" class="form-control" id="" placeholder="Enter votre numero de téléphone ">

            </div>





            <div class="form-group">

                <label for="exampleInputEmail1">Région: </label>

                <input type="text" value="{{ $livreur->adress ?? '' }}" name="adress" class="form-control" id="adress" placeholder="Enter votre adress : ">

            </div>






            <!-- <div class="form-group">

                <label for="exampleInputPassword1">date naissance</label>

                <input type="date" name="birth" class="form-control" id="birth" placeholder="">

            </div> -->

            <div class="btn-group" role="group">

                    <button type="submit" class="btn btn-primary">Save</button>

                </div>
                <button type="button" class="btn btn-danger" data-dismiss="modal"  role="button">Fermer</button>

            </form>



        </div>


    </div>

    </div>

</div>