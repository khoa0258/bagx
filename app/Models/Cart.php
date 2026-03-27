<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_variant',
        'quantity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_variant');
    }

    public function getTotalPriceAttribute()
    {
        return $this->variant->price * $this->quantity;
    }
}
