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
        Schema::create('usermetas', function (Blueprint $table) {
            $table->id();
            $table->integer('uid');
            $table->string('designation',100);
            $table->string('adhar')->unique();
            $table->timestamp('adhar_verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usermetas');
    }
};
