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
        Schema::create('concern_person', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->date('date_of_birth')->nullable();
            $table->foreignId('role_id')->constrained('roles');
            $table->foreignId('job_type_id')->constrained('job_types');
            $table->string('gender')->nullable();
            $table->string('social_network')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('designation_id')->constrained('designations');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('profession_id')->constrained('professions');
            $table->string('attactment')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concern_person');
    }
};
