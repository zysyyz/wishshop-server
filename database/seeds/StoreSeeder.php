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
        if (env('APP_ENV') == 'local') {
            factory(Store::class, 12)->create();
        }
    }
}
