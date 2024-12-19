<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// TODO: Implement filtering data transaction per month based on selected year
class DashboardController extends Controller
{
    public function __construct(
        private readonly Order $order,
    )
    {}

    public function index(Request $request): JsonResponse
    {
        // request input for date range
        $selectedYearDataTransaction = $request->input('selectedTransactionYear', 2024);
        $selectedYearDataRevenue = $request->input('selectedRevenueYear', 2024);



        $fetchTransactionData = $this->fetchDataTransactionPerMonth($selectedYearDataTransaction);
        $fetchRevenueData = $this->fetchDataRevenuePerMonth($selectedYearDataRevenue);



        return response()->json([
            'chartDataTotalTransaction' => $fetchTransactionData,
            'chartDataRevenue' => $fetchRevenueData,
        ]);
    }

    /**
     * Get data transaction per month based on selected year
     *
     * @param int $year
     * @return string[]
     */
    public function fetchDataTransactionPerMonth(int $year): array
    {
        $dataTransaction = $this->order->showAllTransactionForEachMonths($year);

        return $dataTransaction->toArray();
    }

    /**
     * Get data revenue per month based on selected year
     *
     * @param int $year
     * @return string[]
     */
    public function fetchDataRevenuePerMonth (int $year): array
    {
        $dataRevenue = $this->order->showAllRevenueForEachMonths($year);

        return $dataRevenue->toArray();
    }
}
