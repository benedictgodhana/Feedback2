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
        Schema::create('user_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('surname');
        $table->string('otherNames');
        $table->string('dept');
        $table->string('employmentType')->nullable();
        $table->string('employeeNo');
        $table->date('dateOfBirth');
        $table->string('sex');
        $table->string('religion');
        $table->string('telR');
        $table->string('telCell');
        $table->string('currentAddress');
        $table->string('residence')->nullable();
        $table->string('postalAddress')->nullable();
        $table->string('homeDistrict')->nullable();
        $table->string('fatherName')->nullable();
        $table->date('fatherDOB')->nullable();
        $table->string('fatherOccupation')->nullable();
        $table->string('motherName')->nullable();
        $table->date('motherDOB')->nullable();
        $table->string('motherOccupation')->nullable();
        $table->string('maritalStatus');
        $table->string('spouseName')->nullable();
        $table->date('dateOfMarriage')->nullable();
        $table->string('spouseTel')->nullable();
        $table->json('children')->nullable();
        $table->json('siblings')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
