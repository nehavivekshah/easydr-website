<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('store_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->decimal('total_amount', 8, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['store_id', 'supplier_id', 'total_amount']);
        });
    }
};
