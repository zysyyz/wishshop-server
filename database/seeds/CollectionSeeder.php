<?php

use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\Product;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        Collection::truncate();
        CollectionItem::truncate();

        $path = 'database/seeds/yslbeauty-collections.json';
        $collections = json_decode(file_get_contents($path), true);

        $position = -1;
        foreach ($collections as $key => $value) {
            $position += 1;
            $items = $value['items'];
            unset($value['items']);

            $value = array_merge($value, ['position' => $position]);

            $collection = Collection::updateOrCreate(
                [
                    'store_id' => 1,
                    'slug' => $value['slug'],
                ],
                $value
            );


            $itemPosition = -1;
            foreach ($items as $item) {
                $itemPosition += 1;
                $item['target_id'] = 0;
                if (isset($item['target_slug'])) {
                    if ($item['target_slug'] == 'product') {
                        $product = Product::where('slug', 'like', $item['target_slug'].'%')->first();

                        if (!$product) {
                            break;
                        }

                        $item['target_id'] = $product->id;
                    } else if ($item['target_slug'] == 'category') {
                        $category = Category::where('slug', 'like', $item['target_slug'].'%')->first();

                        if (!$category) {
                            break;
                        }

                        $item['target_id'] = $category->id;
                    }
                    unset($item['target_slug']);
                }

                $item = array_merge($item, [
                    'store_id' => 1,
                    'collection_id' => $collection->id,
                    'target_id' => $item['target_id'],
                    'position' => $itemPosition,
                ]);

                CollectionItem::create($item);
            }
        }
    }
}
