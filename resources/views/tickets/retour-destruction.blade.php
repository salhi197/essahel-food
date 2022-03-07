@extends('layouts.ui')

@section('content')




    <div class="container-fluid">
        <div class="card mb-4">
            <h4 class="card-header">
                Retour Ticket type Destruction :
            </h4>
            <div class="card-header">
                <div class="row">
                    <div class="col-md-2">
                        <input onblur="this.focus()" autofocus onchange="SearchFunction();" 
                        class="col-md-2 form-control" id="search"  placeholder="filter avec Code Bar" />
                    </div>

                </div>



            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="myTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Crée le </th>
                            <th>Au Dépot le </th>
                            <th>Nom Produit</th>
                            <th>code bar </th>
                            <th>Staut </th>
                            <th>num_ticket_produit </th>
                        </tr>
                        </thead>
                        <tbody >
                        @foreach($tickets as $ticket)
                            <tr id="{{$ticket->id ?? ''}}">
                                <td>{{$ticket->created_at}}</td>
                                <td>{{$ticket->updated_at}}</td>
                                <td>{{$ticket->getProduit()['nom'] ?? ''}}</td>
                                <td>{{$ticket->codebar ?? ''}}</td>
                                <td>{{($ticket->satut=='0') ? 'Vient d\'étre créé' : $ticket->satut}}</td>
                                <td>{{$ticket->num_ticket_produit ?? ''}}</td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <br>


                </div>
            </div>


        </div>
    </div>



@endsection



@section('scripts')


<script type="text/javascript">
    
    window.addEventListener("keydown", function(event) 
    {
        if(event.getModifierState("CapsLock")==true)
        {
            swal.stopLoading();
            swal.close();
            //
        }
        else
        {
            $("#search").val("");
            swal("Attention", "Veuillez Allumer Ver Maj", "warning");
            //
        }
        //
    });    
    /**/
</script>



    <script>

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        function SearchFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            $('#search').val('')
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            var trId=0;
            var trFound;


            if(filter.length==0){
                for (i = 1; i < tr.length; i++) {
                    tr[i].classList.remove("tr-code");
                    $('#hrefAttacher').attr('href',"#")
                }
            } else {
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[3];
                    if (td) {
                        txtValue=td.textContent || td.innerText;
                        if (txtValue.toUpperCase()==(filter).toUpperCase()) {
                            tr[i].classList.remove("tr-code");
                            trId = tr[i].id;
                            trFound = tr[i];

                        } else {
                            tr[i].classList.add("tr-code");
                        }
                    }

                }
                if(trId!=0)
                {
                    setTimeout(function (){
                        fetch('/ticket/retourner/destruction', {
                            method: 'post',
                            headers: {
                                'Accept': 'application/json, text/plain, */*',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                _token: CSRF_TOKEN,
                                ticket:trId
                            })
                        })
                            .then(res => res.json())
                            .then(res => {
                                $('#search').val('')
                                toastr.success('Ticket Enlevé')
                                for (i = 1; i < tr.length; i++) {
                                    tr[i].classList.remove("tr-code");
                                }
                                trFound.getElementsByTagName("td")[4].innerHTML = "Retour Destruction";
                                $('#'+trId).addClass('alert alert-success')

                                console.log(res);
                            })
                            .catch(err=>function (err) {
                                toastr.danger('Error')
                                console.log("err.message")
                            });
                    },100)
                }else{
                    toastr.error('Ticket n\'existe pas chez ce livreur')
                    $('#search').val('')
                    for (i = 1; i < tr.length; i++) {
                        tr[i].classList.remove("tr-code");
                    }
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
