<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Flavour;
use App\Models\ShoppingChartItem;
use App\Models\Topping;
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
        $cakes = DB::table('cakes')
            ->join('cake_sizes', 'cakes.cake_size_id', '=', 'cake_sizes.id')
            ->select('cakes.id', 'cakes.cake_size_id', 'cakes.name', 'cake_sizes.size', 'cakes.image_url')
            ->get();

        return Inertia::render('LandingPageSection', ['cakes' => $cakes]);
    }

    /**
     * Handles search functionality for cakes.
     *
     * @param Request $request The incoming HTTP request containing search query.
     * @return \Illuminate\Http\JsonResponse A JSON response containing search results and query.
     */
    public function search(Request $request)
    {
        $query = $request->input('search');

        $cakes = Cake::with('cakeSize')
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
        $cakes =  Cake::with('cakeSize');

        // Check the filtered cake based on cake personalization type and cake size
        if ($request->has('personalization_type')) {
            $cakes->where('personalization_type', $request->personalization_type);
        }

        if ($request->has('cake_size_id')) {
            $cakeSizeIds = explode(',', $request->cake_size_id);
            $cakes->whereIn('cake_size_id', $cakeSizeIds);
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
            'cakeSizes' => CakeSize::orderBy('size')->get()
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
        $cake = Cake::with('cakeSize')->findOrFail($cakeId);

        if ($cake->image_url) {
            $cake->image_url = asset($cake->image_url);
        } else {
            $cake->image_url = asset('assets/image/default-img.jpg');
        }

        $topping = Topping::all();
        $flavour = Flavour::all();



        return Inertia::render('DetailProductSection', [
            'cake' => $cake,
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
            $cakes = ShoppingChartItem::with(['cake', 'cake.cakeSize'])->whereIn(
                'id',
                $shoppingChartItemIds
            )->get();

            // update quantity of cake
            $cakePrices = [];
            $cakeQuantities = [];

            foreach ($cakes as $index => $cake) {
                $quantity = $request->input('cakeQuantity')[$index];
                $cakeQuantities[$cake->id] = $quantity;

                $price = $cake->price * $quantity;

                $cakePrices[$cake->id] = $price;
            }

            // Store cake prices and quantities in the session
            $request->session()->put('cakePrices', $cakePrices);
            $request->session()->put('cakeQuantities', $cakeQuantities);


            // Store the shopping chart item IDs in the session
            $request->session()->put('selectedCakes', $shoppingChartItemIds);
        } else {
            // Retrieve the stored cake IDs from the session
            $shoppingChartItemIds = $request->session()->get('selectedCakes', []);
        }


        // Retrieve the stored cake prices and cake quantity from the session
        $cakePrices = $request->session()->get('cakePrices', []);
        $cakeQuantities = $request->session()->get('cakeQuantities', []);

        // Fetch chart items by the given array of IDs
        $chartItems = ShoppingChartItem::with([
            'cart',
            'cake' => function ($query) {
                $query->with('cakeSize');
            },
            'cakeFlavour',
            'cakeTopping'
        ])->whereIn('id', $shoppingChartItemIds)->get();

        // DB::table('shopping_chart_items AS sc')
        //     ->select([
        //         'sc.id AS shopping_chart_id',
        //         'sc.quantity AS order_quantity',
        //         'sc.price AS order_price',
        //         'c.name AS cake_name',
        //         'c.base_price AS cake_price',
        //         'c.description AS cake_description',
        //         'c.personalization_type AS cake_type',
        //         'cs.size',
        //         'cs.price AS size_price',
        //         'f.name AS flavour_name',
        //         'f.price AS flavour_price',
        //         DB::raw('GROUP_CONCAT(DISTINCT t.name ORDER BY t.name ASC SEPARATOR ", ") AS topping_names')
        //     ])
        //     ->leftJoin('cakes AS c', 'sc.cake_id', '=', 'c.id')
        //     ->leftJoin('cake_sizes AS cs', 'c.cake_size_id', '=', 'cs.id')
        //     ->leftJoin('flavours AS f', 'sc.cake_flavour_id', '=', 'f.id')
        //     ->leftJoin('shopping_chart_item_topping AS scit', 'sc.id', '=', 'scit.shopping_chart_item_id')
        //     ->leftJoin('toppings AS t', 'scit.topping_id', '=', 't.id')
        //     ->groupBy('sc.id')
        //     ->get();

        return Inertia::render('CheckoutSection', [
            'chartItems' => $chartItems,
            'cakePrices' => $cakePrices,
            'cakeQuantities' => $cakeQuantities
        ]);
    }
}
