<?php

use App\Models\Product;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        if (env('APP_ENV') == 'local') {
            factory(Product::class, 12)->create();
        }
    }
}
