<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id');

            $table->enum('personalFilled',['true','false'])->nullable();
            //Personal Information
            $table->string('englishName',50)->nullable();
            $table->string('chineseName',5)->nullable();
            $table->enum('sex',['male','female'])->nullable();
            $table->date('dateOfBirth')->nullable();
            $table->string('nationality',50)->nullable();

            //Contact
            $table->string('homephoneNumber',20)->nullable();
            $table->string('mobileNumber',20)->nullable();
            $table->string('mailingAddress',80)->nullable();

            //Academic Profile
            $table->enum('acadeFilled',['true','false'])->nullable();
            //Secondary Education
            $table->string('secondaryCountry',50)->nullable();
            $table->string('secondarySchool',50)->nullable();
            $table->date('secondaryAdmission')->nullable();
            $table->date('secondaryCompletion')->nullable();

            //Post-Secondary Education
            $table->string('postCountry',50)->nullable();
            $table->string('postSchool',50)->nullable();
            $table->string('postProgramme',50)->nullable();
            $table->enum('postQualification',['hd',"asso",'degree'])->nullable();
            $table->enum('postMode',['fullTime','partTime'])->nullable();
            $table->double('postCgpa',3,2)->nullable();
            $table->double('postMaxCgpa',3,2)->nullable();
            $table->date('postAdmission')->nullable();
            $table->date('postCompletion')->nullable();
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
