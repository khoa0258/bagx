<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1)
                    ->where('start_date', '<=', Carbon::now())
                    ->where('end_date', '>=', Carbon::now());
    }

    public function isValid($orderAmount = 0)
    {
        // Kiểm tra trạng thái
        if ($this->status != 1) return false;
        
        // Kiểm tra thời gian
        $now = Carbon::now();
        if ($this->start_date > $now || $this->end_date < $now) return false;
        
        // Kiểm tra giới hạn sử dụng
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        
        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) return false;
        
        return true;
    }

    public function getDiscountAmount($orderAmount)
    {
        if (!$this->isValid($orderAmount)) return 0;
        
        if ($this->type == 1) { // percentage
            return $orderAmount * ($this->value / 100);
        } else { // fixed amount
            return min($this->value, $orderAmount);
        }
    }
}
