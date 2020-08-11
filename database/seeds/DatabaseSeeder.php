<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        DB::table('blog_categories')->insert([
            'id' => 1,
            'parent_id'=>0,
            'category_name'=>'Без категории',
            'category_active'=>1,
            'category_slug'=>'no_category',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
    }
}
