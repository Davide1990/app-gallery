@extends('templates/layout')

@section('content')
    <div class="row" style="margin-bottom: 20px;">
        <div class="card-deck">
        @foreach ($albums as $album)
        <div class="col-4" style="margin-bottom: 40px;" >
            <div class="card">
                <a href="{{route('album.gallery.images', $album->id)}}">
                    <img height="auto" width="auto" class="card-img-top" src="{{asset($album->path)}}" alt="{{$album->album_name}}">
                </a>
                <div class="card-body">
                <h5 class="card-title"><a href="{{route('album.gallery.images',$album->id)}}"> {{$album->album_name}} </a></h5>
                <p class="card-text">{{$album->description}}</p>
                <p class="small"> Categories: 
                    @foreach ($album->categories as $cat)
                        <a href="{{route('album.gallery.category', $cat->id)}}"> {{$cat->category_name}} </a>
                    @endforeach
                <div class="card-footer">
                    <small class="text-muted">{{$album->updated_at->diffForHumans()}}</small>
                </div>
                </div>
            </div>
        </div>
        @endforeach
        </div>
    </div>
@endsection
