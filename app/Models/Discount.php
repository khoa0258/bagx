<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'value',
        'type',
        'start_date',
        'end_date',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'id_discount');
    }

    // Helper methods
    public function isActive()
    {
        return $this->status == 1 && 
               now()->between($this->start_date, $this->end_date);
    }

    public function calculateDiscount($price)
    {
        if (!$this->isActive()) {
            return $price;
        }

        if ($this->type === 'percent') {
            return $price - ($price * $this->value / 100);
        }

        return $price - $this->value;
    }
}
