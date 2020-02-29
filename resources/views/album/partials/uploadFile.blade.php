
        <div class="form-group">
        <label for="album_thumb"> Thumbnail </label>
        <input type="file" class="form-control" name="album_thumb" id="album_thumb" value="" >

       
        </div>
        
        @if ($album->album_thumb)

        <div class="form-group">
           
        <img src="{{asset($album->path)}}" title="{{$album->album_name}}">
           
        </div>
@endif
