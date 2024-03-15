<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Retrieve all categories belonging to the authenticated user
        $categories = auth()->user()->categories;

        // Return the view with the categories data
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        // Return the view for creating a new category
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new Category instance
        $category = new Category($validatedData);

        // Set the user ID manually
        $category->user_id = auth()->id();

        // Save the category
        $category->save();

        // Redirect back to the index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        // Return the view for editing an existing category
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the category
        $category->update($validatedData);

        // Redirect back to the index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function show(Category $category)
    {
        // Return the view for showing the details of a category
        return view('categories.show', compact('category'));
    }

    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();
        
        // Redirect back to the index page with a success message
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
