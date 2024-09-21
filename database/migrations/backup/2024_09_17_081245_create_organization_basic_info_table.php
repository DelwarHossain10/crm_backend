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
        Schema::create('organization_basic_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('priority_id');
            $table->unsignedBigInteger('zone_id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('information_source_id');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('prospect_status_id');
            $table->unsignedBigInteger('contacted_by_id');
            $table->text('note')->nullable();
            $table->string('attachment')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_basic_info');
    }
};
