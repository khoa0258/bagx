<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'estimated_days',
        'status',
        'sort'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_shipping_method');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('sort');
    }
}
