<?php

namespace App\Http\Controllers;
use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    public function get()
    {
        return ClassRoom::with('building')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'building_id' => 'required|exists:buildings,id',
            'floor' => 'nullable|integer',
            'room_type' => 'required|in:normal,lab,meeting,other'
        ]);

        return ClassRoom::create($validated);
    }

    public function show($id)
    {
        return ClassRoom::with('building')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $class = ClassRoom::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'building_id' => 'sometimes|exists:buildings,id',
            'floor' => 'sometimes|integer',
            'room_type' => 'sometimes|in:normal,lab,meeting,other'
        ]);
        
        $class->update($validated);

        return $class;
    }

    public function destroy($id)
    {
        ClassRoom::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted']);
    }
}

