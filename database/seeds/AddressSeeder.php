<?php

use App\Models\Address;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::truncate();

        if (env('APP_ENV') == 'local') {
            factory(Address::class, 30)->create();
        }
    }
}
