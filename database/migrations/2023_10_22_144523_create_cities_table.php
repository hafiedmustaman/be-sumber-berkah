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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('province_id'); // field ini menggunakan type data unsignedInteger dan digunakan untuk menyimpan ID provinsi.
            $table->unsignedInteger('city_id'); // field ini menggunakan type data unsignedInteger dan digunakan untuk menyimpan ID city / kota.
            $table->string('name'); // field ini menggunakan type data srting dan digunakan untuk menyimpan nama city / kota.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
