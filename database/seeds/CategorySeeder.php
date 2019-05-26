<?php

use App\Models\Category;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        Category::truncate();

        $path = 'database/seeds/yslbeauty-categories.json';
        $categories = json_decode(file_get_contents($path), true);

        $topLevelPosition = -1;
        foreach ($categories as $key => $value) {
            $position = 0;
            if (isset($value['parent_slug'])) {
                $topLevelPosition += 1;

                $position = $topLevelPosition;
            }

            if (isset($value['parent_slug'])) {
                $category = Category::where('slug', $value['parent_slug'])->first();

                $value['parent_id'] = $category->id;
                $value['level'] = $category->level + 1;

                unset($value['parent_slug']);

                $position = Category::where('parent_id', $category->id)->count();
            }

            Category::updateOrCreate(
                [
                    'store_id' => 1,
                    'slug' => $value['slug'],
                    'position' => $position,
                ],
                $value
            );
        }
    }
}
