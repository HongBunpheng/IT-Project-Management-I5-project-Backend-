<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/departments",
     *   tags={"Departments"},
     *   summary="List all departments",
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *     response=200,
     *     description="List of departments"
     *   )
     * )
     */

    public function index()
    {
        return response()->json(Department::all(), 200);
    }

    /**
     * @OA\Post(
     *   path="/api/departments",
     *   tags={"Departments"},
     *   summary="Create a new department",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name"},
     *       @OA\Property(property="name", type="string", example="Information Technology"),
     *       @OA\Property(property="code", type="string", example="IT"),
     *       @OA\Property(property="description", type="string", example="IT Department")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Department created successfully"
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validation error"
     *   )
     * )
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
     * @OA\Put(
     *   path="/api/departments/{id}",
     *   tags={"Departments"},
     *   summary="Update department",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Computer Science"),
     *       @OA\Property(property="code", type="string", example="CS"),
     *       @OA\Property(property="description", type="string", example="CS Department")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Department updated successfully"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Department not found"
     *   )
     * )
     */

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'name'       => 'nullable|string|max:50',
            'code'       => 'nullable|string|max:50',
            'description' => 'nullable|string'
        ]);

        $department->update($validated);

        return response()->json([
            'message' => 'Department updated successfully',
            'department' => $department
        ], 200);
    }

    /**
     * @OA\Delete(
     *   path="/api/departments/{id}",
     *   tags={"Departments"},
     *   summary="Delete department",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Department deleted successfully"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Department not found"
     *   )
     * )
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
