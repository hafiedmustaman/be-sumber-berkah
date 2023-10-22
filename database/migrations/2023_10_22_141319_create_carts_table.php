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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('product_id'); // field ini menggunakan type data unsignedInteger dan digunakan untuk menyimpan product_id dan melakukan relasi dengan table products.
            $table->unsignedInteger('customer_id'); // field ini menggunakan type data unsignedInteger dan digunakan untuk menyimpan customer_id dan melakukan relasi dengan table customers.
            $table->integer('quantity'); // field ini menggunakan type data integer dan digunakan untuk menyimpan jumlah dari pesanan yang dimasukkan ke cart.
            $table->bigInteger('price'); // field ini menggunakan type data bigInteger dan digunakan untuk menyimpan harga dari product yang dipesan.
            $table->bigInteger('weight'); // field ini menggunakan type data bigInteger dan digunakan untuk menyimpan berat dari product yang dipesan.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
