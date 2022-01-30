@extends('layouts.admin')

@section('content')
<div class="container-fluid">
                        <h1 class="mt-4">Gestion news-letter</h1>
                             <div class="card mb-4">
                            <div class="card-header">
                                <a class="btn btn-primary" href="{{route('newsletter.create')}}">envoyer une nouvelle news-letter</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>ID </th>
                                                <th>Objet </th>
                                                <th>Type </th>
                                                <th>contenu </th>
                                                <th>fichier </th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($messages as $message)                                            
                                            <tr>
                                                <td>{{$message->id ?? ''}}</td>
                                                <td>{{$message->objet ?? ''}}</td>
                                                <td>{{$message->type ?? ''}}</td>
                                                <td>{{$message->content ?? ''}}</td>
                                                <td><a href="
                                                @if($message->fichier)
                                                {{ asset('storage/'.$message->fichier)}}
                                                @else
                                                #
                                                @endif
                                                ">télécharger</a></td>

                                            </tr>
           
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


@endsection
