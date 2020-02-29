@extends('templates/layout')

@section('content')

@include('partials/errormessage')
    <h3> Edit Album </h3>
    <form method="POST" enctype="multipart/form-data">
       
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="name"> Nome Album </label>
            <input required type="text" class="form-control" name="name" id="name" value="{{$album->album_name}}" placeholder="Album Name">
          
        </div>
        <div class="form-group">
           <label for="description"> Descrizione Album </label>
            <textarea required class="form-control" name="description" id="description" placeholder="description">{{$album->description}}
            </textarea>
           
        </div>
        @include('album/partials/combo-categories')
       
        @include('album/partials/uploadFile')

        <button type="submit" class="btn btn-primary"> SUBMIT </button>

    </form>

@endsection
