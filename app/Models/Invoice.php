<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    // $fillable difungsikan agar field-field tersebut dapat memanipulasi data ke dalam table database.
    protected $fillable = [
        'invoice', 'customer_id', 'courier', 'service', 'cost_courier', 'weight', 'name', 'phone', 'province', 'city', 'address', 'status', 'snap_token', 'grand_total'
    ];

    /**
     * order
     *
     * @return void
     */
    // digunakan dan difungsikan untuk memberitahukan ke sistem, bahwa kita akan membuat relasi Many ke model Order atau table orders.
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
