@extends('templates/layout')

@section('content')

@include('partials/errormessage')
@if ($photo->id)
    <h3> Edit Photo </h3>
    <form action="{{route('photos.update', $photo)}}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PATCH">
@else
    <h3> New Photo </h3>  
    <form action="{{route('photos.store')}}" method="POST" enctype="multipart/form-data"> 
@endif
    
       
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="id" value="{{$photo->id}}">
        <div class="form-group">
            <label for="name"> Nome Foto </label>
            <input required type="text" class="form-control" name="name" id="name" value="{{$photo->name}}" >
          
        </div>
        <div class="form-group">
            <label for="description"> Descrizione Foto </label>
            <textarea required class="form-control" name="description" id="description">{{$photo->description}}</textarea>
           
        </div>

        <div class="form-group">
            <label> Album </label>
            <select required name="album_id" id="album_id">
                <option value=""> SELECT </option>
                @foreach ($albums as $item)
                    <option {{$item->id==$album->id?'selected':''}} value="{{$item->id}}"> {{$item->album_name}}
                @endforeach
            </select>
           
        </div>

        <label> Immagine  </label>
        @include('photos/partials/uploadFile')

        <button type="submit" class="btn btn-primary"> SUBMIT </button>

    </form>

@endsection
