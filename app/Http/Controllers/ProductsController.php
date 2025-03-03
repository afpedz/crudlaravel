<?php
namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Unit;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::orderBy('product_code')->paginate(50);
        $categories = Categories::all();
        $units = Unit::all();
        return view('products', compact('products', 'categories', 'units')); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|string|max:255|unique:products,product_code',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|regex:/^\d+(\.\d{2})?$/',
            'unit_id' => 'required|exists:units,id',
        ]);
    
        $product = Products::create($request->only('product_code', 'description', 'category_id', 'price', 'unit_id'));
    
        // Load the category and unit relationships
        $product->load('category', 'unit');
    
        return response()->json(['success' => true, 'product' => $product]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_code' => 'required|string|max:255|unique:products,product_code,' . $id,
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|regex:/^\d+(\.\d{2})?$/',
            'unit_id' => 'required|exists:units,id',
        ]);
    
        $product = Products::findOrFail($id);
        $product->update($request->only('product_code', 'description', 'category_id', 'price', 'unit_id'));
    
        // Load the category and unit relationships
        $product->load('category', 'unit');
    
        return response()->json(['success' => true, 'product' => $product]);
    }
        
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
    
        return response()->json(['success' => true, 'productId' => $id]);
    }
    
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        return response()->json(['product' => $product]);
    }
}