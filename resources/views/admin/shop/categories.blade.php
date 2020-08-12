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
                        <div class="border">
                            <form method="post" action="">
                            @csrf
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

                                                <th scope="col"><small class="text-gray border-bottom">*Для отображения
                                                        на сайте</small><br>URL
                                                </th>
                                                <th scope="col"><small class="text-gray border-bottom">*Отображение для
                                                        пользователей</small><br>Активность
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <input type="text" class="form-control" name="add[category_name]"
                                                           placeholder="Название"
                                                           required></th>

                                                <th scope="row"><input type="text" class="form-control " required
                                                                       value="" name="add[category_slug]"
                                                                       placeholder="URL категории"></th>
                                                <th scope="row">
                                                    <select name="add[active]" class="form-control">
                                                        <option value="1">Активна</option>
                                                        <option value="0">Скрыть</option>
                                                    </select>
                                                </th>
                                            </tr>
                                            <tr>

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
                                                <th colspan="">
                                                    <textarea class="form-control" name="meta[title]"
                                                              placeholder="Мета Title (Необязательно)"></textarea>
                                                </th>

                                            </tr>
                                            <tr>
                                                <th colspan="">
                                                <textarea class="form-control" name="add[description]"
                                                          placeholder="Ввести описание категории"></textarea>

                                                </th>
                                                <th>
                                                    <input type="file" class=form-control" disabled>
                                                </th>
                                                <th colspan="">
                                                    <textarea class="form-control" name="meta[description]"
                                                              placeholder="Мета Description (Необязательно)"></textarea>
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
                                @if($editCategory!=NULL)
                                    <div class="card-body table-responsive">
                                        <label>Настройка категории</label>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col"><small class="text-gray border-bottom">*Отображаемое
                                                        название
                                                    </small><br>Название
                                                </th>

                                                <th scope="col"><small class="text-gray border-bottom">*Для отображения
                                                        на сайте</small><br>URL
                                                </th>
                                                <th scope="col"><small class="text-gray border-bottom">*Отображение для
                                                        пользователей</small><br>Активность
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <th scope="row">
                                                    <input type="text" class="form-control" name="edit[category_name]"
                                                           placeholder="Название"
                                                           value="{{$editCategory->category_name}}"
                                                           required></th>

                                                <th scope="row"><input type="text" class="form-control " required
                                                                       value="{{$editCategory->category_slug}}"
                                                                       name="edit[category_slug]"
                                                                       placeholder="URL категории"></th>
                                                <th scope="row">
                                                    <select name="edit[active]" class="form-control">
                                                        <option value="1"
                                                                @if($editCategory->category_active==1) selected @endif>
                                                            Активна
                                                        </option>
                                                        <option value="0"
                                                                @if($editCategory->category_active==0) selected @endif>
                                                            Скрыть
                                                        </option>
                                                    </select>
                                                </th>
                                            </tr>
                                            <tr>

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
                                                <th colspan="">
                                                    <small>Title</small>
                                                    <textarea class="form-control" name="meta[title]"
                                                              placeholder="Мета Title (Необязательно)">{{$editCategory->meta_title}}</textarea>
                                                </th>
                                            </tr>
                                            <tr>

                                                <th colspan="">
                                                    <textarea class="form-control" name="edit[description]"
                                                              placeholder="Ввеси описание категории">{{$editCategory->category_description}}</textarea>
                                                </th>
                                                <th>
                                                    <input type="file" class=form-control" disabled>
                                                </th>
                                                <th colspan="">
                                                    <small>Description</small>
                                                    <textarea class="form-control" name="meta[description]"
                                                              placeholder="Мета Description (Необязательно)">{{$editCategory->meta_description}}</textarea>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    <button type="submit" name="submit_edit_end"
                                                            class="btn btn-outline-primary"
                                                            value="{{$editCategory->id}}">
                                                        Редактировать
                                                        категорию
                                                        <i class="fa fa-edit text-primary" title="Добавить"></i>
                                                    </button>
                                                </th>
                                                <th>
                                                    <i class="fa fa-calendar-alt text-primary" title="Добавить"></i>
                                                    Дата создания: <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editCategory->created_at)->format('d-m-Y')}}
                                                    <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editCategory->created_at)->format('H:i')}}
                                                </th>
                                                <th>
                                                    <i class="fa fa-calendar-times text-primary" title="Добавить"></i>
                                                    Дата обновления: <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editCategory->updated_at)->format('d-m-Y')}}
                                                    <br>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    {{ \Carbon\Carbon::parse($editCategory->updated_at)->format('H:i')}}
                                                </th>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="">
                            @csrf
                            <button class="btn btn-lg border-dark fa-pull-right" type="submit" name="add_category"
                                    value="New">
                                <i class="fa fa-plus-circle text-green"> Добавить</i></button>
                            <ul>
                                @foreach($categories as $category)
                                    <button type="submit"
                                            class="btn btn-outline-success h5 btn-link @if($category->category_active!=1){{'text-gray'}}@endif"
                                            name="submit_edit" value="{{$category->id}}">
                                        <i class="fa fa-folder text-yellow"></i>
                                        @if($category->category_active!=1) <i class="fa fa-eye-slash text-red"
                                                                              title="Категория скрыта"></i> @endif
                                        {{ $category->category_name }} ({{$category->products()->count()}})
                                    </button>
                                    <button class="btn " type="submit" name="submit_delete_category"
                                            value="{{$category->id}}"
                                            onClick="if(confirm('Удалить категорию?')){this.submit();}else return false">
                                        <i class="fa fa-times text-red"></i></button>
                                    <br>
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
