<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        DB::table('users')->delete();
        User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'email_verified_at' => now()->toDateTimeString(), 'password' => Hash::make('adminadmin'), 'role' => 'admin']);
        User::create(['name' => 'Officer', 'email' => 'officer@example.com', 'email_verified_at' => now()->toDateTimeString(), 'password' => Hash::make('officerofficer'), 'role' => 'officer']);
        User::create(['name' => 'Terry Wong', 'email' => 'terrywong@gmail.com', 'email_verified_at' => now()->toDateTimeString(), 'password' => Hash::make('12345678'), 'role' => 'user']);
        User::create(['name' => 'Tom Don', 'email' => 'tomdon@gmail.com', 'email_verified_at' => now()->toDateTimeString(), 'password' => Hash::make('12345678'), 'role' => 'user']);
    }
}
