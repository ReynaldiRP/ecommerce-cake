<?php

namespace App\Http\Controllers;

use App\Http\Requests\Flavour\StoreFlavourRequest;
use App\Http\Requests\Flavour\UpdateFlavourRequest;
use Inertia\Inertia;
use App\Models\Flavour;
use Illuminate\Http\Request;

class FlavourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $flavour = Flavour::all();
        return Inertia::render('AdminDashboard/Flavour/Index', ['flavour' => $flavour]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AdminDashboard/Flavour/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlavourRequest $request)
    {
        $data = $request->validated();
        Flavour::create($data);
        return to_route('dashboard-flavour.index')->with('success', 'The Flavour has been success added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Flavour $flavour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flavour $dashboard_flavour)
    {
        return Inertia::render('AdminDashboard/Flavour/Edit', ['flavour' => $dashboard_flavour]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlavourRequest $request, Flavour $dashboard_flavour)
    {
        $data = $request->validated();
        $dashboard_flavour->update($data);
        return to_route('dashboard-flavour.index')->with('success', 'The Flavour has been edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flavour $dashboard_flavour)
    {
        $dashboard_flavour->delete();
        return to_route('dashboard-flavour.index')->with('success', 'The Flavour has been deleted');
    }
}
