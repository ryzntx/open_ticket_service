<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

class CategoriesManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(5);

        return view('admins.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:categories,slug',
            'title_placeholder' => 'nullable|string',
            'desc_placeholder' => 'nullable|string',
        ]);

        try {
            Category::create($validate);
        } catch (\Exception $e) {
            Log::error('Failed to create category: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to create category');
        }

        return redirect()->route('admin.categories.index')->with('success', Lang::get('Category created successfully.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validate = $request->validate([
            'name' => 'required|string',
            'slug' => 'required|string|unique:categories,slug,' . $category->id, // Ensure slug is unique except for the current category
            'title_placeholder' => 'nullable|string',
            'desc_placeholder' => 'nullable|string',
        ]);

        try {
            $category->update($validate);
        } catch (\Exception $e) {
            Log::error('Failed to update category: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to update category');
        }

        return redirect()->route('admin.categories.index')->with('success', Lang::get('Category updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->load('tickets');
        if ($category->tickets->count() > 0) {
            return redirect()->back()->with('error', Lang::get('Cannot delete category with associated tickets.'));
        }

        try {
            $category->delete();
        } catch (\Exception $e) {
            Log::error('Failed to delete category: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to delete category');
        }

        return redirect()->route('admin.categories.index')->with('success', Lang::get('Category deleted successfully.'));
    }
}
