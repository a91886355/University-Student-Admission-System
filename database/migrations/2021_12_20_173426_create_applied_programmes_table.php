<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppliedProgrammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applied_programmes', function (Blueprint $table) {
            $table->id();

            $table->integer('applicationID');

            $table->enum('rank',['1','2','3']);
            $table->string('appliedProgramme',100);
            $table->enum('appliedYear',['1','3']);
            $table->enum('status',['Processing','Approved','Rejected']);
            $table->enum('autoAssigned',['true','false'])->default('false');
            $table->enum('changingTime',['true','false'])->default('false');
            

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
        Schema::dropIfExists('applied_programmes');
    }
}
