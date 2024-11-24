<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Category;
use App\Models\Flavour;
use App\Models\ShoppingChartItem;
use App\Models\Topping;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FrontEndController extends Controller
{
    /**
     * Show the landing page of the application.
     *
     * @return Response
     */
    public function index(): Response
    {
        $cakes = Cake::query()->where('personalization_type', '=', 'customized')->get();
        return Inertia::render('LandingPageSection', ['cakes' => $cakes]);
    }

    /**
     * Handles search functionality for cakes.
     *
     * @param Request $request The incoming HTTP request containing search query.
     * @return JsonResponse A JSON response containing search results and query.
     */
    public function search(Request $request)
    {
        $query = $request->input('search');

        $cakes = Cake::query()
            ->where('name', 'like', "%{$query}%");

        if (!$cakes) {
            $cakes = [];
        }

        $cakes = $cakes->paginate(5);

        return response()->json([
            'searchResults' => $cakes->items(),
            'query' => $query,
        ]);
    }

    /**
     * Show the product page of the application.
     *
     * @return Response
     */
    public function products(Request $request): Response
    {
        $cakes = Cake::with('category');
        $cakeCategories = Category::all();

        // Check the filtered cake based on cake personalization type and cake size
        if ($request->has('personalization_type')) {
            $cakes->where('personalization_type', $request->personalization_type);
        }


        if ($request->has('cake_category_id')) {
            $cakeCategoryIds = $request->input('cake_category_id');
            if (!is_array($cakeCategoryIds)) {
                $cakeCategoryIds = explode(',', $cakeCategoryIds);
            }

            $cakes->whereIn('category_id', $cakeCategoryIds);
        }

        $cakes = $cakes->paginate(12);

        // Show image with base url
        foreach ($cakes->items() as $cake) {
            if ($cake->image_url) {
                $cake->image_url = asset($cake->image_url);
            } else {
                $cake->image_url = asset('assets/image/default-img.jpg');
            }
        }

        return Inertia::render('ProductSection', [
            'cakes' => $cakes,
            'cakeCategories' => $cakeCategories
        ]);
    }

    /**
     * Show the detail product page of the application.
     *
     * @param $cakeId $cakeId [id of the selected cake]
     *
     * @return Response
     */
    public function detailProduct($cakeId): Response
    {
        $cake = Cake::with('category')->findOrFail($cakeId);

        if ($cake->image_url) {
            $cake->image_url = asset($cake->image_url);
        } else {
            $cake->image_url = asset('assets/image/default-img.jpg');
        }

        $cakeSize = CakeSize::query()->orderBy('size')->get();
        $topping = Topping::all();
        $flavour = Flavour::all();



        return Inertia::render('DetailProductSection', [
            'cake' => $cake,
            'size' => $cakeSize,
            'topping' => $topping,
            'flavour' => $flavour
        ]);
    }





    /**
     * Handles the checkout process.
     *
     * This method processes the checkout request. If the request method is POST, it retrieves the selected cake IDs and their quantities
     * from the request, fetches the corresponding cakes from the database, calculates their prices, and stores the prices and quantities
     * in the session. If the request method is not POST, it retrieves the stored cake IDs, prices, and quantities from the session.
     *
     * @param Request $request The HTTP request instance.
     * @return Response The response instance.
     */
    public function checkout(Request $request): Response
    {
        if ($request->isMethod('post')) {
            // Get the array of shoppingChartItemId from the query parameters
            $shoppingChartItemIds = $request->input('selectCake', []);


            // Fetch the selected cakes
            $cakes = ShoppingChartItem::with(['cake', 'cakeSize'])->whereIn(
                'id',
                $shoppingChartItemIds
            )->get();


            // update the cake prices, quantities and notes
            $cakePrices = [];
            $cakeQuantities = [];
            $cakeNotes = [];

            // Iterate through each cake in the collection
            foreach ($cakes as $cake) {
                $cakeId = $cake->id;

                $quantities = $request->input('cakeQuantity', [])[$cakeId] ?? 1;
                $notes = $request->input('notes', [])[$cakeId] ?? '';
                $prices = $request->input('cakesPrice', [])[$cakeId];
                
                $cakeQuantities[$cakeId] = $quantities;
                $cakeNotes[$cakeId] = $notes;
                $cakePrices[$cakeId] = $prices;
            }

            // Store cake prices, quantities and notes in the session
            $request->session()->put('cakePrices', $cakePrices);
            $request->session()->put('cakeQuantities', $cakeQuantities);
            $request->session()->put('cakeNotes', $cakeNotes);

            // Store the shopping chart item IDs in the session
            $request->session()->put('selectedCakes', $shoppingChartItemIds);
        } else {
            // Retrieve the stored cake IDs from the session
            $shoppingChartItemIds = $request->session()->get('selectedCakes', []);
        }


        // Retrieve the stored cake prices, cake quantity and cake notes from the session
        $cakePrices = $request->session()->get('cakePrices', []);
        $cakeQuantities = $request->session()->get('cakeQuantities', []);
        $cakeNotes = $request->session()->get('cakeNotes', []);

        // Fetch chart items by the given array of IDs
        $chartItems = ShoppingChartItem::with([
            'cart',
            'cake',
            'cakeSize',
            'cakeFlavour',
            'cakeTopping'
        ])->whereIn('id', $shoppingChartItemIds)->get();


        return Inertia::render('CheckoutSection', [
            'chartItems' => $chartItems,
            'cakePrices' => $cakePrices,
            'cakeQuantities' => $cakeQuantities,
            'cakeNotes' => $cakeNotes
        ]);
    }
}
