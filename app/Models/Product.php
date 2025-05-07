<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'has_warranty' => 'boolean',
        'is_negotiable' => 'boolean',
        'is_verified' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getConditionLabelAttribute()
    {
        return match ($this->condition) {
            'like_new' => 'Like New',
            'excellent' => 'Excellent',
            'good' => 'Good',
            'fair' => 'Fair',
            'poor' => 'Poor',
            default => 'Unknown'
        };
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->original_price) {
            return 0;
        }
        return round((($this->original_price - $this->price) / $this->original_price) * 100);
    }

    public function getPriceHistoryAttribute()
    {
        // TODO: Implement price history tracking
        return [];
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeNegotiable($query)
    {
        return $query->where('is_negotiable', true);
    }

    public function scopeWithWarranty($query)
    {
        return $query->where('has_warranty', true);
    }
}