<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; // import Foundation Auth Laravel

class Customer extends Authenticatable // Authenticatable digunakan untuk melakukan Authentication.
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable digunakan untuk mengizinkan field-field di dalam table dapat memanipulasi data, seperti insert, read, edit, update dan delete.
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // $hidden digunakan untuk menyembunyikan field-field saat ada request ke dalam table customers
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * invoice
     *
     * @return void
     */
    // digunakan untuk memberitahukan ke sistem bahwa model Customer atau table customers ini akan membuat relasi Many ke model Invoice atau table invoices.
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * carts
     *
     * @return void
     */
    // digunakan untuk memberitahukan ke sistem bahwa model Customer atau table customers ini akan membuat relasi Many ke model Cart atau table carts.
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
