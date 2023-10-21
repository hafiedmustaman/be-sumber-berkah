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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // field ini menggunakan type data string dan digunakan untuk menyimpan nama kategori.
            $table->string('slug'); // field ini menggunakan type data string dan digunakan untuk membuat URL kategori menjadi SEO friendly.
            $table->string('image'); // field ini menggunakan type data string dan digunakan untuk menyimpan data gambar dari kategori.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
