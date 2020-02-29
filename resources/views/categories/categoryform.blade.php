<!-- non usiamo empty($category) perche $category è un oggetto e in caso di creazione non sarebbe cmq vuoto -->
<form id="manageCategoryForm" action="{{$category->category_name ? route('categories.update', $category->id) : route('categories.store')  }}" method="POST">
    
    @csrf
            {{$category->category_name ? method_field('PATCH') : '' }}
            <div class="form-group mt-6">
                <label for="category"> Category Name </label>
                <input required type="text" name="category" id="category" class="form-control" value="{{$category->category_name? $category->category_name : ''}}">
                <br>
                <button class="btn btn-success" type="submit">Save</button>
            </div>

</form>
@if ($category->category_name)

    <form action="{{route('categories.destroy',$category->id)}}" method="POST" class="form-inline">
        @csrf
        @method('delete')
        <button class="btn btn-outline btn-danger"> DELETE </button>
    </form>
    
@endif

