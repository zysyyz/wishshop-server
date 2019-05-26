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

        $path = 'database/seeds/yslbeauty-collections.json';
        $collections = json_decode(file_get_contents($path), true);

        // print_r($collections);

        foreach ($collections as $key => $value) {
            $items = $value['items'];
            unset($value['items']);

            print_r($value);

            $collection = Collection::updateOrCreate(
                [
                    'store_id' => 1,
                    'slug' => $value['slug'],
                ],
                array_merge($value, ['name' => 'NO NAME'])
            );

            foreach ($items as $item) {
                if (isset($item['target_slug'])) {
                    $product = Product::where('slug', 'like', $item['target_slug'].'%')->first();

                    if (!$product) {
                        continue;
                    }

                    $item['target_id'] = $product->id;
                    unset($item['target_slug']);
                }

                $item = array_merge($item, [
                    'store_id' => 1,
                    'collection_id' => $collection->id,
                    'target_id' => $item['target_id'],
                ]);

                print_r($item);

                CollectionItem::updateOrCreate(
                    [
                        'store_id' => 1,
                        'collection_id' => $collection->id,
                        'target_id' => $item['target_id'],
                    ],
                    $item
                );
            }
        }
    }
}
