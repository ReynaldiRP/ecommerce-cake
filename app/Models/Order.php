<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'estimated_delivery_date',
        'method_delivery',
        'user_address',
        'cake_recipient',
        'total_price',
        'status',
        'payment_url'
    ];

    /**
     * Show the total revenue for each month of a given year.
     *
     * This method retrieves the total revenue for each month of the specified year.
     *
     * @param int $year The year for which to retrieve the total revenue per month.
     * @return Collection A collection of total revenue per month with month names.
     */
    public function showAllRevenueForEachMonths(int $year): Collection
    {
        $totalRevenuePerMonth = $this->selectRaw('MONTH(orders.created_at) as month, SUM(total_price) as total_revenue')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'pesanan terbayar')
            ->whereYear('orders.created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        $totalRevenuePerMonth->transform(function ($item) {
            return [
                'month' => Carbon::createFromDate(null, $item->month)->isoFormat('MMMM'),
                'total_revenue' => $item->total_revenue
            ];
        });

        return $totalRevenuePerMonth;
    }

    public function getGrowthRevenueRangeThreeMonthByPercentage(): float|int
    {
        $totalRevenuePastThreeMonths = $this->selectRaw('SUM(total_price) as total_revenue')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'pesanan terbayar')
            ->whereBetween('orders.created_at', [Carbon::now()->subMonths(3), Carbon::now()->subMonth()->endOfMonth()])
            ->first();


        $totalRevenueCurrentMonth = $this->selectRaw('SUM(total_price) as total_revenue')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'pesanan terbayar')
            ->whereMonth('orders.created_at', Carbon::now()->month)
            ->first();


        return $totalRevenuePastThreeMonths->total_revenue != 0
            ? ($totalRevenueCurrentMonth->total_revenue - $totalRevenuePastThreeMonths->total_revenue) / $totalRevenuePastThreeMonths->total_revenue * 100
            : 0;
    }

    /**
     * Get total transaction for each month based on selected year.
     *
     * @param int $year The year for which to retrieve the total transaction per month.
     * @return Collection A collection of total transaction per month with month names.
     */
    public function showAllTransactionForEachMonths(int $year): Collection
    {
        $totalTransactionPerMonth = $this->selectRaw('MONTH(orders.created_at) as month, COUNT(orders.id) as total_transaction')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'pesanan terbayar')
            ->whereYear('orders.created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $totalTransactionPerMonth->transform(function ($item) {
            return [
                'month' => Carbon::createFromDate(null, $item->month)->isoFormat('MMMM'),
                'total_transaction' => $item->total_transaction
            ];
        });

        return $totalTransactionPerMonth;
    }


    /**
     * Get the order items for the order.
     *
     * @return HasMany
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Get the user who made the order.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    /**
     * Get the payment for the order.
     *
     * @return HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }

    public function orderStatusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'order_id', 'id');
    }
}
