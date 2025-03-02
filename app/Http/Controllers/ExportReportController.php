<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class ExportReportController extends Controller
{
    private $months = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    /**
     * Format the price to Indonesian Rupiah currency.
     *
     * @param float|int $param The price to format.
     * @return string The formatted price.
     */
    private function formatPrice(float|int $param): string
    {
        return 'Rp. ' . number_format($param, 2, ',', '.');
    }

    /**
     * Export the product performance report to a PDF file.
     *
     * @param Request $request The HTTP request instance.
     * @return HttpResponse The HTTP response containing the PDF download.
     */
    public function exportProductPerformanceToPdf(Request $request): HttpResponse
    {
        $selectedYear = $request->input('year');
        $selectedMonth = $request->input('month');

        // Get the product performance data
        $productPerformance = Order::with(['payment', 'orderItems', 'orderItems.cake', 'orderItems.cakeFlavour', 'orderItems.cakeSize', 'orderItems.cakeTopping'])
            ->whereYear('orders.created_at', $selectedYear)
            ->whereMonth('orders.created_at', $selectedMonth)
            ->whereHas('payment', function ($query) {
                $query->where('payment_status', 'Pesanan terbayar');
            })
            ->get();


        // Get the highest selling product
        $bestSellingProduct = OrderItem::query()->selectRaw('cakes.name as cake, SUM(order_items.quantity) as total_sold')
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'Pesanan terbayar')
            ->whereYear('orders.created_at', $selectedYear)
            ->whereMonth('orders.created_at', $selectedMonth)
            ->groupBy('cakes.name')
            ->orderByDesc('total_sold')
            ->first();

        // Get the lowest selling product
        $worstSellingProduct = OrderItem::query()->selectRaw('cakes.name as cake, SUM(order_items.quantity) as total_sold')
            ->join('cakes', 'order_items.cake_id', '=', 'cakes.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'Pesanan terbayar')
            ->whereYear('orders.created_at', $selectedYear)
            ->whereMonth('orders.created_at', $selectedMonth)
            ->groupBy('cakes.name')
            ->orderBy('total_sold')
            ->first();


        // Transform the product performance data
        $productPerformance = $productPerformance->flatMap(function ($order) {
            return $order->orderItems->map(function ($orderItem) {
                return [
                    'cake_name' => $orderItem->cake->name,
                    'cake_flavour' => $orderItem->cakeFlavour->name ?? '-',
                    'cake_size' => $orderItem->cakeSize->size ?? '-',
                    'cake_topping' => $orderItem->cakeTopping->implode('name', ', ') ?? '-',
                    'quantity' => $orderItem->quantity,
                    'price' => $this->formatPrice($orderItem->price),
                    'total_price' => $this->formatPrice($orderItem->price * $orderItem->quantity),
                    'order_created_at' => $orderItem->order->created_at->translatedFormat('l, d F Y H:i'),
                ];
            });
        });

        // Get total revenue
        $totalRevenue = $productPerformance->sum(function ($item) {
            return (float) str_replace(['Rp. ', '.', ','], ['', '', '.'], $item['total_price']);
        });


        $pdf = PDF::setOption('isRemoteEnabled', true)->loadView('pdf.product_performance', [
            'productPerformance' => $productPerformance ?? [],
            'bestSellingProduct' => $bestSellingProduct ?? [],
            'worstSellingProduct' => $worstSellingProduct ?? [],
            'totalRevenue' => $this->formatPrice($totalRevenue) ?? '-',
            'generated_at' => Carbon::now()->translatedFormat('l, d F Y H:i'),
            'period' => $this->months[$selectedMonth] . ' ' . $selectedYear,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('product-performance-report.pdf');
    }

    /**
     * Export sales performance report to PDF file.
     *
     * @param Request $request The HTTP request instance.
     * @return HttpResponse - The HTTP response containing the PDF file.
     */
    public function exportSalesPerformanceToPdf(Request $request): HttpResponse
    {
        $selectedYear = $request->input('year');
        $selectedMonth = $request->input('month');

        // Get the total revenue for based on the selected month
        $totalRevenue = Order::selectRaw('SUM(total_price) as total_revenue')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'Pesanan terbayar')
            ->whereYear('orders.created_at', $selectedYear)
            ->whereMonth('orders.created_at', $selectedMonth)
            ->first();

        // Get the total transaction based on the selected month
        $totalTransaction = Order::selectRaw('COUNT(orders.id) as total_transaction')
            ->join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.payment_status', 'Pesanan terbayar')
            ->whereYear('orders.created_at', $selectedYear)
            ->whereMonth('orders.created_at', $selectedMonth)
            ->first();

        // Get the Average Order Value (AOV) based on the selected month
        $averageOrderValue = $totalTransaction->total_transaction != 0
            ? $totalRevenue->total_revenue / $totalTransaction->total_transaction
            : 0;

        // Get the sales performance data to show in table
        $salePerformance = Payment::with(['order', 'order.user'])
            ->where('payment_status', 'Pesanan terbayar')
            ->whereHas('order', function ($query) use ($selectedYear, $selectedMonth) {
                $query->whereYear('created_at', $selectedYear)
                    ->whereMonth('created_at', $selectedMonth);
            })
            ->get();

        // Transform the sales performance data
        $salePerformance = $salePerformance->map(function ($payment) {
            return [
                'order_created_at' => $payment->order->created_at->translatedFormat('l, d F Y H:i'),
                'customer_name' => $payment->order->user->username,
                'cake_recipient' => $payment->order->cake_recipient,
                'method_delivery' => $payment->order->method_delivery,
                'total_price' => $this->formatPrice($payment->order->total_price),
                'payment_method' => $payment->payment_method,
                'payment_date' => $payment->created_at->translatedFormat('l, d F Y H:i'),
                'estimated_delivery' => Carbon::parse($payment->order->estimated_delivery_date)->translatedFormat('l, d F Y'),
            ];
        });


        $pdf = Pdf::setOption('isRemoteEnabled', true)
            ->setOption('dpi', 150)
            ->setOption('defaultFont', 'sans-serif')
            ->loadView('pdf.sales_performance', [
            'salePerformance' => $salePerformance ?? [],
            'totalRevenue' => $this->formatPrice($totalRevenue->total_revenue ?? 0) ?? '-',
            'totalTransaction' => $totalTransaction->total_transaction ?? '-',
            'averageOrderValue' => $this->formatPrice($averageOrderValue ?? 0) ?? '-',
            'generated_at' => Carbon::now()->translatedFormat('l, d F Y H:i'),
            'period' => $this->months[$selectedMonth] . ' ' . $selectedYear,
        ])->setPaper('a4', 'landscape');


        return $pdf->download('sales-performance-report.pdf');
    }
}
