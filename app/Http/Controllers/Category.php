<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Category extends Controller
{
    public function index()
    {
        $categories=Category::all();
        return view('categories.index', compact('categories'));
    }

    // single category
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    // Admin role: create new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'Category created');
    }

    // Admin role: edit category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($request->all());

        return redirect()->back()->with('success', 'Category updated');
    }

    // Admin role: delete category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted');
    }
}
}
