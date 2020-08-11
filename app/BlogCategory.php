<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;

    protected $table='blog_categories';
    protected $dates=['delete_at'];

    public function ProductCategory()
    {
        return $this->hasMany('App\BlogCategory','parent_id');
    }

    public function rootCategories()
    {
        return $this->where('parent_id',0)->with('ProductCategory')->get();
    }

    public function articles()
    {
        return $this->belongsToMany('App\BlogArticle','blog_article_category','category_id','article_id');
    }
}
