<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('price')->default(0);
            $table->integer('category_id')->unsigned()->default(0);
            $table->string('article_description')
                ->nullable();
            $table->integer('article_active')->default(1);
            $table->string('article_slug')
                ->unique();
            $table->string('article_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('meta_title')->nullable()->default(NULL);
            $table->string('meta_description')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_products');
    }
}
