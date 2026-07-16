<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'category',
        'type',
        'cuisine',
        'price',
        'original_price',
        'rating',
        'review_count',
        'prep_time',
        'servings',
        'calories',
        'spice_level',
        'is_popular',
        'is_bestseller',
        'image',
        'description',
        'ingredients',
        'tags',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'tags' => 'array',
        'is_popular' => 'boolean',
        'is_bestseller' => 'boolean',
        'price' => 'integer',
        'original_price' => 'integer',
        'rating' => 'double',
        'review_count' => 'integer',
        'servings' => 'integer',
        'calories' => 'integer',
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
            return 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&q=80';
        }
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded[0] ?? 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=800&q=80';
        }
        return $value;
    }
}
