<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\Programme;

class ProgrammesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('programmes')->delete();
        
        DB::table('programmes')->insert([ //arts
            'category' => 'Arts',
            'name' => 'Chinese Language and Literature',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Arts',
            'name' => 'Creative and Professional Writing',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Arts',
            'name' => 'English Language and Literature',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Arts',
            'name' => 'Humanities',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Arts',
            'name' => 'Music',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Arts',
            'name' => 'Religion, Philosophy and Ethics',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Arts',
            'name' => 'Translation',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Arts',
            'name' => 'Creative Industries',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);

        DB::table('programmes')->insert([ //Business
            'category' => 'Business',
            'name' => 'Accounting Concentration',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([ 
            'category' => 'Business',
            'name' => 'Economics and Data Analytics Concentration',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([ 
            'category' => 'Business',
            'name' => 'Entrepreneurship and Business Innovation Concentration',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([ 
            'category' => 'Business',
            'name' => 'Finance Concentration',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([ 
            'category' => 'Business',
            'name' => 'Human Resources Management Concentration',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([ 
            'category' => 'Business',
            'name' => 'Information Systems and Business Intelligence Concentration',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([ 
            'category' => 'Business',
            'name' => 'Marketing Concentration',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([ 
            'category' => 'Business',
            'name' => 'Business Computing and Data Analytics',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);

        DB::table('programmes')->insert([ //science
            'category' => 'Science',
            'name' => 'Analytical and Testing Sciences',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Science',
            'name' => 'Applied Biology',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Science',
            'name' => 'Bioresource and Agricultural Science',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Science',
            'name' => 'Chemistry',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Science',
            'name' => 'Computer Science',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Science',
            'name' => 'Mathematics and Statistics',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
        DB::table('programmes')->insert([
            'category' => 'Science',
            'name' => 'Physics and Green Energy Science',
            'year1RequiredCgpa' => 3,
            'year3RequiredCgpa' => 3.3,
        ]);
    }
}
