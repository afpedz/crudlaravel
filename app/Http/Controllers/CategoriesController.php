<?php
namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function index()
    {
        // Fetch categories and sort them alphabetically
        $categories = Categories::orderBy('name')->get();
        $categoryTree = Categories::with(['children' => function($query) {
            $query->orderBy('name');
        }])->whereNull('parent_id')->orderBy('name')->paginate(50);
        
        return view('category', compact('categories', 'categoryTree'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', 
        ]);
    
        Categories::create($request->only('name', 'parent_id'));
    
        return response()->json([
            'categoryTree' => Categories::with('children')->orderBy('name')->get(),
            'categories' => Categories::orderBy('name')->get() 
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', 
        ]);
    
        $category = Categories::findOrFail($id);
        $category->update($request->only('name', 'parent_id'));
    
        return response()->json([
            'categoryTree' => Categories::with('children')->orderBy('name')->get(), 
            'categories' => Categories::orderBy('name')->get() 
        ]);
    }    
    public function destroy($id)
    {
        $category = Categories::with('children')->findOrFail($id);
        
        foreach ($category->children as $child) {
            $this->destroy($child->id);
        }
    
        $category->delete(); 
    
        return response()->json([
            'categoryTree' => Categories::with('children')->orderBy('name')->get(), // Fetch all categories
            'categories' => Categories::orderBy('name')->get() // Return sorted categories
        ]);
    }
        


}