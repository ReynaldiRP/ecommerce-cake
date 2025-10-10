<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Collection;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'cake_id',
        'cake_size_id',
        'cake_flavour_id',
        'quantity',
        'price',
        'note'
    ];

    /**
     * Get all the cake sold within the specified date range.
     *
     * @param string|null $currentMonth The end date for the date range filter (optional).
     * @param string|null $pastMonth The start date for the date range filter (optional).
     *
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllCakeSold(int $year): array|\Illuminate\Database\Eloquent\Collection
    {
        $query = OrderItem::query()->select('cakes.name as cake_name', 'order_items.quantity as sold_quantity')
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'Pesanan terbayar')
            ->whereHas('order', function ($query) use ($year) {
                $query->whereYear('orders.created_at', $year);
            });

        return $query->get();
    }


    /**
     * Get the most popular cake based on the total quantity sold.
     *
     */
    public function getMostPopularCakes(string $currentMonth = null, string $pastMonth = null)
    {
        // Get the most popular cake for the specified date range
        $query = OrderItem::query()
            ->select('cakes.name as cake_name', DB::raw('SUM(order_items.quantity) as total_sold'), 'cakes.image_url as cake_image')
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'Pesanan terbayar')
            ->when($pastMonth && $currentMonth, function ($query) use ($pastMonth, $currentMonth) {
                if (strtotime($pastMonth) > strtotime($currentMonth)) {
                    [$pastMonth, $currentMonth] = [$currentMonth, $pastMonth];
                }

                Log::debug("Date filter applied", ['from' => $pastMonth, 'to' => $currentMonth]);
                return $query->whereBetween('orders.created_at', [$pastMonth, $currentMonth]);
            })
            ->groupBy('cakes.name', 'cakes.image_url')
            ->orderBy('total_sold', 'desc');

        Log::debug("getMostPopularCakes query: " . $query->toSql(), $query->getBindings());

        return $query->first();
    }

    /**
     * Calculate the total quantity of cakes sold.
     *
     * @param string|null $pastMonth The start date for the date range filter (optional).
     * @param string|null $currentMonth The end date for the date range filter (optional).
     * @return int The total quantity of cakes sold within the specified date range.
     */
    public function getTotalCakeSold(string $pastMonth = null, string $currentMonth = null): int
    {
        return (int)OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('payments', 'payments.order_id', '=', 'orders.id')
            ->where('payments.payment_status', '=', 'Pesanan terbayar') // Check capitalization
            ->when($pastMonth && $currentMonth, function ($query) use ($pastMonth, $currentMonth) {
                // Ensure start date is before end date
                if (strtotime($pastMonth) > strtotime($currentMonth)) {
                    [$pastMonth, $currentMonth] = [$currentMonth, $pastMonth];
                }

                // Log dates for debugging
                \Log::info("Date range:", ['start' => $pastMonth, 'end' => $currentMonth]);
                return $query->whereBetween('orders.created_at', [$pastMonth, $currentMonth]);
            })
            ->sum('order_items.quantity');
    }

    /**
     * Get the most popular cake type based on the total quantity sold.
     *
     * @param string|null $pastMonth The start date for the date range filter (optional).
     * @param string|null $currentMonth The end date for the date range filter (optional).
     * @return Model|null The most popular cake type with its name and total quantity sold.
     */
    public function getMostPopularCakeType(string $pastMonth = null, string $currentMonth = null): ?Model
    {
        $cakeTypeSales = OrderItem::query()->select('cakes.personalization_type as cake_type_name', DB::raw('CAST(SUM(order_items.quantity) as SIGNED) as total_sold'))
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'Pesanan terbayar')
            ->when($pastMonth && $currentMonth, function ($query) use ($pastMonth, $currentMonth) {
                return $query->whereBetween('order_items.created_at', [$pastMonth, $currentMonth]);
            })
            ->groupBy('cakes.personalization_type');


        $maxSold = DB::table(DB::raw("({$cakeTypeSales->toSql()}) as subquery"))
            ->mergeBindings($cakeTypeSales->getQuery())
            ->max('total_sold');


        return $cakeTypeSales->having('total_sold', '=', $maxSold)->first();
    }

    /**
     * Get the most popular cake category based on the total quantity sold.
     *
     * @param string|null $pastMonth The start date for the date range filter (optional).
     * @param string|null $currentMonth The end date for the date range filter (optional).
     * @return Model|null The most popular cake category with its name and total quantity sold.
     */
    public function getMostPopularCakeCategory(string $pastMonth = null, string $currentMonth = null): ?Model
    {
        // Get the most popular cake
        $categorySales = OrderItem::query()->select('categories.name as category_name', DB::raw('CAST(SUM(order_items.quantity) as SIGNED) as total_sold'))
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->join('categories', 'cakes.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', '=', 'Pesanan terbayar')
            ->when($pastMonth && $currentMonth, function ($query) use ($pastMonth, $currentMonth) {
                return $query->whereBetween('order_items.created_at', [$pastMonth, $currentMonth]);
            })
            ->groupBy('categories.name');

        // Use a subquery to find the max sold cake
        $maxSold = DB::table(DB::raw("({$categorySales->toSql()}) as subquery"))
            ->mergeBindings($categorySales->getQuery())
            ->max('total_sold');

        // Fetch the most popular cake
        return $categorySales->having('total_sold', '=', $maxSold)->first();
    }


    /**
     * Get the order that owns the OrderItem
     *
     * @return BelongsTo
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Get the cake that owns the OrderItem
     *
     * @return BelongsTo
     */
    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class, 'cake_id', 'id');
    }

    public function cakeSize(): BelongsTo
    {
        return $this->belongsTo(CakeSize::class, 'cake_size_id', 'id');
    }

    /**
     * Get the flavour that owns the OrderItem
     *
     * @return BelongsTo
     */
    public function cakeFlavour(): BelongsTo
    {
        return $this->belongsTo(Flavour::class, 'cake_flavour_id', 'id');
    }

    /**
     * The toppings that belong to the OrderItem
     *
     * @return BelongsToMany
     */
    public function cakeTopping(): BelongsToMany
    {
        return $this->belongsToMany(Topping::class, 'order_item_toppings', 'order_item_id', 'topping_id');
    }
}
