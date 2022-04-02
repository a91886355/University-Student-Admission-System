<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\AppliedProgramme;

class AppliedProgrammesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('applied_programmes')->delete();
        
        DB::table('applied_programmes')->insert([
            'applicationID' => '2',
            'rank' => '1',
            'appliedProgramme' => 'Computer Science',
            'appliedYear' => '3',
            'status' => 'Processing',
            'autoAssigned' => 'false',
            'changingTime' => 'false',
        ]);

        DB::table('applied_programmes')->insert([
            'applicationID' => '2',
            'rank' => '2',
            'appliedProgramme' => 'Business Computing and Data Analytics',
            'appliedYear' => '1',
            'status' => 'Processing',
            'autoAssigned' => 'false',
            'changingTime' => 'false',
        ]);

        DB::table('applied_programmes')->insert([
            'applicationID' => '2',
            'rank' => '3',
            'appliedProgramme' => 'Mathematics and Statistics',
            'appliedYear' => '1',
            'status' => 'Processing',
            'autoAssigned' => 'false',
            'changingTime' => 'false',
        ]);

    }
}
