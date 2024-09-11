<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Flavour;
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

        // Check the filtred cake based on cake personalization type and cake size
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
}
