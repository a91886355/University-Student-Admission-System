<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgrammesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programmes', function (Blueprint $table) {
            $table->id();

            $table->enum('category', ['Arts','Business','Chinese Medicine','Communication and Film','Science','Social Sciences','Visual Arts']); //category, name, required CGPA 
            $table->string('name');
            $table->double('year1RequiredCgpa',3,2)->nullable();
            $table->double('year3RequiredCgpa',3,2)->nullable();

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
        Schema::dropIfExists('programmes');
    }
}
