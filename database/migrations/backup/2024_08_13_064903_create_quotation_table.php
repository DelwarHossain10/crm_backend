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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number');
            $table->date('quotation_date');
            $table->string('quotation_subject');
            $table->unsignedBigInteger('prospect_id');
            $table->unsignedBigInteger('lead_id');
            $table->string('attention_person')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->decimal('quoted_amount', 15, 2);
            $table->boolean('quotation_sent')->default(false);
            $table->text('quotation_description')->nullable();
            $table->decimal('sub_total', 15, 2)->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('amount_after_discount', 15, 2)->nullable();
            $table->decimal('vat', 15, 2)->nullable();
            $table->decimal('alt', 15, 2)->nullable();
            $table->decimal('grand_total', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
