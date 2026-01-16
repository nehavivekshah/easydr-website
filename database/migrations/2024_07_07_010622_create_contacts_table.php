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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('branch');
            $table->string('name',100);
            $table->string('company',100);
            $table->string('email',100);
            $table->string('mobile',100);
            $table->string('address',100);
            $table->string('city',100);
            $table->string('state',100);
            $table->string('country',100);
            $table->string('socials',1000);
            $table->string('status',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
