<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //$this->call('UsersTableSeeder');

        //$this->command->info('User table seeded!');

        $this->call([
            UsersTableSeeder::class,
            ProgrammesTableSeeder::class,
            ApplicationsSeeder::class,
            AppliedProgrammesSeeder::class,
        ]);



    }
}
