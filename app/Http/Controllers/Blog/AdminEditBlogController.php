<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use App\BlogCategory;
use App\BlogArticle;
use Intervention\Image\Facades\Image as Images;


class AdminEditBlogController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogCategory $blogCategory, Request $request)
    {
        $meta['h1'] = 'Категории блога';
        $message = '';
        $editUser = NULL;
        //Добавление новой категории
        if ($request->submit_add_category) {
            $newCategory = new BlogCategory;
            $newCategory->parent_id = $request->add['parent_id'];
            $newCategory->category_name = $request->add['category_name'];
            $newCategory->category_active = $request->add['active'];
            $newCategory->category_slug = $request->add['category_slug'];
            if (count(BlogCategory::where('category_slug', '=', $request->add['category_slug'])->get()) > 0) {
                $newCategory->category_slug = $request->add['category_slug'] . '-' . rand(0, 9);
            }
            if (!empty($request->add['description'])) {
                $newCategory->category_description = $request->add['description'];
            }
            $newCategory->save();

        }
        //Открытие меню для редактирования
        if (isset($request->submit_edit)) {
            $editUser = BlogCategory::find($request->submit_edit);
        }
        //Редактирование категории
        if (isset($request->submit_edit_end)) {
            $newCategory = BlogCategory::find($request->submit_edit_end);
            $newCategory->parent_id = $request->edit['parent_id'];
            $newCategory->category_name = $request->edit['category_name'];
            $newCategory->category_active = $request->edit['active'];
            if (count(BlogCategory::where('category_slug', '=', $request->edit['category_slug'])->
                where('category_slug', '!=', $newCategory->category_slug)->get()) > 0) {
                $newCategory->category_slug = $request->edit['category_slug'] . '-' . rand(0, 9);
            } else {
                $newCategory->category_slug = $request->edit['category_slug'];
            }
            if (!empty($request->edit['description'])) {
                $newCategory->category_description = $request->edit['description'];
            }
            $newCategory->save();
        }
        //Удаление категорий

        if (isset($request->submit_delete_category)) {
            if (BlogCategory::find($request->submit_delete_category)->articles()->count() > 0) {
                $message = 'В данной категории есть статьи. Удалите или перенесите их, чтобы удалить категорию';
            } else {
                if (BlogCategory::where('parent_id', '=', $request->submit_delete_category)->count() > 0) {
                    $message = 'У данной категории есть дочерние. Удалите или поменяйте их родительские элементы для удаления данной категории';
                } else {
                    BlogCategory::find($request->submit_delete_category)->delete();
                    $message = 'Категория удалена';
                }

            }

        }

        return view('admin.blog.categories', ['meta' => $meta,
            'rootCategories' => $blogCategory->rootCategories(),
            'allCategories' => BlogCategory::all(),
            'request' => $request,
            'message' => $message,
            'editUser' => $editUser]);
    }

    public function articlesControl(Request $request)
    {
        $meta['h1'] = 'Статьи';
        $message = '';
        //Активация/Деактивация
        if (isset($request->submit_activation)) {
            $active = BlogArticle::find($request->submit_activation);
            $active->article_active = 1;
            $active->save();
            $message = 'Статья опубликована';
        }
        if (isset($request->submit_deactivation)) {
            $deactive = BlogArticle::find($request->submit_deactivation);
            $deactive->article_active = 0;
            $deactive->save();
            $message = 'Статья скрыта';
        }
        //Удаление статьи
        if (isset($request->submit_article_delete)) {
            $delete = BlogArticle::find($request->submit_article_delete);
            $delete->delete();
            $message = 'Статья удалена';
        }

        return view('admin.blog.articles', ['meta' => $meta,
            'request' => $request,
            'message' => $message,
            'articles' => BlogArticle::all(),
        ]);
    }

    public function addArticle(Request $request)
    {

        $meta['h1'] = 'Статьи';
        $message = '';
        //dump($request->request);
        //Добавление новой статьи
        if ($request->submit_add_article == 'Add') {
            $newArticle = new BlogArticle;
            $newArticle->author_id = $request->add['author'];
            $newArticle->article_title = $request->add['title'];
            $newArticle->article_body = $request->add['body'];
            $newArticle->article_active = $request->add['active'];
            $newArticle->article_slug = $request->add['slug'];
            if (count(BlogArticle::where('article_slug', '=', $request->add['slug'])->get()) > 0) {
                $newArticle->article_slug = $request->add['slug'] . '-' . rand(0, 999);
            }
            $newArticle->article_description = $request->add['description'];
            //Предварительная очистка
            $newArticle->categories()->detach();
            //Добавление связи с категорией
            foreach ($request->add['parent_id'] as $parent) {
                $category = BlogCategory::find($parent);
                $category->articles()->save($newArticle);
            }

            //Мета-теги
            if ($request->check['title'] == 'on') {
                $newArticle->meta_title = $request->meta['title'];
            }
            if ($request->check['description'] == 'on') {
                $newArticle->meta_description = $request->meta['description'];
            }
            $newArticle->save();
            $message = 'Статья опубликована';
        }

        return view('admin.blog.addarticle', [
            'meta' => $meta,
            'message' => $message,
            'allCategories' => BlogCategory::all(),
        ]);
    }

    public function editArticle($id, Request $request)
    {
        $meta['h1'] = 'Статьи';
        $message = '';
        //dump($request->request);

        //Редактирование статьи
        if ($request->submit_edit_article == 'Edit') {
            $newArticle = BlogArticle::find($id);
            $newArticle->author_id = $request->edit['author'];
            $newArticle->article_title = $request->edit['title'];
            $newArticle->article_body = $request->edit['body'];
            $newArticle->article_active = $request->edit['active'];

            if (count(BlogArticle::where('article_slug', '=', $request->edit['slug'])->
                where('article_slug', '!=', $newArticle->article_slug)->get()) > 0) {
                $newArticle->article_slug = $request->edit['slug'] . '-' . rand(0, 999);
            } else {
                $newArticle->article_slug = $request->edit['slug'];
            }
            $newArticle->article_description = $request->edit['description'];
            //Предварительная очистка
            $newArticle->categories()->detach();
            //Добавление связи с категорией
            foreach ($request->edit['parent_id'] as $parent) {
                $category = BlogCategory::find($parent);
                $category->articles()->save($newArticle);
            }


            //Мета-теги
            if (isset($request->check['title'])) {
                $newArticle->meta_title = $request->meta['title'];
            } else {
                $newArticle->meta_title = NULL;
            }
            if ($request->check['description'] == 'on') {
                $newArticle->meta_description = $request->meta['description'];
            } else {
                $newArticle->meta_description = NULL;
            }
            $newArticle->save();
            $message = 'Статья отредактирована';
        }


        return view('admin.blog.editarticle', [
            'meta' => $meta,
            'message' => $message,
            'article' => BlogArticle::find($id),
            'allCategories' => BlogCategory::all(),
        ]);
    }

    public function test(Request $request)
    {


        dump($request->request);
        if (isset($request->submit)) {
            Images::make($request->file)->resize(200, 200)->save('foo2.jpg');
        }

        return view('admin.blog.test');
    }

}
