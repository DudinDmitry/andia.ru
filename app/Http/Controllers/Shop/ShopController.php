<?php

namespace App\Http\Controllers\Shop;

use App\BlogCategory;
use App\Http\Controllers\Controller;
use App\ShopCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            $message='Категория '.$editCategoryRequest->category_name.' отредактированна';
        }

        return view('admin.shop.categories', [
            'meta' => $meta,
            'message' => $message,
            'categories' => ShopCategory::all(),
            'request' => $request,
            'editCategory' => $editCategory
        ]);
    }
}
