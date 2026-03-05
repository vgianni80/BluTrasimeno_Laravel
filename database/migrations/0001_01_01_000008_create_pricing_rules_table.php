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
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['base', 'seasonal', 'weekend', 'special'])->default('base');
            $table->decimal('price_per_night', 10, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('days_of_week')->nullable(); // [0,1,2,3,4,5,6] dove 0=domenica
            $table->integer('priority')->default(0); // Più alto = priorità maggiore
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indici
            $table->index('type');
            $table->index('is_active');
            $table->index('priority');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_rules');
    }
};
