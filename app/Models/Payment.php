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
     * Calculate the total revenue from orders that have been paid.
     *
     * @param string|null $pastMonth The start date for the date range filter (optional).
     * @param string|null $currentMonth The end date for the date range filter (optional).
     * @return float The total revenue from orders within the specified date range.
     */
    public function totalRevenueOrder(string $pastMonth = null, string $currentMonth = null): float
    {
        return Payment::query()->where('payment_status', '=', 'pesanan terbayar')
            ->when($pastMonth && $currentMonth, function ($query) use ($pastMonth, $currentMonth) {
                return $query->whereBetween('orders.created_at', [$pastMonth, $currentMonth]);
            })
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_price');
    }


    /**
     * Calculate the total number of transactions that have been paid.
     *
     * @param string|null $pastMonth The start date for the date range filter (optional).
     * @param string|null $currentMonth The end date for the date range filter (optional).
     * @return int The total number of transactions within the specified date range.
     */
    public function getTotalTransaction(string $pastMonth = null, string $currentMonth = null): int
    {
        return Payment::query()->where('payment_status', '=', 'pesanan terbayar')
            ->when($pastMonth && $currentMonth, function ($query) use ($pastMonth, $currentMonth) {
                return $query->whereBetween('payments.created_at', [$pastMonth, $currentMonth]);
            })
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->count();
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
