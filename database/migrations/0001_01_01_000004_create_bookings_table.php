<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ical_source_id')->nullable()->constrained('ical_sources')->nullOnDelete();
            $table->string('ical_uid')->nullable()->index();
            
            // Date soggiorno
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('number_of_guests')->nullable();
            
            // Dati ospite principale
            $table->string('guest_name')->nullable();
            $table->string('guest_surname')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            
            // Check-in online
            $table->string('checkin_token', 64)->nullable()->unique();
            $table->timestamp('checkin_completed_at')->nullable();
            $table->timestamp('checkin_link_expires_at')->nullable();
            
            // Stato: incomplete, complete, checked_in, sent, failed
            $table->string('status')->default('incomplete');
            
            // AlloggiatiWeb
            $table->timestamp('sent_to_alloggiatiweb_at')->nullable();
            $table->integer('send_attempts')->default(0);
            $table->text('last_error')->nullable();
            
            // Extra
            $table->text('notes')->nullable();
            $table->json('ical_raw_data')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'check_in']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
