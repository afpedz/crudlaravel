<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        // Fetch categories with their children and paginate
        $categories = Categories::with('children')->whereNull('parent_id')->paginate(50);

        // Return the view with the categories
        return view('category', compact('categories')); // Adjusted to match your view file location
    }
}