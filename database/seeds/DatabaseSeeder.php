<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker::create();
        // $brands = [
        //     ['id' => 1, 'name' => '品牌1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 2, 'name' => '品牌2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        // ];

        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CollectionSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(UserSeeder::class);
    }
}
