<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // GET /api/subjects
    public function index()
    {
        return Subject::with(['department', 'semester'])->get();
    }

    // GET /api/subjects/{id}
    public function show($id)
    {
        return Subject::with(['department', 'semester'])->findOrFail($id);
    }

    // GET /api/subjects/semester/{semester_id}
    public function bySemester($semester_id)
    {
        return Subject::where('semester_id', $semester_id)
            ->with(['department', 'semester'])
            ->get();
    }

    // POST /api/subjects
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'credit' => 'required|integer',
            'department_id' => 'required|exists:departments,id',
            'year_level' => 'required|integer',
            'semester_id' => 'required|exists:semesters,id',
        ]);

        return Subject::create($data);
    }

    // PUT /api/subjects/{id}
    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'credit' => 'sometimes|integer',
            'department_id' => 'sometimes|exists:departments,id',
            'year_level' => 'sometimes|integer',
            'semester_id' => 'sometimes|exists:semesters,id',
        ]);

        $subject->update($data);
        return $subject;
    }

    // DELETE /api/subjects/{id}
    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return response()->json(['message' => 'Subject deleted']);
    }
}
