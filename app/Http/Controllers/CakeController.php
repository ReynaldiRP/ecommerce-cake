<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('AdminDashboard/Product/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('AdminDashboard/Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cake $cake)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cake $cake)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cake $cake)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cake $cake)
    {
        //
    }
}
