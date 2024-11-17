<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'cake_id',
        'cake_flavour_id',
        'quantity',
        'price',
        'note'
    ];

    /**
     * Get the most popular cakes based on the total quantity sold.
     *
     * @return Model|null The most popular cake with its name, image, and total quantity sold.
     */
    public function getMostPopularCakes(): ?Model
    {
        // Get the most popular cake
        $cakeSales = OrderItem::query()->select('cakes.name as cake_name', 'cakes.image_url as cake_image', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->groupBy('cakes.name', 'cakes.image_url');

        // Use a subquery to find the max sold cake
        $maxSold = DB::table(DB::raw("({$cakeSales->toSql()}) as subquery"))
            ->mergeBindings($cakeSales->getQuery())
            ->max('total_sold');

        // Fetch the most popular cake
        return $cakeSales->having('total_sold', '=', $maxSold)->first();
    }

    /**
     * Get the total quantity of cakes sold for orders with a payment status of 'terbayar'.
     *
     * @return int The total quantity of cakes sold.
     */
    public function getTotalCakeSold(): int
    {
        return (int)OrderItem::with('order', 'order.payment')
            ->whereHas('order.payment', function ($query) {
                $query->where('payment_status', '=', 'terbayar');
            })
            ->sum('quantity');
    }

    public function getMostPopularCakeCategory(): ?Model
    {
        // Get the most popular cake
        $categorySales = OrderItem::query()->select('categories.name as category_name', DB::raw('CAST(SUM(order_items.quantity) as SIGNED) as total_sold'))
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->join('categories', 'cakes.category_id', '=', 'categories.id')
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cakeTopping(): BelongsToMany
    {
        return $this->belongsToMany(Topping::class, 'order_item_toppings', 'order_item_id', 'topping_id');
    }
}
