@extends('templates/layout')
@section('content')

    <h1> Albums </h1>
    @if (session()->has('message'))
        @component('components/alert-info')
            {{session()->get('message')}}
        @endcomponent
    @endif
    
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                  <th scope="col">Id Album</th>
                  <th scope="col">Nome Album</th>
                  <th scope="col">Thumbail</th>
                  <th scope="col">By</th>
                  <th scope="col">Data Creazione</th>
                  <th scope="col">Categorie</th>
                  <th scope="col"></th>
                </tr>
            </thead>
            <tbody>

        @foreach ($albums as $album)
        
            <tr id="tr{{$album->id}}">
                <th scope="row">{{$album->id}}</th>
                <td>  {{$album->album_name}} ({{$album->photos_count}})  </td>
                @if ($album->album_thumb)
                <!-- asset genera un url in base alla cartella public del progetto, ti da tutto il link del progetto-->
                <td>
                    <img width="120" height="auto" src="{{asset($album->path)}}" title="{{$album->album_name}}">
                </td> 
                @endif
                <td> {{$album->user->fullname}} </td>
                <td> <!-- in automatico laravel trasforma le date del database in istanza di carbon -->
                    {{$album->created_at->format('d-m-Y')}} 
                </td>
                <td>
                    @if ($album->categories()->count())
                    <!-- se usi $album->categories()->get hai la collection, ed è la stessa cosa che fare
                    $album->categories     
                    
                    dd($album->categories)  =   Collection {#287 ▼
                                                    #items: array:2 [▼
                                                    0 => AlbumCategory {#283 ▶}
                                                    1 => AlbumCategory {#292 ▶}
                                                    ]
                                                }  -->
                    
                        @foreach ($album->categories as $cat)
                            <li> {{$cat->category_name}} </li>
                        @endforeach
                        
                    @else
                        <p> No category found </p>
                    @endif
                    
                </td>
                <td>
                    <a title="inserisci immagine" class="btn btn-success btn-sm" href="{{route('photos.create')}}?album_id={{$album->id}}"> <i class="fas fa-plus"></i></a>
                    @if ($album->photos_count>0)
                    <a title="vedi immagini" class="btn btn-success btn-sm" href="{{route('album.getImages', $album->id)}}"><i class="fas fa-eye"></i></a>
                    @endif
                    <a title="vedi album" class="btn btn-success btn-sm" href="{{route('album.show',$album->id)}}"> <i class="fas fa-search"></i></a>
                    <a title="modifica album" class="btn btn-primary btn-sm" href="{{route('album.edit',$album->id)}}"> <i class="fas fa-edit"></i></a>
                    <form id="form{{$album->id}}" method="post" action="{{route('album.delete',$album->id)}}">
                        @csrf
                        @method('delete')
                        <button id="{{$album->id}}" title="cancella album" class="btn btn-danger btn-sm"> <i class="fas fa-minus"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        
        
    
@endsection
@section('footer')
    
    @parent
    <script>
        
        $('document').ready(function(){

            $('div.alert').fadeOut(4000);

            $('table').on('click','button.btn-danger',function(evt){
                evt.preventDefault();
               
                var id=evt.target.id;
                var form= $('#form' + id);
                var url = form.attr('action');
                var tr = $('#tr' + id);
                
                if (confirm("Stai cancellando l'album!")){
                    $.ajax(
                    url,
                    {
                        method:'DELETE',
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        complete:function($resp){
                           
                            if ($resp){
                                // responseText: "{"response":"1"}"
                                $rispostaOggetto = JSON.parse($resp.responseText);
                               if ($rispostaOggetto.response == 1){
                                tr.remove();
                                
                               }
                               else {
                                alert('Problem contacting server');
                                
                               }
                            } else {
                                
                               alert('Problem contacting server');
                               
                            }
                        }
                    }
                    )
                }
                
            })

        })


    </script>

@endsection