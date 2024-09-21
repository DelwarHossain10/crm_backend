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
        Schema::create('prospect_master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('initial_info_id')->constrained('initial_info')->onDelete('cascade');
            $table->foreignId('concern_person_id')->constrained('concern_person')->onDelete('cascade');
            $table->foreignId('organization_address_id')->constrained('organization_address')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prospect_master');
    }
};
