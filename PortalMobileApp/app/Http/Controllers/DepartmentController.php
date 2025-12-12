<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * LIST ALL DEPARTMENTS
     */
    public function index()
    {
        return response()->json(Department::all(), 200);
    }

    /**
     * CREATE DEPARTMENT
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string'
        ]);

        $department = Department::create($validated);

        return response()->json([
            'message' => 'Department created successfully',
            'department' => $department
        ], 201);
    }

    /**
     * UPDATE DEPARTMENT
     */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'nullable|string|max:50',
            'code'       => 'nullable|string|max:50',
            'description'=> 'nullable|string'
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department
        ], 200);
    }

    /**
     * DELETE DEPARTMENT
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully'
        ], 200);
    }
}
