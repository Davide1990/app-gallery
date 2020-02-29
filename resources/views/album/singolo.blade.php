@extends('templates/layout')

@section('content')
    
<h3>  Album {{$singolo->id}} </h3>
<form method="POST">

    
    
    <div class="form-group">
        <label> Title </label>
        <input type="text" class="form-control" name="name" id="name" value="{{$singolo->album_name}}" placeholder="{{$singolo->album_name}}" readonly>
      
    </div>
    <div class="form-group">
        <label> Description </label>
        <textarea class="form-control" name="description" id="description" placeholder="description" readonly>{{$singolo->description}}</textarea>
       
    </div>
    

    <div class="form-group">
        <label> Thumbnail </label><br>
        <img width="150px" height="auto" src="{{asset($singolo->path)}}" title="{{$singolo->album_name}}">  
    </div>
    


</form>

@endsection