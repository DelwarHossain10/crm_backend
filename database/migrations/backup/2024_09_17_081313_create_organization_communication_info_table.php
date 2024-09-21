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
        Schema::create('organization_communication_info', function (Blueprint $table) {
            $table->id();
            $table->string('contact_no');
            $table->string('fax')->nullable();
            $table->string('social_network')->nullable();
            $table->string('email');
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_communication_info');
    }
};
