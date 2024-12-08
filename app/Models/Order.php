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

    public function getGrowthRevenuePerMonthByPercentage($year)
    {
        $totalRevenuePerMonth = $this->showAllRevenueForEachMonths($year);

        $totalRevenuePerMonth->transform(function ($item, $key) use ($totalRevenuePerMonth) {
            if ($key === 0) {
                $item['growth'] = 0;
            } else {
                $previousMonthRevenue = $totalRevenuePerMonth[$key - 1]['total_revenue'];
                $currentMonthRevenue = $item['total_revenue'];
                $item['growth'] = (($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100;
            }

            return $item;
        });

        return $totalRevenuePerMonth;
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
