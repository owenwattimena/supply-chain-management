<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *  3_$%*t(0],&j
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Owen Wattimena";
        $user->username = "wentoxwtt";
        $user->password = Hash::make('password');
        $user->role = "developer";
        $user->save();

        $user = new User;
        $user->name = "Admin";
        $user->username = "admin";
        $user->password = Hash::make('password');
        $user->role = "admin";
        $user->save();

        $user = new User;
        $user->name = "Manager";
        $user->username = "manager";
        $user->password = Hash::make('password');
        $user->role = "manager";
        $user->save();

        $user = new User;
        $user->name = "Supplier Pasir";
        $user->username = "supplier_pasir";
        $user->password = Hash::make('password');
        $user->role = "supplier_pasir";
        $user->save();

        $user = new User;
        $user->name = "Stockpile";
        $user->username = "stockpile";
        $user->password = Hash::make('password');
        $user->role = "stockpile";
        $user->save();
        
        $user = new User;
        $user->name = "PT Lamco";
        $user->username = "user_lamco";
        $user->password = Hash::make('password');
        $user->role = "pt_lamco";
        $user->save();
   
        $user = new User;
        $user->name = "Produksi";
        $user->username = "produksi";
        $user->password = Hash::make('password');
        $user->role = "produksi";
        $user->save();
    }
}
