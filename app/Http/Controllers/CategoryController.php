<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    /**
     * Display a category data in admin dashboard.
     *
     * @return Response
     */
    public function index(): Response
    {
        $cakeCategory = Category::paginate(5);

        return Inertia::render('AdminDashboard/CakeCategory/Index', [
            'cakeCategory' => $cakeCategory
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create($data);

        return redirect()->route('category.index')->with('success', 'The Cake Category has been created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $dashboard_category): JsonResponse
    {
        return response()->json($dashboard_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $dashboard_category): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $dashboard_category->update($data);

        return response()->json([
            'message' => 'The Cake Category has been changed',
            'category' => $dashboard_category,
        ]);
    }

    /**
     * Delete the cake category based on selected.
     *
     * @param Category $dashboard_category
     * @return RedirectResponse
     */
    public function destroy(Category $dashboard_category): RedirectResponse
    {
        $dashboard_category->delete();
        return redirect()->route('category.index')->with('success', 'The Cake Category has been deleted');
    }
}
