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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // field ini menggunakan type data string dan digunakan untuk menyimpan gambar dari produk.
            $table->string('title'); // field ini menggunakan type data string dan digunakan untuk menyimpan judul dari produk.
            $table->string('slug'); // field ini menggunakan type data string dan digunakan untuk membuat URL produk agar lebih SEO friendly.
            $table->unsignedBigInteger('category_id'); // field ini menggunakan type data unsignedBigInteger dan ini akan digunakan untuk melakukan relasi dengan table categories.
            $table->text('content'); // field ini menggunakan type data text dan digunakan untuk menyimpan deskripsi dari produk.
            $table->bigInteger('weight'); // field ini menggunakan type data biginteger dan digunakan untuk menyimpan berat dari produk.
            $table->bigInteger('price'); // field ini menggunakan type data bigInteger dan digunakan untuk menyimpan harga dari produk.
            $table->integer('discount')->nullable(); // field ini menggunakan type data integer dan di set menjadi nullable, yang artinya boleh di isi dan juga boleh di kosongi atau null, field ini digunakan untuk menentukan berapa % discount produk yang akan dijual.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
