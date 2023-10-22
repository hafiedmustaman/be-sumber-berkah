<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable digunakan untuk mengizinkan field-field yang ada di dalamnya agar bisa melakukan manipulasi data ke dalam table, seperti insert, edit, update dan delete.
    protected $fillable = [
        'province_id', 'city_id', 'name'
    ];
}
