<ul>
    @foreach($categories as $category)
        <li class="list-inline">
        <button type="submit" href="" class="btn btn-link @if($category->category_active!=1){{'text-gray'}}@endif"
        name="submit_edit" value="{{$category->id}}">
            <i class="fa fa-folder text-yellow"></i>
            @if($category->category_active!=1) <i class="fa fa-eye-slash text-red" title="Категория скрыта"></i> @endif
            {{ $category->category_name }} ({{$category->articles()->where('deleted_at','=',NULL)->count()}})
        </button>
            <button class="btn " type="submit" name="submit_delete_category"
                    value="{{$category->id}}" onClick="if(confirm('Удалить категорию?')){this.submit();}else return false">
                <i class="fa fa-times text-red"></i></button>
        </li>
        @if($category->ProductCategory->count() > 0)
            @include('admin.blog.recursion.category', ['categories' => $category->ProductCategory])
        @endif
    @endforeach
</ul>
