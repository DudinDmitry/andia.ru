<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Статьи
        Schema::create('blog_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->default(0);
            $table->string('article_title');
            $table->longText('article_body')->nullable();
            $table->integer('article_active')->default(1);
            $table->string('article_slug')
                ->unique();
            $table->string('article_description')
                ->nullable();
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
        Schema::drop('blog_articles');
    }
}
