<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable difungsikan untuk mengizinkan field-field agar bisa memanipulasi data ke dalam database.
    protected $fillable = [
        'invoice_id', 'invoice', 'product_id', 'product_name', 'image', 'qty', 'price'
    ];
}
