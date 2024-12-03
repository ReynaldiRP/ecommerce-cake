<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DiscountController extends Controller
{
    /**
     * Show list discount data in admin dashboard.
     *
     * @return Response
     */
    public function index(): Response
    {
        $discounts = Discount::orderBy('created_at', 'desc')->paginate(5);

        // Transform the start and end date discount
        foreach ($discounts as $discount) {
            $discount->start_date = Carbon::parse($discount->start_date)->translatedFormat('d F Y');
            $discount->end_date = Carbon::parse($discount->end_date)->translatedFormat('d F Y');
        }

        return Inertia::render('AdminDashboard/CakeDiscount/Index', [
            'discounts' => $discounts
        ]);
    }

    /**
     * Show create discount form in admin dashboard.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('AdminDashboard/CakeDiscount/Create');
    }

    /**
     * Store discount data to database.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        Discount::create($data);

        return redirect()->route('discount.index')->with('success', 'Berhasil menambahkan diskon baru.');
    }

    /**
     * Show edit discount form in admin dashboard.
     *
     * @param Discount $dashboard_discount
     * @return Response
     */
    public function edit(Discount $dashboard_discount): Response
    {
      

        return Inertia::render('AdminDashboard/CakeDiscount/Edit', [
            'discount' => $dashboard_discount
        ]);
    }

    /**
     * Update discount data to database.
     *
     * @param Request $request
     * @param Discount $dashboard_discount
     * @return RedirectResponse
     */
    public function update(Request $request, Discount $dashboard_discount): RedirectResponse
    {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $dashboard_discount->update($data);

        return redirect()->route('discount.index')->with('success', 'Berhasil mengubah diskon.');
    }

    /**
     * Delete discount data from database.
     *
     * @param Discount $dashboard_discount
     * @return RedirectResponse
     */
    public function destroy(Discount $dashboard_discount): RedirectResponse
    {
        $dashboard_discount->delete();

        return redirect()->route('discount.index')->with('success', 'Berhasil menghapus diskon.');
    }
}
