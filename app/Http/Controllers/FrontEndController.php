<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\CakeSize;
use App\Models\Flavour;
use App\Models\Topping;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FrontEndController extends Controller
{
    public function index(): Response
    {
        $cakes = DB::table('cakes')
            ->join('cake_sizes', 'cakes.cake_size_id', '=', 'cake_sizes.id')
            ->select('cakes.id', 'cakes.cake_size_id', 'cakes.name', 'cake_sizes.size', 'cakes.image_url')
            ->get();

        return Inertia::render('LandingPageSection', ['cakes' => $cakes]);
    }


    public function products(): Response
    {
        $cakes =  Cake::with('cakeSize')->paginate(5);
        $cakeSizes = CakeSize::orderBy('size')->get();

        foreach ($cakes->items() as $cake) {
            if ($cake->image_url) {
                $cake->image_url = asset($cake->image_url);
            } else {
                $cake->image_url = asset('assets/image/default-img.jpg');
            }
        }

        return Inertia::render('ProductSection', [
            'cakes' => $cakes,
            'cakeSizes' => $cakeSizes
        ]);
    }

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
