<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            
            // Dati anagrafici
            $table->string('nome');
            $table->string('cognome');
            $table->enum('sesso', ['M', 'F']);
            $table->date('data_nascita');
            $table->string('comune_nascita');
            $table->string('provincia_nascita', 2)->nullable();
            $table->string('stato_nascita')->default('ITALIA');
            $table->string('cittadinanza');
            
            // Documento
            $table->string('tipo_documento'); // carta_identita, passaporto, patente, altro
            $table->string('numero_documento');
            $table->string('rilasciato_da')->nullable();
            $table->date('data_rilascio')->nullable();
            $table->date('data_scadenza')->nullable();
            
            // Flag
            $table->boolean('is_capogruppo')->default(false);
            
            $table->timestamps();
            
            $table->index('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guests');
    }
};
