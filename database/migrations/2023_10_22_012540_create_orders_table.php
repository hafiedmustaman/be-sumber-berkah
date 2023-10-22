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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id'); // field ini menggunakan type data unsignedBigInteger dan ini akan digunakan untuk melakukan relasi dengan table invoices.
            $table->string('invoice'); // field ini menggunakan type data string dan digunakan untuk menyimpan no. invoice.
            $table->unsignedBigInteger('product_id'); // field ini menggunakan type data unsignedBigInteger dan digunakan untuk relasi dengan table products.
            $table->string('product_name'); // field ini menggunakan type data string dan digunakan untuk menyimpan nama product.
            $table->string('image'); // field ini menggunakan type data string dan digunakan untuk menyimpan nama image dari product.
            $table->integer('qty'); // field ini menggunakan type data integer dan digunakan untuk menyimpan jumlah quantity dari product yang dipesan.
            $table->integer('price'); // field ini menggunakan type data integer dan digunakan untuk menyimpan harga dari product yang dipesan.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
