<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            \App\Models\User::create([
                'name' => 'Yusuf Sanusi',
                'email' => 'user@example.com',
                'password' => bcrypt('secret')
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
