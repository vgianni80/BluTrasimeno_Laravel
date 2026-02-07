<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ical_source_id')->constrained('ical_sources')->cascadeOnDelete();
            $table->timestamp('synced_at');
            $table->string('status'); // success, error
            $table->text('message')->nullable();
            $table->integer('bookings_found')->default(0);
            $table->integer('bookings_created')->default(0);
            $table->integer('bookings_updated')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_logs');
    }
};
