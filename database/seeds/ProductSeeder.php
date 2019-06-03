<?php

use App\Models\Category;
use App\Models\Content;
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
        Content::truncate();

        $path = 'database/seeds/yslbeauty-products.json';
        $products = json_decode(file_get_contents($path), true);

        foreach ($products as $key => $value) {
            if (isset($value['category_slug'])) {
                $category = Category::where('slug', $value['category_slug'])->first();
                $value['category_id'] = $category->id;
                unset($value['category_slug']);
            }

            $contents = $value['contents'];
            unset($value['contents']);

            $product = Product::updateOrCreate(
                [
                    'store_id' => 1,
                    'slug' => $value['slug'],
                ],
                $value
            );


            $contentPosition = -1;
            foreach ($contents as $key => $value) {
                $contentPosition += 1;
                $content = array_merge($value, [
                    'store_id' => 1,
                    'target_type' => 'product',
                    'target_id' => $product->id,
                    'position' => $contentPosition,
                ]);
                Content::create($content);
            }

        }
    }
}
