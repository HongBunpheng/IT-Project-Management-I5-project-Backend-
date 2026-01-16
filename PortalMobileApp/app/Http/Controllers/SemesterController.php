<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    // GET /api/semesters
    public function index()
    {
        return Semester::with('academicYear')->get();
    }

    // POST /api/semesters
    public function store(Request $request)
    {
        $data = $request->validate([
            'acad_year_id' => 'required|exists:academic_years,id',
            'semester_num' => 'required|integer|in:1,2',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_current' => 'boolean',
        ]);

        // Optional: only one current semester
        if (!empty($data['is_current']) && $data['is_current']) {
            Semester::where('is_current', true)->update(['is_current' => false]);
        }

        return Semester::create($data);
    }

    // PUT /api/semesters/{id}
    public function update(Request $request, $id)
    {
        $semester = Semester::findOrFail($id);

        $data = $request->validate([
            'acad_year_id' => 'sometimes|exists:academic_years,id',
            'semester_num' => 'sometimes|integer|in:1,2',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'is_current' => 'boolean',
        ]);

        if (!empty($data['is_current']) && $data['is_current']) {
            Semester::where('is_current', true)->update(['is_current' => false]);
        }

        $semester->update($data);
        return $semester;
    }

    // DELETE /api/semesters/{id}
    public function destroy($id)
    {
        Semester::findOrFail($id)->delete();
        return response()->json(['message' => 'Semester deleted']);
    }
}
