<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cake\StoreCakeRequest;
use App\Http\Requests\UpdateCakeRequest;
use App\Models\Cake;
use App\Models\CakeSize;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CakeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $cake = Cake::with('cakeSize')->paginate(5);

        return Inertia::render('AdminDashboard/Cake/Index', ['cakes' => $cake]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $cakeSize = CakeSize::all();
        return Inertia::render('AdminDashboard/Cake/Create', ['sizeCake' => $cakeSize]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCakeRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image_url')) {

            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;
        }

        Cake::create($data);

        return to_route('dashboard-cake')->with('success', 'The Cake has been successfully added');
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
    public function edit(Cake $dashboard_cake): Response
    {
        $dashboard_cake = $dashboard_cake->load('cakeSize');
        $cakeSize = CakeSize::all();

        return Inertia::render('AdminDashboard/Cake/Edit', ['cakes' => $dashboard_cake, 'cakeSize' => $cakeSize]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCakeRequest $request, Cake $dashboard_cake): RedirectResponse
    {

        $imagePath = public_path($dashboard_cake->image_url);

        $data = $request->validated();

        if ($request->hasFile('image_url')) {
            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        } else {
            $data['image_url'] = $dashboard_cake->image_url;
        }

        $dashboard_cake->update($data);

        return to_route('dashboard-cake')->with('success', 'The Cake has been successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cake $dashboard_cake)
    {
        $imagePath = public_path($dashboard_cake->image_url);
        $dashboard_cake->delete();

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return to_route('dashboard-cake')->with('success', 'The Cake has been deleted');
    }
}
