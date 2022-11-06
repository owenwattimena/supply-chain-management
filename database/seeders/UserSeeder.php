<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Owen Wattimena";
        $user->username = "wentoxwtt";
        $user->email = "wentoxwtt@gmail.com";
        $user->password = Hash::make('password');
        $user->role = "developer";
        $user->save();
    }
}
