<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('active')->default(1)->after('email')->comment('Активация пользователя');
            $table->string('phone')->nullable()->default(NULL)->after('active')->comment('Телефон');
            $table->softDeletes()->comment('Если не NULL - пользователь удалён');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('phone');
            $table->dropSoftDeletes();
        });
    }
}
