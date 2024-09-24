<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\CakeSize;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CakeSize\StoreCakeSizeRequest;
use App\Http\Requests\CakeSize\UpdateCakeSizeRequest;

class CakeSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $cakeSize = CakeSize::OrderBy('size', 'asc')->paginate(5);
        return Inertia::render('AdminDashboard/CakeSize/Index', ['cakeSize' => $cakeSize]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('AdminDashboard/CakeSize/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCakeSizeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        CakeSize::create($data);
        return to_route('size.index')->with('success', 'The Cake Size has been successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(CakeSize $cakeSize)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CakeSize $dashboard_size): Response
    {
        return Inertia::render('AdminDashboard/CakeSize/Edit', ['cakeSize' => $dashboard_size]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCakeSizeRequest $request, CakeSize $dashboard_size): RedirectResponse
    {
        $data = $request->validated();
        $dashboard_size->update($data);
        return to_route('size.index')->with('success', 'The Cake Size has been edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CakeSize $dashboard_size): RedirectResponse
    {
        $dashboard_size->delete();
        return to_route('size.index')->with('success', 'The Cake Size has been deleted');
    }
}
