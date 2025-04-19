<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('guarantees', function (Blueprint $table) {
            $table->id();
            $table->string('corporate_reference_number')->unique(); // Unique identifier
            $table->enum('guarantee_type', ['Bank', 'Bid Bond', 'Insurance', 'Surety']);
            $table->decimal('nominal_amount', 15, 2); // Money amount
            $table->string('nominal_amount_currency', 3); // Currency code (e.g., USD)
            $table->date('expiry_date'); // Must be validated in controller/form
            $table->string('applicant_name');
            $table->text('applicant_address');
            $table->string('beneficiary_name');
            $table->text('beneficiary_address');
            $table->string('status')->default('draft'); // Options: draft, review, applied, issued
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guarantees');
    }
};
