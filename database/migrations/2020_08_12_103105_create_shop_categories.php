<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_name', 50);
            $table->integer('category_active')->default(1);
            $table->string('category_slug', 50)
                ->unique();
            $table->string('category_description')
                ->nullable();
            $table->string('category_image')->nullable();
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
        Schema::dropIfExists('shop_categories');
    }
}
