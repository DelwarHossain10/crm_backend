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
        Schema::create('initial_info', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('project_name');
            $table->foreignId('service_id')->constrained('services');
            $table->foreignId('info_source_id')->constrained('info_sources');
            $table->foreignId('organization_type_id')->constrained('organization_types');
            $table->foreignId('campaign_id')->nullable()->constrained('campaigns');
            $table->text('note')->nullable();
            $table->foreignId('industry_type_id')->constrained('industry_types');
            $table->string('organization_name');
            $table->foreignId('prospect_assigned_to_id')->constrained('users');
            $table->foreignId('contacted_by_id')->constrained('users');
            $table->string('attactment')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('initial_info');
    }
};
