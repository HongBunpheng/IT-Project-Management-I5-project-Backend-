<?php

namespace App\Http\Controllers;
use App\Models\Exam;

use Illuminate\Http\Request;

class ExamController extends Controller
{
    // GET /api/exams/group/{group_id}
    public function byGroup($group_id)
    {
        return Exam::where('group_id', $group_id)
            ->with('subject')
            ->get();
    }

    // GET /api/exams/{id}
    public function show($id)
    {
        return Exam::with(['subject', 'group'])->findOrFail($id);
    }

    // POST /api/exams
    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'group_id' => 'required|exists:groups,id',
            'title' => 'required|string',
            'exam_type' => 'required|in:quiz,midterm,final',
            'exam_date' => 'required|date',
            'total_mark' => 'required|integer',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        return Exam::create($data);
    }

    // PUT /api/exams/{id}
    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);

        $exam->update($request->all());
        return $exam;
    }

    // DELETE /api/exams/{id}
    public function destroy($id)
    {
        Exam::findOrFail($id)->delete();
        return response()->json(['message' => 'Exam deleted']);
    }
}
