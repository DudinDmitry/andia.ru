@extends('admin')

@section('content')

    @if ($message!='')
        <div id="mydiv" class="alert alert-danger" role="alert">
            {{$message}}
        </div>
        <script>
            setTimeout(function () {
                $('#mydiv').fadeOut('fast');
            }, 3000);
        </script>
    @endif

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Категории
                        <form method="post" action="">
                            @csrf
                            <div class="border">

                                <!-- Добавление категорий -->
                                @if($request->add_category)
                                    <div class="card-body table-responsive">
                                        <label>Добавить категорию</label>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col"><small class="text-gray border-bottom">*Отображаемое
                                                        название
                                                    </small><br>Название
                                                </th>
                                                <th scope="col"><small class="text-gray border-bottom">*Если это
                                                        подкатегория, выберите родительскую
                                                    </small><br>Родительская категория
                                                </th>
                                                <th scope="col"><small class="text-gray border-bottom">*Для отображения
                                                        на сайте</small><br>URL
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <input type="text" class="form-control" name="add[category_name]"
                                                           placeholder="Название"
                                                           required></th>
                                                <th scope="row">
                                                    <select name="add[parent_id]" class="form-control">
                                                        <option value="0">Родительская</option>
                                                        @foreach($allCategories as $category)
                                                            <option
                                                                value="{{$category->id}}">{{ $category->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th scope="row"><input type="text" class="form-control " required
                                                                       value="" name="add[category_slug]"
                                                                       placeholder="URL категории"></th>
                                            </tr>
                                            <tr>
                                                <th scope="col"><small class="text-gray border-bottom">*Отображение для
                                                        пользователей</small><br>Активность
                                                </th>
                                                <th colspan="">
                                                    <small class="text-gray border-bottom">*Описание категории
                                                        (Необязательно)</small><br>
                                                    Описание:
                                                </th>
                                                <th><small class="text-gray border-bottom">*Разработать
                                                        позже</small><br>
                                                    <button class="btn border-white" disabled>
                                                        <i class="fa fa-file-image text-dark" title="Сохранить">
                                                            Добавить изображение</i>
                                                    </button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <select name="add[active]" class="form-control">
                                                        <option value="1">Активна</option>
                                                        <option value="0">Скрыть</option>
                                                    </select>
                                                </th>
                                                <th colspan="">
                                                    <textarea class="form-control" name="add[description]"
                                                              placeholder="Ввести описание категории"></textarea>
                                                </th>
                                                <th>
                                                    <input type="file" class=form-control" disabled>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <button type="submit" name="submit_add_category"
                                                            class="btn btn-outline-primary" value="Add">Добавить
                                                        категорию
                                                        <i class="fa fa-save text-primary" title="Добавить"></i>
                                                    </button>
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            <!-- Редактирование категорий -->
                                @if($editUser!=NULL)
                                    <div class="card-body table-responsive">
                                        <label>Настройка категории</label>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col"><small class="text-gray border-bottom">*Отображаемое
                                                        название
                                                    </small><br>Название
                                                </th>
                                                <th scope="col"><small class="text-gray border-bottom">*Если это
                                                        подкатегория, выберите родительскую
                                                    </small><br>Родительская категория
                                                </th>
                                                <th scope="col"><small class="text-gray border-bottom">*Для отображения
                                                        на сайте</small><br>URL
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <input type="text" class="form-control" name="edit[category_name]"
                                                           placeholder="Название" value="{{$editUser->category_name}}"
                                                           required></th>
                                                <th scope="row">
                                                    <select name="edit[parent_id]" class="form-control">
                                                        <option value="0">Родительская</option>
                                                        @foreach($allCategories as $category)
                                                            @if($category->id==$editUser->id)
                                                            @else
                                                                <option
                                                                    @if($editUser->parent_id==$category->id) selected
                                                                    @endif
                                                                    value="{{$category->id}}">{{ $category->category_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </th>
                                                <th scope="row"><input type="text" class="form-control " required
                                                                       value="{{$editUser->category_slug}}"
                                                                       name="edit[category_slug]"
                                                                       placeholder="URL категории"></th>
                                            </tr>
                                            <tr>
                                                <th scope="col"><small class="text-gray border-bottom">*Отображение для
                                                        пользователей</small><br>Активность
                                                </th>
                                                <th colspan="">
                                                    <small class="text-gray border-bottom">*Описание категории
                                                        (Необязательно)</small><br>
                                                    Описание:
                                                </th>
                                                <th><small class="text-gray border-bottom">*Разработать
                                                        позже</small><br>
                                                    <button class="btn border-white" disabled>
                                                        <i class="fa fa-file-image text-dark" title="Сохранить">
                                                            Добавить изображение</i>
                                                    </button>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th scope="row">
                                                    <select name="edit[active]" class="form-control">
                                                        <option value="1"
                                                                @if($editUser->category_active==1) selected @endif>
                                                            Активна
                                                        </option>
                                                        <option value="0"
                                                                @if($editUser->category_active==0) selected @endif>
                                                            Скрыть
                                                        </option>
                                                    </select>
                                                </th>
                                                <th colspan="">
                                                    <textarea class="form-control" name="edit[description]"
                                                              placeholder="Ввеси описание категории">{{$editUser->category_description}}</textarea>
                                                </th>
                                                <th>
                                                    <input type="file" class=form-control" disabled>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <button type="submit" name="submit_edit_end"
                                                            class="btn btn-outline-primary" value="{{$editUser->id}}">
                                                        Редактировать
                                                        категорию
                                                        <i class="fa fa-edit text-primary" title="Добавить"></i>
                                                    </button>
                                                </th>
                                                <th>
                                                    <i class="fa fa-calendar-alt text-primary" title="Добавить"></i>
                                                    Дата создания: <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editUser->created_at)->format('d-m-Y')}}
                                                    <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editUser->created_at)->format('H:i')}}
                                                </th>
                                                <th>
                                                    <i class="fa fa-calendar-times text-primary" title="Добавить"></i>
                                                    Дата обновления: <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editUser->updated_at)->format('d-m-Y')}}
                                                    <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editUser->updated_at)->format('H:i')}}
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            @csrf
                            <button class="btn btn-lg border-dark fa-pull-right" type="submit" name="add_category"
                                    value="New">
                                <i class="fa fa-plus-circle text-green"> Добавить</i></button>
                            <ul>
                                @foreach($rootCategories as $rootCategory)
                                    <button type="submit"
                                            class="btn btn-outline-success h5 btn-link @if($rootCategory->category_active!=1){{'text-gray'}}@endif"
                                            name="submit_edit" value="{{$rootCategory->id}}">
                                        <i class="fa fa-folder text-yellow"></i>
                                        @if($rootCategory->category_active!=1) <i class="fa fa-eye-slash text-red"
                                                                                  title="Категория скрыта"></i> @endif
                                        {{ $rootCategory->category_name }} ({{$rootCategory->articles()->count()}})
                                    </button>
                                    @if($rootCategory->id!=1)
                                        <button class="btn " type="submit" name="submit_delete_category"
                                                value="{{$rootCategory->id}}" onClick="if(confirm('Удалить категорию?')){this.submit();}else return false">
                                            <i class="fa fa-times text-red"></i></button>
                                    @endif
                                    <br>

                                    @if($rootCategory->ProductCategory->count() > 0)
                                        @include('admin.blog.recursion.category', ['categories' => $rootCategory->ProductCategory])
                                    @endif
                                    <hr>
                                @endforeach
                            </ul>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
