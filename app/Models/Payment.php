<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'transaction_id',
        'payment_method',
        'payment_status',
    ];

    /**
     * Calculate the total revenue from orders with a payment status of 'pesanan terbayar'.
     *
     * @return float The total revenue from paid orders.
     */
    public function totalRevenueOrder()
    {
        return Payment::query()->where('payment_status', '=', 'pesanan terbayar')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_price');
    }

    /**
     * Get the order that owns the Payment
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentStatusHistories(): HasMany
    {
        return $this->hasMany(PaymentStatusHistory::class);
    }
}
