<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('meeting_provider')->nullable()->after('payment_status'); // e.g., google_meet, whatsapp, in_person
            $table->text('meeting_link')->nullable()->after('meeting_provider'); // URL or Phone Number
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('meeting_provider');
            $table->dropColumn('meeting_link');
        });
    }
};
