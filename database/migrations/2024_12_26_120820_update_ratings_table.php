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
        Schema::table('ratings', function (Blueprint $table) {
            $table->renameColumn('rider_id', 'booking_id');
            $table->text('comment')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratings', function (Blueprint $table) {
            // Revert 'booking_id' back to 'rider_id'
            $table->renameColumn('booking_id', 'rider_id');

            // Drop the 'comment' column
            $table->dropColumn('comment');
        });
    }
};
