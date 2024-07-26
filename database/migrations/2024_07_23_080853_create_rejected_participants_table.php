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
        Schema::create('rejected_participants', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->string('username');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('emailAddress')->unique(); // Unique constraint for email addresses
            $table->date('dateOfBirth');
            $table->string('schoolRegistrationNumber');
            $table->string('imageFileName');
            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejected_participants');
    }
};
