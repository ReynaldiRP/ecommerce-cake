<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private readonly Order $order,
        private readonly OrderItem $orderItem,
    )
    {}

    public function index(Request $request): JsonResponse
    {
        // request input for date range
        $selectedYearDataTransaction = $request->input('selectedTransactionYear', 2024);
        $selectedYearDataRevenue = $request->input('selectedRevenueYear', 2024);
        $selectedYearDataCakeSold = $request->input('selectedCakeSoldYear', 2024);



        $fetchTransactionData = $this->fetchDataTransactionPerMonth($selectedYearDataTransaction);
        $fetchRevenueData = $this->fetchDataRevenuePerMonth($selectedYearDataRevenue);
        $fetchCakeSoldData = $this->fetchDataCakeSoldPerMonth($selectedYearDataCakeSold);


        return response()->json([
            'chartDataTotalTransaction' => $fetchTransactionData,
            'chartDataRevenue' => $fetchRevenueData,
            'chartDataCakeSold' => $fetchCakeSoldData,
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

    public function fetchDataCakeSoldPerMonth(int $year): array
    {
        $dataCakeSold = $this->orderItem->getAllCakeSold($year);

        return $dataCakeSold->toArray();
    }
}
