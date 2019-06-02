<?php

use App\Models\Store;

use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::truncate();
        $path = 'database/seeds/yslbeauty-stores.json';
        $stores = json_decode(file_get_contents($path), true);

        foreach ($stores as $key => $value) {
            $store = Store::updateOrCreate(
                [
                    'slug' => $value['slug'],
                ],
                $value
            );
        }
    }
}
