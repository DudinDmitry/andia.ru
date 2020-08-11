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

    <div class="container col-md-12">

        <div class="row justify-content-center">

            <div class="col-md-10">
                <div class="card">

                    <div class="card-header">Управление статьями
                        <div class="border">
                        </div>

                    </div>

                    <div class="card-body table-responsive"><div class="col-md-2 float-right">
                            <a href="/admin/blog/add-article"
                               class="btn btn-outline-primary" value="Add">Добавить
                                статью
                                <i class="fa fa-plus-square text-primary" title="Добавить"></i>
                            </a>
                        </div>
                        <form method="post" action="">
                            @csrf
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>
                                        Действия
                                    </th>
                                    <th>
                                        №
                                    </th>
                                    <th scope="col">Название
                                    </th>
                                    <th scope="col">Краткое описание
                                    </th>
                                    <th scope="col">Категория
                                    </th>
                                    <th scope="col">Url
                                    </th>
                                    <th scope="col">Дата создания
                                    </th>
                                    <th scope="col">Дата редактирования
                                    </th>
                                    <th>
                                        Автор
                                    </th>
                                    <th scope="col">
                                        <button class="btn border-white">
                                            <i class="fa fa-check-circle text-green" title="Удалить"></i></button>
                                        <small>Публикация</small>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($articles as $article)
                                    <tr>
                                        <th scope="col">
                                            <a href="/admin/blog/edit-article/{{$article->id}}"
                                               class="btn border-white"><i class="fa fa-edit text-blue"
                                                                           title="Редактировать"></i></a>
                                            <button type="submit" class="btn border-white" name="submit_article_delete" value="{{$article->id}}"
                                                    onClick="if(confirm('Удалить статью?')){this.submit();}else return false">
                                                <i class="fa fa-times text-red"
                                                   title="Удалить статью"></i>
                                            </button>
                                        </th>
                                        <td>
                                            {{$article->id}}
                                        </td>
                                        <th>
                                            <a href="">{{mb_substr($article->article_title,0,45)}}...</a>
                                        </th>
                                        <td>
                                            <small>
                                                @if($article->article_description!='')
                                                    {{mb_substr($article->article_description,0,145)}}...
                                                @else
                                                    {!! mb_substr($article->article_body,0,145) !!}...
                                                @endif
                                            </small>
                                        </td>

                                        <td>
                                            @foreach($article->categories()->get() as $category)
                                                @if($loop->last){{$category->category_name}}
                                                @else
                                                    {{$category->category_name}},<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            {{$article->article_slug}}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($article->created_at)->format('d-m-Y')}}
                                            <br>
                                            {{ \Carbon\Carbon::parse($article->created_at)->format('H:i')}}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($article->update_at)->format('d-m-Y')}}
                                            <br>
                                            {{ \Carbon\Carbon::parse($article->update_at)->format('H:i')}}
                                        </td>
                                        <td>
                                            {{$article->users->name ?? 'Пользователь удалён'}}
                                        </td>
                                        <td class="text-center">
                                            @if($article->article_active==0)
                                                <small>Скрыта</small><br>
                                                <button type="submit" name="submit_activation" class="btn border-danger"
                                                        value="{{$article->id}}"
                                                        onClick="if(confirm('Опубликовать статью?')){this.submit();}else return false">
                                                    <i class="fa fa-check-circle text-green"
                                                       title="Активировать"></i></button>
                                            @else
                                                <small>Опубликована</small><br>
                                                <button type="submit" name="submit_deactivation"
                                                        class="btn border-success" value="{{$article->id}}"
                                                        onClick="if(confirm('Скрыть статью?')){this.submit();}else return false">
                                                    <i class="fa fa-eye-slash text-red" title="Деактивировать"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
