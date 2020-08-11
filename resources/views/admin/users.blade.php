@extends('admin')

@section('content')

    @if ($message)
        <div id="mydiv" class="alert alert-danger" role="alert">
            {{$message}}
        </div>
        <script>
            setTimeout(function() {
                $('#mydiv').fadeOut('fast');
            }, 3000);
        </script>
        @endif

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Настройка пользователей
                    <div class="fa-pull-right">
                        <form method="post" action="">@csrf <button class="btn btn-lg border-white" type="submit" name="add_user" value="New">
                            <i class="fa fa-plus-circle text-green"> Добавить пользователя</i></button></form></div>
                    </div>
                    <!-- Добавление пользователя -->
                    @if($add_user)
                        <div class="card-body table-responsive">
                            <label>Добавить пользователя</label>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col"><small class="text-gray border-bottom">*Отображаемое имя</small><br>Имя</th>
                                    <th scope="col"><small class="text-gray border-bottom">*В формате name@mail.ru</small><br>Почта</th>
                                    <th scope="col"><small class="text-gray border-bottom">*Минимум 8 символов</small><br>Пароль</th>
                                    <th scope="col"><small class="text-gray border-bottom">*Номер телефона в любом формате</small><br>Телефон</th>
                                    <th>
                                        <button class="btn border-white">
                                            <i class="fa fa-plus-circle text-green" title="Сохранить"></i></button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <form method="post" action="">@csrf
                                    <th scope="row">
                                        <input type="text" class="form-control" name="add[name]" placeholder="Отображаемое имя"
                                         required></th>
                                    <th scope="row"><input type="email" class="form-control " required
                                                           value="{{$edit_user['email']}}" name="add[email]" placeholder="Электронная почта"></th>
                                    <th scope="row"><input type="password" class="form-control"  pattern=".{8,}" required
                                                           value="{{$edit_user['email']}}" name="add[password]" placeholder="Пароль"></th>
                                    <th scope="row"><input type="text" class="form-control" name="add[phone]"
                                                           value="{{$edit_user['phone']}}" placeholder="Ввести номер">
                                    </th>
                                    <th>
                                        <button type="submit" name="submit_add_user" class="btn border-white" value="Add">
                                            <i class="fa fa-plus-circle text-green" title="Добавить"></i></button>
                                    </th>
                                </form>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <!-- Редактирование пользователя -->
                    @if($edit_user)
                        <div class="card-body">
                            Изменить пользователя <label>{{$edit_user['name']}}</label>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Почта</th>
                                    <th scope="col">Активен</th>
                                    <th scope="col">Телефон</th>
                                    <th>
                                        <button class="btn border-white">
                                            <i class="fa fa-save text-blue" title="Редактировать"></i></button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <form method="post" action="">@csrf
                                    <th scope="row">{{$edit_user['id']}}</th>
                                    <th scope="row"><input type="text" class="form-control" required
                                                           value="{{$edit_user['name']}}" name="edit[name]"></th>
                                    <th scope="row"><input type="email" class="form-control" required
                                                           value="{{$edit_user['email']}}" name="edit[email]"></th>
                                    <th scope="row"><select class="form-control" name="edit[active]">
                                            <option value="0" @if($edit_user['active']==0) selected @endif>Нет</option>
                                            <option value="1" @if($edit_user['active']==1) selected @endif>Да</option>
                                        </select></th>
                                    <th scope="row"><input type="text" class="form-control" name="edit[phone]"
                                                           value="{{$edit_user['phone']}}" placeholder="Ввести номер">
                                    </th>
                                    <th>
                                        <button type="submit" name="submit_edit_end" class="btn border-white" value="{{$edit_user['id']}}">
                                            <i class="fa fa-save text-blue" title="Редактировать"></i></button>
                                    </th>
                                </form>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="card-body table-responsive">
                        Вывод пользователей
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <button class="btn border-white"><i class="fa fa-user-edit text-blue"
                                                                        title="Редактировать"></i></button>
                                    <button class="btn border-white">
                                        <i class="fa fa-check-circle text-green" title="Активация/деактивация"></i>
                                    </button>
                                </th>
                                <th scope="col">ID</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Почта</th>
                                <th scope="col">Дата создания</th>
                                <th scope="col">Телефон</th>
                                <th scope="col">
                                    <button class="btn border-white">
                                        <i class="fa fa-trash text-red" title="Удалить"></i></button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <form method="post" action="">
                                @csrf
                                @foreach($users as $user)
                                    <tr>
                                        <th scope="col">
                                            <button type="submit" name="submit_edit" class="btn border-white"
                                                    value="{{$user['id']}}">
                                                <i class="fa fa-user-edit text-blue" title="Редактировать"></i></button>
                                            @if($user['active']==0)
                                                <button type="submit" name="submit_activation" class="btn border-white"
                                                        value="{{$user['id']}}"
                                                        onClick="if(confirm('Активировать пользователя?')){this.submit();}else return false">
                                                    <i class="fa fa-check-circle text-@if($user['active']==1){{'red'}}@else{{'green'}}@endif"
                                                       title="Активировать"></i></button>
                                            @else
                                                <button type="submit" name="submit_deactivation"
                                                        class="btn border-white" value="{{$user['id']}}"
                                                        onClick="if(confirm('Деактивировать пользователя?')){this.submit();}else return false">
                                                    <i class="fa fa-eye-slash text-red" title="Деактивировать"></i>
                                                </button>
                                            @endif
                                        </th>
                                        <th scope="row">{{$user['id']}}</th>
                                        <td>{{$user['name']}}</td>
                                        <td>{{$user['email']}}</td>
                                        <td>{{$user['created_at']}}</td>
                                        <td>{{$user['phone']}}</td>
                                        <td scope="col">
                                            <button type="submit" name="submit_delete" class="btn border-white"
                                                    value="{{$user['id']}}"
                                                    onClick="if(confirm('Точно удалить пользователя?')){this.submit();}else return false">
                                                <i class="fa fa-trash text-red" title="Удалить"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
