
        <div class="form-group">
           
        <input type="file" class="form-control" name="img_path" id="img_path" value="" >

       
        </div>
        
        @if ($photo->img_path)

        <div class="form-group">
           
        <img src="{{asset($photo->path)}}" title="{{$photo->path}}">
           
        </div>
@endif
