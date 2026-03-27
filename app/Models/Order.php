<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'id_user',
        'name',
        'phone',
        'address',
        'note',
        'total_price',
        'status',
        'thanh_toan',
        'id_payment',
        'order_date',
        'first_name',
        'last_name',
        'email',
    ];

    protected $casts = [
        'status'     => 'integer',
        'thanh_toan' => 'integer',
        'order_date' => 'datetime',
    ];

    // Hiển thị các accessor khi ->toArray() / ->toJson()
    protected $appends = [
        'status_text',
        'payment_status_text',
        'formatted_order_date',
        'payment_method_text',
    ];

    // Trạng thái đơn hàng
    public const STATUSES = [
        0 => 'Đã hủy',
        1 => 'Đang xử lý',
        2 => 'Đang giao',
        3 => 'Hoàn thành',
    ];

    // Trạng thái thanh toán
    public const PAYMENT_STATUSES = [
        0 => 'Chưa thanh toán',
        1 => 'Đã thanh toán',
    ];

    // Mapping PHƯƠNG THỨC THEO ID: 0 = VNPAY, 1 = COD
    public const PAYMENT_LABELS_BY_ID = [
        0 => 'Thanh toán online (VNPAY)',
        1 => 'Thanh toán khi nhận hàng',
    ];

    /** Quan hệ User */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /** Quan hệ Payment (chỉ rõ FK: id_payment -> payments.id) */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'id_payment', 'id');
    }

    /** Quan hệ chi tiết đơn */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'id_order');
    }

    /** Accessor: trạng thái đơn */
    public function getStatusTextAttribute(): string
    {
        return self::STATUSES[$this->status] ?? 'Không xác định';
    }

    /** Accessor: trạng thái thanh toán */
    public function getPaymentStatusTextAttribute(): string
    {
        return self::PAYMENT_STATUSES[$this->thanh_toan] ?? 'Không xác định';
    }

    /** Accessor: định dạng ngày đặt hàng */
    public function getFormattedOrderDateAttribute(): string
    {
        return $this->order_date ? $this->order_date->format('d/m/Y H:i') : 'Không xác định';
    }

    /**
     * Accessor: phương thức thanh toán thân thiện
     * Ưu tiên map theo ID (0=VNPAY, 1=COD). Nếu có tên trong bảng payments thì dùng tên để nhận diện.
     * Không trả về "N/A".
     */
    public function getPaymentMethodTextAttribute(): string
    {
        // 1) Map cứng theo ID yêu cầu (0 -> VNPAY, 1 -> COD)
        $id = (int) $this->id_payment;
        if (array_key_exists($id, self::PAYMENT_LABELS_BY_ID)) {
            return self::PAYMENT_LABELS_BY_ID[$id];
        }

        // 2) Nếu không nằm trong mapping nhưng có bản ghi payment -> nhận diện theo tên
        $paymentName = $this->payment?->name;
        if (is_string($paymentName) && $paymentName !== '') {
            $n = mb_strtolower($paymentName, 'UTF-8');
            if (str_contains($n, 'vnpay') || str_contains($n, 'online')) {
                return self::PAYMENT_LABELS_BY_ID[0]; // VNPAY
            }
            if (str_contains($n, 'tiền mặt') || str_contains($n, 'cod') || str_contains($n, 'khi nhận')) {
                return self::PAYMENT_LABELS_BY_ID[1]; // COD
            }
            // tên khác thì trả nguyên tên (vẫn không phải "N/A")
            return $paymentName;
        }

        // 3) Cuối cùng: vẫn không rõ thì trả "Không xác định" (không dùng "N/A")
        return 'Không xác định';
    }
}
