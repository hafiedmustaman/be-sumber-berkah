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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // field ini menggunakan type data string dan digunakan untuk menyimpan nama customer.
            $table->string('email')->unique(); // field ini menggunakan type data string dan menggunakan unique yang artinya isi dari field ini tidak boleh ada yang sama.
            $table->timestamp('email_verified_at')->nullable(); // field ini menggunakan type data timestamp dan digunakan untuk mendapatkan tanggal saat email berhasil di verifikasi.
            $table->string('password'); // field ini menggunakan type data string dan digunakan untuk menyimpan data password.
            $table->rememberToken(); // field ini akan digunakan untuk menyimpan token saat melakukan reset password.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
