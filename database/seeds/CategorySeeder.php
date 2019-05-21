<?php

use App\Models\Category;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();
        if (env('APP_ENV') == 'local') {
            factory(Category::class, 12)->create();
        }
    }
}
