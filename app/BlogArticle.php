<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogArticle extends Model
{
    use SoftDeletes;
    protected $table='blog_articles';
    protected $dates=['delete_at'];

    public function categories()
    {
        return $this->belongsToMany('App\BlogCategory','blog_article_category','article_id','category_id');
    }
    public function users()
    {
        return $this->belongsTo('App\User','author_id');
    }
}
