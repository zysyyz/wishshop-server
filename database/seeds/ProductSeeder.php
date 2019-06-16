<?php

use App\Models\Category;
use App\Models\Content;
use App\Models\Modifier;
use App\Models\ModifierOption;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

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
        Content::truncate();
        Modifier::truncate();
        ModifierOption::truncate();
        Product::truncate();
        Review::truncate();

        $path = 'database/seeds/yslbeauty-products.json';
        $products = json_decode(file_get_contents($path), true);

        foreach ($products as $key => $value) {
            if (isset($value['category_slug'])) {
                $category = Category::where('slug', $value['category_slug'])->first();
                $value['category_id'] = $category->id;
                unset($value['category_slug']);
            }


            $modifiers = $value['modifiers'];
            unset($value['modifiers']);

            $contents = $value['contents'];
            unset($value['contents']);

            $reviews = $value['reviews'];
            unset($value['reviews']);

            $product = Product::updateOrCreate(
                [
                    'store_id' => 1,
                    'slug' => $value['slug'],
                ],
                $value
            );

            foreach ($modifiers as $key => $value) {
                $modifier = array_merge($value, [
                    'store_id' => 1,
                    'product_id' => $product->id,
                ]);
                $options = $modifier['options'];
                unset($modifier['options']);
                $modifier = Modifier::create($modifier);

                foreach ($options as $key => $value) {
                    $option = array_merge($value, [
                        'store_id' => 1,
                        'product_id' => $product->id,
                        'modifier_id' => $modifier->id,
                    ]);
                    ModifierOption::create($option);
                }
            }

            foreach ($reviews as $key => $value) {
                $user_id = null;
                if ($value['user']) {
                    $p = [
                        'name' => $value['user']['name'],
                    ];
                    $user = User::firstOrCreate($p, $p);
                    $user_id = $user->id;
                }

                $review = array_merge($value, [
                    'store_id' => 1,
                    'user_id' => $user_id,
                    'product_id' => $product->id,
                ]);
                unset($review['user']);
                // unset($review['tags']);
                Review::create($review);
            }

            $contentPosition = -1;
            foreach ($contents as $key => $value) {
                $contentPosition += 1;
                $content = array_merge($value, [
                    'store_id' => 1,
                    'product_id' => $product->id,
                    'position' => $contentPosition,
                ]);
                Content::create($content);
            }

        }
    }
}
