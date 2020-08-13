<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Админка
Route::match(['get','post'],'/admin', 'HomeController@index')->name('admin');
Route::match(['get','post'],'/admin/users','HomeController@users')->name('admin_users');
//Админка Блог Категории
Route::match(['get','post'],'/admin/blog/categories','Blog\AdminEditBlogController@index');
//Админка Блог Статьи
Route::match(['get','post'],'/admin/blog/articles','Blog\AdminEditBlogController@articlesControl');
//Админка Блог Редактирование Статьи
Route::match(['get','post'],'/admin/blog/edit-article/{id}','Blog\AdminEditBlogController@editArticle')->where('id','[0-9]+');
//Админка Блог Добавление Статьи
Route::match(['get','post'],'/admin/blog/add-article','Blog\AdminEditBlogController@addArticle');
//Редактирование изображений
Route::match(['get','post'],'edit-image','Blog\AdminEditBlogController@imageEdit');

//Админка Магазин Категории
Route::match(['get','post'],'/admin/shop/categories','Shop\ShopController@categories');
//Админка Магазин Список товаров
Route::match(['get','post'],'/admin/shop/products','Shop\ShopController@Products');
//Админка Магазин Добавление товара
Route::match(['get','post'],'admin/shop/add-product','Shop\ShopController@addProduct');
//Админка Магазин Редактирование Товара
Route::match(['get','post'],'/admin/shop/edit-product/{id}','Shop\ShopController@editProduct')->where('id','[0-9]+');
