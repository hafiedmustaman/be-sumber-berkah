<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable digunakan agar field-field yang dimasukkan di dalam array tersebut dapat melakukan manipulasi data ke dalam table di database.
    protected $fillable = [
        'province_id', 'name'
    ];
}
