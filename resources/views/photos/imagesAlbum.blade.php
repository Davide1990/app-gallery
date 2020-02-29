@extends('templates/layout')

@section('content')
@if (session()->has('message'))
  @component('components/alert-info')
  {{session()->get('message')}}
  @endcomponent  
@endif
<div class="row">
    <div class="col-md-12">
  
      <div id="mdb-lightbox-ui"></div>
  
      <div class="row mdb-lightbox no-margin">
  
        @forelse ($photos as $photo)
        <figure class="col-md-3 foto">
            <a class="black-text fancybox" href="{{asset($photo->path)}}" data-size="1600x1067" rel="ligthbox">
              <img alt="picture" src="{{asset($photo->path)}}" class="zoom img-fluid"/>
              <h6 class="text-center my-3">{{$photo->name}}</h6>
            </a>
            <!-- aggiungi id alla route in modo che lo aggiunga automaticamente alla rotta 
            mylaravelapp.test/photos/64-->
            <div class="justify-content-start">
              <a title="modifica immagine" href="{{route('photos.edit', $photo)}}" class="btn btn-default"> <i class="fas fa-edit"></i> </a>
              <a title="cancella immagine" href="{{route('photos.destroy', $photo)}}" class="btn btn-danger"> <i class="fas fa-minus"></i> </a>
            </div>
          </figure>

        @empty
            <h2> Non sono presenti immagini </h2>
        @endforelse
    
          
  
      </div>
  
    </div>
    
  </div>
  <!-- php artisan vendor:publish per pubblicare le views dei vendor -->
  <div class="row justify-content-md-center riga-imp">
      <div class="col col-lg-2">
        {{$photos->links('vendor/pagination/bootstrap-4')}}
      </div>
  </div>
 
@endsection

@section('footer')
    
    @parent
    <script>
        
        $('document').ready(function(){

          $('div.alert').fadeOut(4000);

            $('.foto').on('click','a.btn-danger',function(el){
                
                el.preventDefault();
                var url = el.target.href;
                var figure = el.target.parentNode;
                console.log(url);
                $.ajax(
                    url,
                    {
                        method:'DELETE',
                        data: {
                            '_token': '{{csrf_token()}}'
                        },
                        complete:function($resp){
                           console.log($resp); 
                            if ($resp.responseText == 1){
                              figure.parentNode.removeChild(figure);
                            } else {
                               alert('Problem contacting server')
                            }
                        }
                    }
                )
            })

        })


    </script>

@endsection