<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('holidu_booking_id')->nullable()->index()->after('ical_uid');
            $table->string('holidu_channel')->nullable()->after('holidu_booking_id');
            $table->decimal('paid_by_guest', 10, 2)->nullable()->after('number_of_guests');
            $table->decimal('home_owner_payout', 10, 2)->nullable()->after('paid_by_guest');
            $table->decimal('channel_commission', 10, 2)->nullable()->after('home_owner_payout');
            $table->decimal('bookiply_commission', 10, 2)->nullable()->after('channel_commission');
            $table->decimal('bookiply_processing_markup', 10, 2)->nullable()->after('bookiply_commission');
            $table->decimal('cedolare_secca', 10, 2)->nullable()->after('bookiply_processing_markup');
            $table->decimal('vat', 10, 2)->nullable()->after('cedolare_secca');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['holidu_booking_id']);
            $table->dropColumn([
                'holidu_booking_id',
                'holidu_channel',
                'paid_by_guest',
                'home_owner_payout',
                'channel_commission',
                'bookiply_commission',
                'bookiply_processing_markup',
                'cedolare_secca',
                'vat',
            ]);
        });
    }
};
