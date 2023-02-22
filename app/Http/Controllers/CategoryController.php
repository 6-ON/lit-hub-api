<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isValid = $request->validate([
            'label' => 'required|max:50'
        ]);
        if ($isValid) {
            return Category::create([
                'label' => $request->label
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $isValid = $request->validate([
            'label' => 'sometimes|max:50'
        ]);
        if ($isValid) {
            $category->label = $request->label;
            $category->save();
            return $category;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): Response
    {
        $category->delete();
        return \response()->noContent();
    }
}
