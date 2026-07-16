<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'check_in',
        'check_out',
        'guests',
        'nights',
        'subtotal',
        'gst',
        'total',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'guests' => 'integer',
        'nights' => 'integer',
        'subtotal' => 'integer',
        'gst' => 'integer',
        'total' => 'integer',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
