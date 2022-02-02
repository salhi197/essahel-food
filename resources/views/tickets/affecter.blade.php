@extends('layouts.master')

@section('content')




  <div class="container-fluid">
                        <h1 class="mt-4"> Tableau de bord </h1>        
                           <div class="card mb-4">
                               <div class="card-header">
                                    Affecter commande 
                                </div>

                               <div class="card-header">

                                    <div class="row">
                                        <input 
                                        onkeyup="myFunction()" 
                                        class="col-md-2 form-control" id="search"  placeholder="filter avec Code Bar" />

                                        <!-- <div class="col-md-2" style="">
                                            <div class="form-check">
                                                <input type="checkbox"  class="form-check-input" id="checkAll">
                                                <label class="form-check-label" for="checkAll">séléctionner tout :</label>
                                            </div>
                                        </div> -->
                                        &nbsp;
                                        <a
                                            onclick="return confirm('etes vous sure  ?')"
                                            id="hrefAttacher" href="#" class="btn btn-danger" >
                                                confirmation   
                                        </a>                                                                                                        
                                    </div>



                                </div>







                            <div class="card-body">
                                <div class="table-responsive">
                                

                                    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                              <th>date</th>
                                              <th>client</th>
                                              <th>Tracking</th>
                                              <th>Consomateur</th>
                                                <th>produit</th>
                                                <th>wilaya</th>
                                                <th>Livreur</th>
                                                <th>actions</th>
                                            </tr>
                                        </thead>
              
                                    </table>
                                    <br>


                                </div>
                            </div>


                        </div>
                    </div>


                    
@endsection


@section('scripts')
<script>
    

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        var livreur = <?php echo json_encode($_livreur); ?>;

        var hrefAttacher = "/commande/affecter/list/livreur/"+livreur+"/list?id=";
        console.log(hrefAttacher)

        if(filter.length==0){

            for (i = 1; i < tr.length; i++) {
                tr[i].classList.add("tr-code");
                $('#hrefAttacher').attr('href',"#")   
            }
        } else {
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2];
                if (td) {
                txtValue=td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    // .style.display="inline";
                    tr[i].classList.remove("tr-code");
                    hrefAttacher =hrefAttacher +tr[i].id+",";
                } else {
                    tr[i].classList.add("tr-code");
                }
            }   
            $('#hrefAttacher').attr('href',hrefAttacher)   
            }        
        }
    }
</script>
@endsection
@section('styles')
<style>
.tr-code{
    display:none;
}
</style>
@endsection
