<div class="form-group">
        <label for="description"> Categorie </label>
        <select name="categories[]" id ="categories" class="form-control" multiple size="5">
            @foreach ($categories as $cat)
                <option {{ in_array($cat->id, $selectedCategories) ? 'selected' : '' }} value="{{$cat->id}}" > {{$cat->category_name}}</option>
            @endforeach

        </select>
   
 </div>