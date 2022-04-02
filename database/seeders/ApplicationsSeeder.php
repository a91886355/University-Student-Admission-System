<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Application;
use Carbon\Carbon;

class ApplicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('applications')->delete();
        
        DB::table('applications')->insert([
            'user_id' => '20220003',
            'personalFilled' => 'true',
            'englishName' => 'Terry Wong',
            'chineseName' => '王大明',
            'sex' => 'male',
            'dateOfBirth' => Carbon::parse('2000-01-01'),
            'nationality' => 'Hong Kong',
            'homephoneNumber' => '27208888',
            'mobileNumber' => '91886333',
            'mailingAddress' => 'Flat D 5/F Yu Shing Building',
            'acadeFilled' => 'true',
            'secondaryCountry' => 'Hong Kong',
            'secondarySchool' => 'Ying Wa College',
            'secondaryAdmission' => Carbon::parse('2000-01-01'),
            'secondaryCompletion' => Carbon::parse('2018-06-30'),
            'postCountry' => 'Hong Kong',
            'postSchool' => 'Hong Kong Institute of Vocational Education',
            'postProgramme' => 'Networking & Telecommunications',
            'postQualification' => 'hd',
            'postMode' => 'fullTime',
            'postCgpa' => 3.50,
            'postMaxCgpa' => 4.00,
            'postAdmission' => Carbon::parse('2018-06-30'),
            'postCompletion' => Carbon::parse('2020-06-30'),
        ]);

        DB::table('applications')->insert([
            'user_id' => '20220004',
            'personalFilled' => 'true',
            'englishName' => 'Tom Don',
            'chineseName' => '',
            'sex' => 'male',
            'dateOfBirth' => Carbon::parse('2000-01-01'),
            'nationality' => 'Hong Kong',
            'homephoneNumber' => '27208888',
            'mobileNumber' => '91886333',
            'mailingAddress' => 'Flat D 5/F Yu Shing Building',
            'acadeFilled' => 'true',
            'secondaryCountry' => 'Hong Kong',
            'secondarySchool' => 'Ying Wa College',
            'secondaryAdmission' => Carbon::parse('2000-01-01'),
            'secondaryCompletion' => Carbon::parse('2018-06-30'),
            'postCountry' => 'Hong Kong',
            'postSchool' => 'Hong Kong Institute of Vocational Education',
            'postProgramme' => 'Networking & Telecommunications',
            'postQualification' => 'hd',
            'postMode' => 'fullTime',
            'postCgpa' => 3.00,
            'postMaxCgpa' => 4.00,
            'postAdmission' => Carbon::parse('2018-06-30'),
            'postCompletion' => Carbon::parse('2020-06-30'),
        ]);
    }
}
