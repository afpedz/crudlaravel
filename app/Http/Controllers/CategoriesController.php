<?php
namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        
        $categories = Categories::all();

       
        $categoryTree = Categories::with('children')->whereNull('parent_id')->paginate(50);

        return view('category', compact('categories', 'categoryTree'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        
        Categories::create($request->only('name', 'parent_id'));

       
        return redirect()->back()->with('success', 'Category added successfully!');
    }
}