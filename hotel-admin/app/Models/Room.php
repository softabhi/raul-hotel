<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'price',
        'original_price',
        'capacity',
        'size',
        'bed',
        'floor',
        'view',
        'rating',
        'review_count',
        'available',
        'image',
        'amenities',
        'description',
        'highlights',
    ];

    protected $casts = [
        'amenities' => 'array',
        'highlights' => 'array',
        'available' => 'boolean',
        'price' => 'integer',
        'original_price' => 'integer',
        'capacity' => 'integer',
        'rating' => 'double',
        'review_count' => 'integer',
    ];

    public function getImagesAttribute()
    {
        $value = $this->attributes['image'] ?? null;
        if (empty($value)) {
            return [];
        }
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }
        return [$value];
    }

    public function getImageAttribute($value)
    {
        if (empty($value)) {
            return 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80';
        }
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded[0] ?? 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&q=80';
        }
        return $value;
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
