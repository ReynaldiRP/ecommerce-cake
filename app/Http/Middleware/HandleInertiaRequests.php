<?php

namespace App\Http\Middleware;

use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ShoppingChartController;
use App\Models\Cake;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $searchData = $this->getSearchResults($request);
        $cartItems = $this->getShoppingChartItems();


        return array_merge(parent::share($request), [
            'auth.user' => fn() => $request->user(),
            'auth.user.name' => fn() => $request->user()?->username,
            'user.role' => fn() => $request->user()?->roles->pluck('name')->first() ?? 'user',
            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'info' => fn() => $request->session()->get('info'),
            ],
            'search' => $searchData,
            'shoppingChartItems' => $cartItems,
        ]);
    }


    /**
     * Retrieves the search results and query from the search controller.
     *
     * @param Request $request The HTTP request object.
     * @return array An array containing the search results and query.
     */
    public function getSearchResults(Request $request): array
    {
        $searchResults = [];
        $query = '';

        $searchController = new FrontEndController();

        if ($request->filled('search')) {
            $searchData = $searchController->search($request)->getData();
            $searchResults = $searchData->searchResults;
            $query = $searchData->query ?? '';
        }

        return [
            'searchResults' => $searchResults,
            'query' => $query,
        ];
    }

    public function getShoppingChartItems()
    {
        $shoppingChartItems = new ShoppingChartController();
        $shoppingChartItems = $shoppingChartItems->getShoppingChartItems();

        return $shoppingChartItems;
    }
}
