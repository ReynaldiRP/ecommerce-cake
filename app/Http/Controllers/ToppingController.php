<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Topping;
use App\Http\Requests\Topping\StoreToppingRequest;
use App\Http\Requests\Topping\UpdateToppingRequest;
use Illuminate\Http\RedirectResponse;

class ToppingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $topping = Topping::paginate(5);
        return Inertia::render('AdminDashboard/CakeTopping/Index', ['topping' => $topping]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('AdminDashboard/CakeTopping/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToppingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image_url')) {

            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake_topping', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;
        }

        Topping::create($data);

        return to_route('dashboard-topping.index')->with('success', 'The Topping has been successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show(Topping $topping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Topping $dashboard_topping): Response
    {
        return Inertia::render('AdminDashboard/CakeTopping/Edit', ['topping' => $dashboard_topping]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToppingRequest $request, Topping $dashboard_topping)
    {
        $imagePath = public_path($dashboard_topping->image_url);


        $data = $request->validated();

        if ($request->hasFile('image_url')) {
            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake_topping', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        } else {
            $data['image_url'] = $dashboard_topping->image_url;
        }

        $dashboard_topping->update($data);

        return to_route('dashboard-topping.index')->with('success', 'The Topping has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topping $dashboard_topping)
    {
        $imagePath = public_path($dashboard_topping->image_url);

        $dashboard_topping->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return to_route('dashboard-topping.index')->with('success', 'The Topping has been deleted');
    }
}
