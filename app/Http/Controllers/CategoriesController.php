<?php
namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Categories::all();
    
        // Fetch the category tree ordered by name
        $categoryTree = Categories::with('children')->whereNull('parent_id')->orderBy('name')->paginate(50);
    
        return view('category', compact('categories', 'categoryTree'));
    }
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', 
        ]);
    
        // Create a new category
        Categories::create($request->only('name', 'parent_id'));
    
        // Fetch the updated category tree ordered by name
        $categoryTree = Categories::with('children')->whereNull('parent_id')->orderBy('name')->get();
    
        // Return the updated category tree as a JSON response
        return response()->json($categoryTree);
    }
    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'parent_id' => 'nullable|exists:categories,id', 
        ]);
    

        // Find the category and update it
        $category = Categories::findOrFail($id);
        $category->update($request->only('name', 'parent_id'));

        // Fetch the updated category tree
        $categoryTree = Categories::with('children')->whereNull('parent_id')->orderBy('name')->get();


        // Return the updated category tree as a JSON response
        return response()->json($categoryTree);
    }
    public function destroy($id)
    {
        // Find the category
        $category = Categories::with('children')->findOrFail($id);
    
        // Delete the category and its children
        $category->children()->delete();
        $category->delete(); 
    
        // Fetch the updated category tree
        $categoryTree = Categories::with('children')->whereNull('parent_id')->get();
    
        // Return the updated category tree as a JSON response
        return response()->json($categoryTree);
    }
    


}