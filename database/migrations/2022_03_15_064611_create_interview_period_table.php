<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_period', function (Blueprint $table) {
            $table->id();

            $table->integer('timePeriodId');
            $table->string('timePeriod');
            $table->string('timeSlot');
            $table->integer('programmeId');
            $table->date('interviewDate');
            $table->string('interviewVenue',50);
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
        Schema::dropIfExists('interview_period');
    }
}
