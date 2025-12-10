<?php

namespace App\Http\Controllers;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function get()
    {
        return Building::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'nullable|string',
            'code' => 'required|string|unique:buildings,code'
        ]);

        return Building::create($validated);
    }

    public function show($id)
    {
        return Building::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $building = Building::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'code' => 'sometimes|string|unique:buildings,code,' . $id
        ]);

        $building->update($validated);

        return $building;
    }

    public function destroy($id)
    {
        Building::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted']);
    }
}
