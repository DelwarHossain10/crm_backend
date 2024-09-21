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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('type')->nullable();
            $table->string('priority', 191)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->time('due_time')->nullable();
            $table->unsignedInteger('prospect_id')->nullable();
            $table->string('assign_to', 191)->nullable();
            $table->string('contact')->nullable();
            $table->unsignedBigInteger('lead_id')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status', 191)->nullable();
            $table->text('description')->nullable();
            $table->text('template')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
