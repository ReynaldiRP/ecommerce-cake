<?php

namespace App\Http\Controllers;

use App\Http\Requests\Flavour\StoreFlavourRequest;
use App\Http\Requests\Flavour\UpdateFlavourRequest;
use Inertia\Inertia;
use App\Models\Flavour;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class FlavourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $flavour = Flavour::paginate(5);
        return Inertia::render('AdminDashboard/CakeFlavour/Index', ['flavour' => $flavour]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('AdminDashboard/CakeFlavour/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFlavourRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image_url')) {

            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake_flavour', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;
        }

        Flavour::create($data);

        return to_route('dashboard-flavour.index')->with('success', 'The Flavour has been successfully added');
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
    public function edit(Flavour $dashboard_flavour): Response
    {
        return Inertia::render('AdminDashboard/CakeFlavour/Edit', ['flavour' => $dashboard_flavour]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFlavourRequest $request, Flavour $dashboard_flavour): RedirectResponse
    {
        $imagePath = public_path($dashboard_flavour->image_url);

        $data = $request->validated();

        if ($request->hasFile('image_url')) {

            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake_flavour', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        } else {
            $data['image_url'] = $dashboard_flavour->image_url;
        }

        $dashboard_flavour->update($data);

        return to_route('dashboard-flavour.index')->with('success', 'The Flavour has been edited');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flavour $dashboard_flavour): RedirectResponse
    {
        $imagePath = public_path($dashboard_flavour->image_url);

        $dashboard_flavour->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return to_route('dashboard-flavour.index')->with('success', 'The Flavour has been deleted');
    }
}
