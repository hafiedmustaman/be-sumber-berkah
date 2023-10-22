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
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('province_id'); // field ini menggunakan type data unsignedInteger dan digunakan untuk menyimpan ID provinsi.
            $table->string('name'); // field ini menggunakan type data string dan digunakan untuk menyimpan nama provinsi.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};
