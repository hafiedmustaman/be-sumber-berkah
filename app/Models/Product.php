<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable untuk memberikan izin agar field-field dapat melakukan manipulasi data, seperti menambah data, edit, update dan juga hapus.
    protected $fillable = [
        'image', 'title', 'slug', 'category_id', 'content', 'weight', 'price', 'discount'
    ];

    /**
     * image
     *
     * @return Attribute
     */
    // function image() untuk mendapatkan full-path / URL dari image yang ada di dalam table products. Method tersebut bernama Accessor.
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => asset('/storage/products/' . $value),
        );
    }
}
