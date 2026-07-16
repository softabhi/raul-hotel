<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'subtotal',
        'tax',
        'delivery_charge',
        'total',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'subtotal' => 'integer',
        'tax' => 'integer',
        'delivery_charge' => 'integer',
        'total' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
