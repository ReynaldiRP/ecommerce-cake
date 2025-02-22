<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cake\StoreCakeRequest;
use App\Http\Requests\Cake\UpdateCakeRequest;
use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CakeController extends Controller
{


    /**
     * Method to display all the cakes in dashboard.
     *
     * @return Response
     */
    public function index(): Response
    {
        $cakes = Cake::with(['category', 'discount'])->paginate(5);
        // add discounted price to the cake
        foreach ($cakes as $cake) {
            $cake->discounted_price = $cake->base_price - ($cake->base_price * $cake->discount?->discount_percentage / 100);
        }

        return Inertia::render('AdminDashboard/Cake/Index', ['cakes' => $cakes]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $cakeCategory = Category::orderBy('name', 'asc')->get();
        $discounts = Discount::orderBy('discount_percentage', 'asc')->get();

        return Inertia::render('AdminDashboard/Cake/Create', [
            'cakeCategory' => $cakeCategory,
            'discounts' => $discounts
        ]);
    }


    /**
     * Method to store a newly created cake resource in storage.
     *
     * @param StoreCakeRequest $request description
     * @return RedirectResponse
     */
    public function store(StoreCakeRequest $request): RedirectResponse
    {

        $defaultDescription =  'Lorem, ipsum dolor sit amet consectetur
    adipisicing elit. Sunt corporis numquam rem sequi consequuntur
    inventore minus excepturi. Animi tempore dignissimos, delectus iusto nisi
    eligendi vero inventore ex, sapiente expedita impedit. Lorem ipsum dolor sit amet
    consectetur adipisicing elit. Laudantium, repellat optio mollitia iure,
    dicta reiciendis, laborum quibusdam repellendus expedita cumque error
    obcaecati dolorem architecto consequuntur ratione! Ipsum deserunt cupiditate beatae.';

        $data = $request->validated();

        if ($request->hasFile('image_url')) {

            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;
        }

        $data['description'] = $data['description']  ?? $defaultDescription;

        Cake::create($data);

        return to_route('cake.index')->with('success', 'The Cake has been successfully added');
    }


    /**
     * Method to display the form for editing a cake resource.
     *
     * @param Cake $dashboard_cake The cake resource to be edited.
     * @return Response The rendered edit form.
     */
    public function edit(Cake $dashboard_cake): Response
    {
        $dashboard_cake = $dashboard_cake->load('category', 'discount');
        $cakeCategory = Category::orderBy('name', 'asc')->get();
        $discounts = Discount::orderBy('discount_percentage', 'asc')->get();


        return Inertia::render('AdminDashboard/Cake/Edit', [
            'cakes' => $dashboard_cake,
            'cakeCategory' => $cakeCategory,
            'discounts' => $discounts
        ]);
    }


    /**
     * Updates an existing cake resource in storage.
     *
     * @param UpdateCakeRequest $request The request containing the updated cake details.
     * @param Cake $dashboard_cake The cake resource to be updated.
     * @return RedirectResponse A redirect response to the cake dashboard route with a success message.
     */
    public function update(UpdateCakeRequest $request, Cake $dashboard_cake): RedirectResponse
    {

        $imagePath = public_path($dashboard_cake->image_url);

        $data = $request->validated();

        if ($request->hasFile('image_url')) {
            $filename =  time() . '.' . $request->file('image_url')->getClientOriginalExtension();

            $path = $request->file('image_url')->storeAs('cake', $filename, 'public');

            $data['image_url'] = 'storage/' . $path;

            if (!empty($dashboard_cake->image_url)) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        } else {
            $data['image_url'] = $dashboard_cake->image_url;
        }

        $dashboard_cake->update($data);

        return to_route('cake.index')->with('success', 'The Cake has been successfully updated');
    }


    /**
     * Removes the specified cake resource from storage.
     *
     * @param Cake $dashboard_cake The cake resource to be deleted.
     * @return RedirectResponse A redirect response to the cake dashboard route with a success message.
     */
    public function destroy(Cake $dashboard_cake)
    {
        $imagePath = public_path($dashboard_cake->image_url);
        $dashboard_cake->delete();

        if ($dashboard_cake->image_url) {
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        return to_route('cake.index')->with('success', 'The Cake has been deleted');
    }
}
