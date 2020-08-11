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

    <script type="text/javascript" src="{{ asset('/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#textarea',  // change this value according to your HTML
            language: 'ru',
            branding: false,
            plugins: ["advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste"],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>

    <div class="container col-md-12">

        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">Управление статьями
                        <div class="border">

                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <form method="post" action="">
                            @csrf
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="input-group input-group-lg">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                  id="inputGroup-sizing-lg">Заголовок статьи   &nbsp;
                                            <i class="fa  fa-arrow-circle-right text-dark"></i></span>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Large" name="edit[title]"
                                               aria-describedby="inputGroup-sizing-sm"
                                               value="{{$article->article_title ?? ''}}"
                                               placeholder="Введите название статьи" required>
                                    </div>
                                    <textarea class="form-control" id="textarea" name="edit[body]"
                                              rows="32" placeholder="Расскажите, о чём Вы думаете..."
                                    >{{ $article->article_body ?? ''}}</textarea>
                                </div>
                                <div class="col-md-2 border alert alert-default-info ">
                                    <p class="h4 text-center">Опции</p>
                                    <div class="btn-group table-responsive" role="group" aria-label="Basic example">
                                        <button type="submit" class="btn btn-outline-success" name="submit_edit_article"
                                                value="Edit"><i class="fa fa-save"></i> Сохранить
                                        </button>
                                        <button type="button" class="btn btn-outline-danger"
                                                onclick="window.location.href=window.location.href"><i
                                                class="fa fa-trash-restore"></i> Сбросить
                                        </button>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label><abbr
                                                title="Только английские буквы и цифры без пробелов">URL</abbr></label>
                                        <input type="text" name="edit[slug]" class="form-control"
                                               value="{{$article->article_slug ?? ''}}"
                                               placeholder="Введите url" required>
                                    </div>
                                    <div class="form-group">
                                        <label title="">Категория</label>
                                        <select name="edit[parent_id][]" class="form-control" multiple>
                                            @foreach($allCategories as $category)
                                                <option @foreach($article->categories()->get() as $category_article)
                                                        @if($category->id==$category_article->id) selected @endif
                                                        @endforeach
                                                        value="{{$category->id}}">{{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label title="">Публикация</label>
                                        <select name="edit[active]" class="form-control">
                                            <option value="1" @if($article->article_active==1){{'selected'}}@endif>
                                                Опубликована
                                            </option>
                                            <option value="0" @if($article->article_active==0){{'selected'}}@endif>
                                                Скрыть
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label title="">Краткое описание</label>
                                        <textarea class="form-control" placeholder="Введите краткое описание" rows="5"
                                                  name="edit[description]">{{$article->article_description ?? ''}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label title="">Изображение статьи</label>
                                        <button disabled class="form-control"><small>*В разработке</small></button>
                                    </div>

                                    <div class="form-group">
                                        <label title="">Автор</label>
                                        <input type="text" value="{{$article->users()->first()->name}}"
                                               disabled class="form-control">
                                        <input type="hidden" name="edit[author]"
                                               value="{{\Illuminate\Support\Facades\Auth::id()}}">
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <h4 class="h4">Управление мета-тегами</h4>
                                    <p class="lead text-gray">Включите опцию, если хотите использовать пользовательские
                                        данные</p>
                                    <!-- Управление мета-тегами -->
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" aria-label="Checkbox for following text input"
                                                       name="check[title]"
                                                       @if(isset($article->meta_title)) checked @endif>
                                                &nbsp; Title
                                            </div>
                                        </div>
                                        <input type="text" class="form-control" aria-label="Text input with checkbox"
                                               name="meta[title]"
                                               @if(isset($article->meta_title)) value="{{$article->meta_title}}" @endif
                                               placeholder="Рекомендованная длина: не более 60 символов">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" aria-label="Checkbox for following text input"
                                                       name="check[description]"
                                                       @if(isset($article->meta_description)) checked @endif>
                                                &nbsp; Description
                                            </div>
                                        </div>
                                        <textarea class="form-control" aria-label="Text input with checkbox"
                                                  name="meta[description]"
                                                  placeholder="Рекомендованная длина: 160-180 символов"
                                                  rows="3">@if(isset($article->meta_description)){{$article->meta_description}}@endif</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 ">
                                    <h4 class="h4 text-right">Управление микроразметкой</h4>
                                    <p class="lead text-gray  text-right">*В разработке</p>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
