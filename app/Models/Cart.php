<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable difungsikan agar field-field yang dimasukkan di dalam array tersebut dalam melakukan manipulasi data ke dalam table database.
    protected $fillable = [
        'product_id', 'customer_id', 'price', 'quantity', 'weight'
    ];

    /**
     * product
     *
     * @return void
     */
    // difungsikan dan digunakan untuk memberitahu kepada sistem, bahwa model Cart atau table carts ini dimiliki dan terhubung dengan model Product atau table products.
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
