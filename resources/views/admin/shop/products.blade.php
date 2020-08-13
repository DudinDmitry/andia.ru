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

                    <div class="card-header">Управление товарами
                        <div class="col-md-2 float-right">
                            <a href="/admin/shop/add-product"
                               class="btn btn-outline-primary" value="Add">Добавить
                                товар
                                <i class="fa fa-plus-square text-primary" title="Добавить"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr class="text-center">
                                <th>
                                    Действия
                                </th>
                                <th>
                                    №
                                </th>
                                <th scope="col">Название
                                </th>
                                <th scope="col">Цена
                                </th>
                                <th scope="col">Категория
                                </th>
                                <th>
                                    Описание
                                </th>
                                <th scope="col">Url
                                </th>
                                <th scope="col">Дата редактирования
                                </th>
                                <th scope="col">
                                    <small>Публикация</small>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <form method="post" action="">
                                @csrf
                                @foreach($products as $product)
                                    <tr class="text-center">
                                        <td>
                                            <a href="/admin/shop/edit-product/{{$product->id}}"
                                               class="btn border-white"><i class="fa fa-edit text-blue"
                                                                           title="Редактировать"></i></a>
                                            <button type="submit" class="btn border-white" name="submit_article_delete"
                                                    value="{{$product->id}}"
                                                    onClick="if(confirm('Удалить товар?')){this.submit();}else return false">
                                                <i class="fa fa-times text-red"
                                                   title="Удалить статью"></i>
                                            </button>
                                        </td>
                                        <td>
                                            {{$product->id}}
                                        </td>
                                        <th>
                                            {{$product->title}}
                                        </th>
                                        <td>
                                            {{$product->price}}
                                        </td>
                                        <td>
                                            {{$product->category()->get()->first()->category_name}}
                                        </td>
                                        <td>
                                            <small>
                                                {{mb_substr($product->product_description,0,145)}}...
                                            </small>
                                        </td>
                                        <td>
                                            {{$product->product_slug}}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($product->update_at)->format('d-m-Y')}}
                                            <br>
                                            {{ \Carbon\Carbon::parse($product->update_at)->format('H:i')}}
                                        </td>
                                        <td class="text-center">
                                            @if($product->product_active==0)
                                                <small>Скрыта</small><br>
                                                <button type="submit" name="submit_activation" class="btn border-danger"
                                                        value="{{$product->id}}"
                                                        onClick="if(confirm('Опубликовать товар?')){this.submit();}else return false">
                                                    <i class="fa fa-check-circle text-green"
                                                       title="Активировать"></i></button>
                                            @else
                                                <small>Опубликована</small><br>
                                                <button type="submit" name="submit_deactivation"
                                                        class="btn border-success" value="{{$product->id}}"
                                                        onClick="if(confirm('Скрыть товар?')){this.submit();}else return false">
                                                    <i class="fa fa-eye-slash text-red" title="Деактивировать"></i>
                                                </button>
                                            @endif
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
