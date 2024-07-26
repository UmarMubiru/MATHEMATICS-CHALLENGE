<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id('results_id'); // Primary key
            $table->string('participantName'); // Name or ID of the participant
            $table->string('schoolName'); // School of the participant
            $table->string('challengeName'); // Challenge name or ID
            $table->string('timeTaken'); // Time taken for the challenge (consider changing to integer for seconds or float for minutes)
            $table->string('questions'); // text column for questions
            $table->string('answers'); // text column for answers
            $table->integer('totalTime'); // time taken to complete challenge
            $table->integer('totalScore'); // Marks obtained
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
