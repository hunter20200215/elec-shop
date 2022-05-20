<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'full_name' => 'Daniel Massicotte',
            'email' => 'danielmassicotte@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('kogctszs'),
            'created_at' => Carbon::now(),
        ]);
    }
}
