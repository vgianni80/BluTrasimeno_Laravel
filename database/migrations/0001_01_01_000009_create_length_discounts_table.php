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
        Schema::create('length_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // es. "Sconto settimanale", "Sconto mensile"
            $table->integer('min_nights'); // Numero minimo di notti per applicare lo sconto
            $table->decimal('discount_percent', 5, 2); // Percentuale di sconto (es. 10.00 = 10%)
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indici
            $table->index('min_nights');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('length_discounts');
    }
};
