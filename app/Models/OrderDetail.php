<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'orders_details';

    protected $fillable = [
        'id_order', // Sửa thành id_order để khớp với bảng
        'id_variant', // Sửa thành id_variant
        'quantity',
        'price',
        'created_at',
        'updated_at'
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'id_variant', 'id')->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id');
    }
}