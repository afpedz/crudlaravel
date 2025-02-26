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
    
        $categoryTree = Categories::with('children')->whereNull('parent_id')->orderBy('name')->paginate(50);
    
        return view('category', compact('categories', 'categoryTree'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id', 
        ]);
    
        Categories::create($request->only('name', 'parent_id'));
    
        $categoryTree = Categories::with('children')->whereNull('parent_id')->orderBy('name')->get();
    
        return response()->json($categoryTree);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'parent_id' => 'nullable|exists:categories,id', 
        ]);
    

        $category = Categories::findOrFail($id);
        $category->update($request->only('name', 'parent_id'));

        $categoryTree = Categories::with('children')->whereNull('parent_id')->orderBy('name')->get();


        return response()->json($categoryTree);
    }
    public function destroy($id)
    {
        $category = Categories::with('children')->findOrFail($id);
    
        $category->children()->delete();
        $category->delete(); 
    
        $categoryTree = Categories::with('children')->whereNull('parent_id')->get();
    
        return response()->json($categoryTree);
    }
    


}