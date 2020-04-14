<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => "admin",
            'email' => "admin@admin.com",
            'role_id' => "0",
            'email_verified_at' => now(),
            'password' => bcrypt("admin1234"), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
