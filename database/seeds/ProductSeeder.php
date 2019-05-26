<?php

use App\Models\Category;
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

        $path = 'database/seeds/yslbeauty-products.json';
        $products = json_decode(file_get_contents($path), true);

        foreach ($products as $key => $value) {
            if (isset($value['category_slug'])) {
                $category = Category::where('slug', $value['category_slug'])->first();
                $value['category_id'] = $category->id;
                unset($value['category_slug']);
            }

            Product::updateOrCreate(
                [
                    'store_id' => 1,
                    'slug' => $value['slug'],
                ],
                $value
            );
        }
    }
}
