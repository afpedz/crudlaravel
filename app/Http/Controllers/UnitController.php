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

    public function show($id)
    {
        $unit = Unit::findOrFail($id);
        return response()->json($unit);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name',
        ]);

        $unit = Unit::create($request->only('name'));

        return redirect()->route('units.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:units,name,' . $id,
        ]);

        $unit = Unit::findOrFail($id);
        $unit->update($request->only('name'));

        return redirect()->route('units.index');
    }

    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();

        return redirect()->route('units.index');
    }
}
