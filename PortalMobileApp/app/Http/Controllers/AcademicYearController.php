<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    // GET /api/academic-years
    public function index()
    {
        return AcademicYear::all();
    }

    // POST /api/academic-years
    public function store(Request $request)
    {
        $data = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'year_level' => 'required|integer',
            'year_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_current' => 'boolean',
        ]);

        // Optional: ensure only one current year
        if (!empty($data['is_current']) && $data['is_current']) {
            AcademicYear::where('is_current', true)->update(['is_current' => false]);
        }

        return AcademicYear::create($data);
    }

    // PUT /api/academic-years/{id}
    public function update(Request $request, $id)
    {
        $year = AcademicYear::findOrFail($id);

        $data = $request->validate([
            'department_id' => 'sometimes|exists:departments,id',
            'year_level' => 'sometimes|integer',
            'year_name' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date',
            'is_current' => 'boolean',
        ]);

        if (!empty($data['is_current']) && $data['is_current']) {
            AcademicYear::where('is_current', true)->update(['is_current' => false]);
        }

        $year->update($data);
        return $year;
    }

    // DELETE /api/academic-years/{id}
    public function destroy($id)
    {
        AcademicYear::findOrFail($id)->delete();
        return response()->json(['message' => 'Academic year deleted']);
    }
}
