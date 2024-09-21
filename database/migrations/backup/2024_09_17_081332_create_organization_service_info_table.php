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
        Schema::create('organization_service_info', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('industry_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('district_id');
            $table->string('zip');
            $table->decimal('latitude', 10, 7);
            $table->string('skype')->nullable();
            $table->string('social_network')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('income_range_id');
            $table->text('address');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('thana_id');
            $table->string('website')->nullable();
            $table->decimal('longitude', 10, 7);
            $table->string('phone');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_service_info');
    }
};
