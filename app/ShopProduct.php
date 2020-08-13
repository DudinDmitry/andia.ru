<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopProduct extends Model
{
    use SoftDeletes;
    protected $table='shop_products';
    protected $dates=['delete_at'];

    public function category()
    {
        return $this->belongsTo('App\ShopCategory');
    }
}
