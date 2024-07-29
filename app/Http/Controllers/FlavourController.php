<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        try {
            Flavour::create($request->all());
            return to_route('dashboard-flavour.index');
        } catch (\Throwable $th) {
            dd($th);
        }
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
    public function update(Request $request, Flavour $flavour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flavour $flavour)
    {
        //
    }
}
