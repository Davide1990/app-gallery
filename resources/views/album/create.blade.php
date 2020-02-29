@extends('templates/layout')

@section('content')

@include('partials/errormessage')
    <h3> Create Album </h3>
    <form method="POST" action="{{route('album.save')}}" enctype="multipart/form-data">

        <input type="hidden" name="_token" value="{{csrf_token()}}">
       
        <div class="form-group">
                <label for="name"> Nome Album </label> 
            <input required type="text" class="form-control" name="name" id="name" value="" placeholder="Album Name">
          
        </div>

        <div class="form-group">
                <label for="description"> Descrizione Album </label>
            <textarea  class="form-control" name="description" id="description" placeholder="Description"></textarea>
           
        </div>

       @include('album/partials/combo-categories')

        @include('album/partials/uploadFile')

        <button type="submit" class="btn btn-primary"> INSERT </button>

       


    </form>

@endsection
