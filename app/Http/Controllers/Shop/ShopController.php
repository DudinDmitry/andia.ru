<?php

namespace App\Http\Controllers\Shop;

use App\BlogArticle;
use App\BlogCategory;
use App\Http\Controllers\Controller;
use App\ShopCategory;
use App\ShopProduct;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Управление категориями
    public function categories(Request $request)
    {
        $meta['h1'] = 'Категории товаров';
        $message = '';
        $editCategory = NULL;
        //Добавление новой категории
        if ($request->submit_add_category) {
            $newCategory = new ShopCategory;
            $newCategory->category_name = $request->add['category_name'];
            $newCategory->category_active = $request->add['active'];
            $newCategory->category_slug = $request->add['category_slug'];
            if (!empty($request->meta['title'])) {
                $newCategory->meta_title = $request->meta['title'];
            }
            if (!empty($request->meta['description'])) {
                $newCategory->meta_description = $request->meta['description'];
            }
            if (count(ShopCategory::withTrashed()->where('category_slug', '=', $request->add['category_slug'])->get()) > 0) {
                $newCategory->category_slug = $request->add['category_slug'] . '-' . rand(0, 9);
            }
            if (!empty($request->add['description'])) {
                $newCategory->category_description = $request->add['description'];
            }
            $newCategory->save();
            $message = 'Добавлена новая категория';
        }

        //Удаление категорий
        if (isset($request->submit_delete_category)) {
            if (ShopCategory::find($request->submit_delete_category)->products()->count() > 0) {
                $message = 'В данной категории есть товары. Удалите или перенесите их, чтобы удалить категорию';
            } else {
                ShopCategory::find($request->submit_delete_category)->delete();
                $message = 'Категория удалена';
            }

        }

        //Открытие меню для редактирования
        if (isset($request->submit_edit)) {
            $editCategory = ShopCategory::find($request->submit_edit);
        }

        //Редактирование категории
        if (isset($request->submit_edit_end)) {
            $editCategoryRequest = ShopCategory::find($request->submit_edit_end);
            $editCategoryRequest->category_name = $request->edit['category_name'];
            $editCategoryRequest->category_active = $request->edit['active'];
            if (count(ShopCategory::withTrashed()->where('category_slug', '=', $request->edit['category_slug'])->
                where('category_slug', '!=', $editCategoryRequest->category_slug)->get()) > 0) {
                $editCategoryRequest->category_slug = $request->edit['category_slug'] . '-' . rand(0, 9);
            } else {
                $editCategoryRequest->category_slug = $request->edit['category_slug'];
            }
            if (!empty($request->edit['description'])) {
                $editCategoryRequest->category_description = $request->edit['description'];
            }
            if (!empty($request->meta['title'])) {
                $editCategoryRequest->meta_title = $request->meta['title'];
            }
            if (!empty($request->meta['description'])) {
                $editCategoryRequest->meta_description = $request->meta['description'];
            }
            $editCategoryRequest->save();
            $message = 'Категория ' . $editCategoryRequest->category_name . ' отредактированна';
        }

        return view('admin.shop.categories', [
            'meta' => $meta,
            'message' => $message,
            'categories' => ShopCategory::all(),
            'request' => $request,
            'editCategory' => $editCategory
        ]);
    }

    //Список товаров
    public function Products(Request $request)
    {
        $meta['h1'] = 'Товары';
        $message = '';
        //Активация/Деактивация
        if (isset($request->submit_activation)) {
            $active = ShopProduct::find($request->submit_activation);
            $active->product_active = 1;
            $active->save();
            $message = 'Товар опубликован';
        }
        if (isset($request->submit_deactivation)) {
            $deactive = ShopProduct::find($request->submit_deactivation);
            $deactive->product_active = 0;
            $deactive->save();
            $message = 'Товар скрыт';
        }
        //Удаление товара
        if (isset($request->submit_article_delete)) {
            $delete = ShopProduct::find($request->submit_article_delete);
            $delete->delete();
            $message = 'Товар удалён';
        }
        return view('admin.shop.products', [
            'meta' => $meta,
            'message' => $message,
            'products' => ShopProduct::all(),
        ]);
    }

    //Добавление товара
    public function addProduct(Request $request)
    {
        $meta['h1'] = 'Товары';
        $message = '';

        //dump($request->request);
        //Добавление нового товара
        if ($request->submit_add_article == 'Add') {
            $newProduct = new ShopProduct;
            $newProduct->title = $request->add['title'];
            $newProduct->price = $request->add['price'];
            $newProduct->product_description = $request->add['body'];
            $newProduct->product_active = $request->add['active'];
            $newProduct->product_slug = $request->add['slug'];
            if (count(ShopProduct::where('product_slug', '=', $request->add['slug'])->get()) > 0) {
                $newProduct->product_slug = $request->add['slug'] . '-' . rand(0, 999);
            }
            $newProduct->category_id = $request->add['category_id'];

            //Мета-теги
            if ($request->check['title'] == 'on') {
                $newProduct->meta_title = $request->meta['title'];
            }
            if ($request->check['description'] == 'on') {
                $newProduct->meta_description = $request->meta['description'];
            }
            $newProduct->save();
            $message = 'Товар добавлен';
        }

        return view('admin.shop.addproduct', [
            'meta' => $meta,
            'message' => $message,
            'categories' => ShopCategory::all(),
        ]);
    }

    public function editProduct($id, Request $request)
    {
        $meta['h1'] = 'Редактирование продукта';
        $message = '';
        //Редактирование статьи
        if ($request->submit_edit_article == 'Edit') {
            $editProduct = ShopProduct::find($id);
            $editProduct->title = $request->edit['title'];
            $editProduct->product_description = $request->edit['body'];
            $editProduct->product_active = $request->edit['active'];

            if (count(ShopProduct::where('product_slug', '=', $request->edit['slug'])->
                where('product_slug', '!=', $editProduct->product_slug)->get()) > 0) {
                $editProduct->product_slug = $request->edit['slug'] . '-' . rand(0, 999);
            } else {
                $editProduct->product_slug = $request->edit['slug'];
            }
            $editProduct->category_id = $request->edit['category_id'];
            $editProduct->price = $request->edit['price'];
            //Мета-теги
            if (isset($request->check['title'])) {
                $editProduct->meta_title = $request->meta['title'];
            } else {
                $editProduct->meta_title = NULL;
            }
            if (isset($request->check['description'])) {
                $editProduct->meta_description = $request->meta['description'];
            } else {
                $editProduct->meta_description = NULL;
            }
            $editProduct->save();
            $message = 'Товар отредактирован';
        }


        return view('admin.shop.editproduct', [
            'meta' => $meta,
            'message' => $message,
            'categories' => ShopCategory::all(),
            'product' => ShopProduct::find($id),
        ]);
    }

}
