<?php

use App\Models\Brand;

use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::truncate();
        if (env('APP_ENV') == 'local') {
            factory(Brand::class, 12)->create();
        }
    }
}
