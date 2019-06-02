<?php

use App\Models\Brand;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
        $brands = [
            ['id' => 1, 'name' => '品牌1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => '品牌2', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];
        DB::table('brands')->insert($brands);
    }
}
