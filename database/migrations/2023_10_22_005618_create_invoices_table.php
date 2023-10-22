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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->text('invoice'); // field ini menggunakan type data string, dan ini akan digunakan untuk menyimpan no. invoice dari pemesanan.
            $table->unsignedBigInteger('customer_id'); // field ini menggunakan type data unsignedBigInteger dan ini akan digunakan untuk relasi dengan table customers.
            $table->string('courier'); // field ini menggunakan type data string dan ini akan digunakan untuk menyimpan jenis kurir yang digunakan.
            $table->string('service'); // field ini menggunakan type data strring dan ini akan digunakan untuk menyimpan data layanan kurir, contohnya misalkan JNE, ada layanan REG, OKE dan lain-lain.
            $table->bigInteger('cost_courier'); // field ini menggunakan type data bigInteger dan digunakan untuk menyimpan biaya dari ongkos kirim.
            $table->integer('weight'); // field ini menggunakan type data integer dan digunakan untuk menyimpan berat dar product yang di pesan, karena ini akan dijadikan acuan untuk menghitung biaya ongkos kirim.
            $table->string('name'); // field ini menggunakan type data string dan digunakan untuk menyimpan nama dari pemesan.
            $table->bigInteger('phone'); // field ini menggunakan type data bigInteger dan digunakan untuk menyimpan no. telepon dari pemesan.
            $table->integer('province'); //  field ini menggunakan type data integer dan digunakan untuk menyimpan ID provinsi dari pemesan.
            $table->integer('city'); //  field ini menggunakan type data integer dan digunakan untuk menyimpan ID kota dari pemesan.
            $table->text('address'); // field ini menggunakan type data text dan digunakan untuk menyimpan alamat lengkap dari pemesan.
            $table->enum('status', array('pending', 'success', 'failed', 'expired')); // field ini menggunakan type data enum dan untuk isinya adalah, pending, success, expired dan failed. Field ini akan otomatis update dengan response yang di dapatkan dari payment gateway (Midtrans).
            $table->string('snap_token')->nullable(); //  field ini menggunakan type data string dan ini akan digunakan untuk menyimpan snap token yang di generate dari payment gateway dan ini kita jadikan nullable yang artinya tidak wajib diisi.
            $table->bigInteger('grand_total'); // field ini menggunakan type data bigInteger dan digunakan untuk menyimpan total dari pemesan.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
