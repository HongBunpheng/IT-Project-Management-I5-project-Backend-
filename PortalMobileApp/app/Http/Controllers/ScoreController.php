<?php

namespace App\Http\Controllers;
use App\Models\Score;

use Illuminate\Http\Request;

class ScoreController extends Controller
{
    // GET /api/scores/user/{user_id}
    public function byStudent($user_id)
    {
        return Score::where('user_id', $user_id)
            ->with('exam.subject')
            ->get();
    }

    // GET /api/scores/exam/{exam_id}
    public function byExam($exam_id)
    {
        return Score::where('exam_id', $exam_id)
            ->with('user')
            ->get();
    }

    // POST /api/scores (assign score)
    public function store(Request $request)
    {
        $data = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'user_id' => 'required|exists:users,id',
            'score' => 'required|numeric',
            'grade' => 'nullable|string',
            'remark' => 'nullable|string',
        ]);

        return Score::create($data);
    }

    // PUT /api/scores/{id}
    public function update(Request $request, $id)
    {
        $score = Score::findOrFail($id);
        $score->update($request->all());
        return $score;
    }
}
