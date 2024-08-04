<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cake\StoreCakeRequest;
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
        $cake = Cake::with('cakeSize')->get();
        return Inertia::render('AdminDashboard/Cake/Index', ['cakes' => $cake]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cake = Cake::with('cakeSize')->get();
        return Inertia::render('AdminDashboard/Cake/Create', ['cakes' => $cake]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCakeRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('image_url')) {

            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;
        }

        Cake::create($data);

        return to_route('dashboard-cake.index')->with('success', 'The Cake has been successfully added');
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
