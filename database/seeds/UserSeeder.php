<?php

use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $users = [
            [
                'id'            => 1,
                'username'      => 'lijy91' ,
                'email'         => 'lijy91@foxmail.com',
                'name'          => '痕迹',
                'use_gravatar'  => true,
                'avatar_url'    => 'https://cn.gravatar.com/avatar/240166231aff9751cb1c91666f76f813',
                'site_admin'    => 1,
                'password'      => Hash::make('123456'),
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ];
        DB::table('users')->insert($users);
    }
}
