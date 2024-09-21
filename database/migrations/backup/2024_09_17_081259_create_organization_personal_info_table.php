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
        Schema::create('organization_personal_info', function (Blueprint $table) {
            $table->id();
            $table->string('visiting_card')->nullable();
            $table->unsignedBigInteger('profession_id');
            $table->boolean('birthday_greetings')->default(false);
            $table->string('marital_status');
            $table->unsignedBigInteger('job_type_id');
            $table->date('date_of_birth');
            $table->unsignedBigInteger('gender_id');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_personal_info');
    }
};
