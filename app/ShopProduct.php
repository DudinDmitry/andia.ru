<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $table='shop_products';
    protected $dates=['delete_at'];
}
