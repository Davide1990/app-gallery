@extends('templates/layout')

@section('content')

    <div class="row">
    @foreach ($images as $image)
        <div class="col-md-4">
            <a href="{{asset($image->path)}}" data-lightbox="{{$image->album->album_name}}" data-title="{{$image->name}}">
                <img class="img-fluid img-thumbnail"  width="auto" height="300px"  src="{{asset($image->path)}}">
            </a>
        </div>
    @endforeach
    </div>
@endsection
