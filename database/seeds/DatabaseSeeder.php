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

        // $categories = [
        //     ['id' => 1, 'parent_id' => 0, 'name' => '沙发', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 2, 'parent_id' => 0, 'name' => '床具', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 3, 'parent_id' => 0, 'name' => '框架', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 4, 'parent_id' => 0, 'name' => '椅凳', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 5, 'parent_id' => 0, 'name' => '桌几', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 6, 'parent_id' => 0, 'name' => '灯具', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 7, 'parent_id' => 0, 'name' => '餐具', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['id' => 8, 'parent_id' => 0, 'name' => '装饰', 'image_url' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        // ];

        // $categoryId = 9;
        // foreach ($categories as $key => $value) {
        //     $subCategories = [];

        //     foreach (range(1, 22) as $index) {
        //         array_push($subCategories, [
        //             'id' => $categoryId,
        //             'parent_id' => $value['id'],
        //             'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
        //             'image_url' => $faker->imageUrl(),
        //             'created_at' => Carbon::now(),
        //             'updated_at' => Carbon::now()
        //         ]);
        //         $categoryId += 1;
        //     }
        //     $categories = array_merge($categories, $subCategories);
        // }

        // DB::table('brands')->insert($brands);
        // DB::table('categories')->insert($categories);

        $this->call(BrandSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(UserSeeder::class);
    }
}
