<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable digunakan agar field-field yang di tentukan dapat memanipulasi data ke dalam database, seperti insert, edit, update dan delete data.
    protected $fillable = [
        'image', 'link'
    ];

    /**
     * image
     *
     * @return Attribute
     */
    // function image() digunakan untuk mengambil full PATH / URL image untuk data slider.
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/sliders/' . $value),
        );
    }
}
