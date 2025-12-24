<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/groups",
     *   tags={"Groups"},
     *   summary="List all groups",
     *   @OA\Response(
     *     response=200,
     *     description="List of groups with department and students"
     *   )
     * )
     */

    public function index()
    {
        return response()->json(
            Group::with(['department', 'students'])->get(),
            200
        );
    }

    /**
     * @OA\Post(
     *   path="/api/groups",
     *   tags={"Groups"},
     *   summary="Create a new group",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name","department_id","academic_year_id"},
     *       @OA\Property(property="name", type="string", example="G5-A"),
     *       @OA\Property(property="department_id", type="integer", example=1),
     *       @OA\Property(property="academic_year_id", type="integer", example=2025)
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Group created successfully"
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
            'name'             => 'required|string|max:50',
            'department_id'    => 'required|exists:departments,id',
            'academic_year_id' => 'nullable|integer',
        ]);

        $group = Group::create($validated);

        return response()->json([
            'message' => 'Group created successfully',
            'group'   => $group
        ], 201);
    }

    /**
     * @OA\Put(
     *   path="/api/groups/{id}",
     *   tags={"Groups"},
     *   summary="Update group",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="G5-B"),
     *       @OA\Property(property="department_id", type="integer", example=2),
     *       @OA\Property(property="academic_year_id", type="integer", example=2026)
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Group updated successfully"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Group not found"
     *   )
     * )
     */

    public function update(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        $validated = $request->validate([
            'name'             => 'nullable|string|max:50',
            'department_id'    => 'nullable|exists:departments,id',
            'academic_year_id' => 'nullable|integer',
        ]);

        $group->update($validated);

        return response()->json([
            'message' => 'Group updated successfully',
            'group'   => $group
        ]);
    }

    /**
     * @OA\Put(
     *   path="/api/groups/{group_id}/assign-students",
     *   tags={"Groups"},
     *   summary="Assign students to a group",
     *   @OA\Parameter(
     *     name="group_id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"student_ids"},
     *       @OA\Property(
     *         property="student_ids",
     *         type="array",
     *         @OA\Items(type="integer", example=12)
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Students assigned successfully"
     *   ),
     *   @OA\Response(
     *     response=422,
     *     description="Validation error"
     *   )
     * )
     */

    public function assignStudents(Request $request, $group_id)
    {
        $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:users,id'
        ]);

        User::whereIn('id', $request->student_ids)
            ->update(['group_id' => $group_id]);

        // update total_student automatically
        $count = User::where('group_id', $group_id)->count();
        Group::where('id', $group_id)->update(['total_student' => $count]);

        return response()->json([
            'message'       => 'Students assigned successfully',
            'group_id'      => $group_id,
            'total_student' => $count,
            'students'      => $request->student_ids
        ]);
    }

    /**
     * @OA\Delete(
     *   path="/api/groups/{id}",
     *   tags={"Groups"},
     *   summary="Delete group",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Group deleted successfully"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Group not found"
     *   )
     * )
     */

    public function destroy($id)
    {
        Group::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Group deleted successfully'
        ]);
    }
}
