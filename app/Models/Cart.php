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
}
