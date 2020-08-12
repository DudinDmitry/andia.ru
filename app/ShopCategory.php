<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopCategory extends Model
{
    use SoftDeletes;
    protected $table='shop_categories';
    protected $dates=['deleted_at'];

    public function products()
    {
        return $this->hasMany('App\ShopProduct','category_id');
    }
}
