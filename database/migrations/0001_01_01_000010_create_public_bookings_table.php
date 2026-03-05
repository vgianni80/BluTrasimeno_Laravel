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
        Schema::create('public_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('guest_name');
            $table->string('guest_surname');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('guests')->default(1);
            $table->text('notes')->nullable();
            $table->decimal('total', 10, 2);
            $table->json('price_breakdown')->nullable(); // Dettaglio calcolo prezzo
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'cancelled'])->default('pending');
            $table->text('admin_notes')->nullable(); // Note admin (es. motivo rifiuto)
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete(); // Collegamento a booking se confermato
            $table->timestamps();

            // Indici
            $table->index('status');
            $table->index(['check_in', 'check_out']);
            $table->index('guest_email');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_bookings');
    }
};
