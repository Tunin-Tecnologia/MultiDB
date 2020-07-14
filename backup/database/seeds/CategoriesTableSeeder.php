<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workspace = \Tenant::getTenant();
        factory(\App\Models\Category::class, 10)
            ->make()
            ->each(function($category) use($workspace){
                $category->name = $category->name . ' ' . $workspace->prefix;
                $category->save();
            });
    }
}
