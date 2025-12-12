<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // LIST GROUPS
    public function index()
    {
        return response()->json(
            Group::with(['department', 'students'])->get(),
        200);
    }

    // CREATE GROUP
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:50',
            'department_id'    => 'required|exists:departments,id',
            'academic_year_id' => 'required|integer',
        ]);

        $group = Group::create($validated);

        return response()->json([
            'message' => 'Group created successfully',
            'group'   => $group
        ], 201);
    }

    // UPDATE GROUP
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

    // ASSIGN STUDENTS
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

    // DELETE GROUP
    public function destroy($id)
    {
        Group::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Group deleted successfully'
        ]);
    }
}
