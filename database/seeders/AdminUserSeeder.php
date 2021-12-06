<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Josue Barros',
            'email' => 'joshbarrosweb@gmail.com',
            'password' => bcrypt("VUB28pbRSn8mdR2F"),
            'username' => 'joshbarrosweb',
            'role_id' => 1
        ]);
    }
}
