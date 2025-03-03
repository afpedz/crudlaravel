<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('name')->paginate(50);
        return view('units', compact('units')); 
    }
    
    public function store(Request $request)
    {
        $request->validate([    
            'name' => 'required|string|max:255|unique:units,name',
        ]);

        $unit = Unit::create($request->only('name'));

        return response()->json([
            'success' => true,
            'unit' => $unit
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $id,
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update($request->only('name'));

        return response()->json([
            'success' => true,
            'unit' => $unit
        ]);
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return response()->json([
            'success' => true,
            'id' => $id
        ]);
    }
}