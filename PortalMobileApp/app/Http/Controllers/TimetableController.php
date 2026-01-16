<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/timetable/user/{user_id}",
     *   tags={"Timetable"},
     *   summary="Get timetable for a student (by user)",
     *   @OA\Parameter(
     *     name="user_id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="List of timetable for student's group"
     *   )
     * )
     */
    public function listByUser($user_id)
    {
        $user = User::findOrFail($user_id);

        return Timetable::with(['teacher', 'group', 'classroom','subject'])
            ->where('group_id', $user->group_id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    /**
     * @OA\Get(
     *   path="/api/timetable/group/{group_id}",
     *   tags={"Timetable"},
     *   summary="Get timetable by group",
     *   @OA\Parameter(
     *     name="group_id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="List of timetable for a group"
     *   )
     * )
     */
    public function listByGroup($group_id)
    {
        return Timetable::with(['teacher', 'group', 'classroom','subject'])
            ->where('group_id', $group_id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    /**
     * @OA\Post(
     *   path="/api/timetable",
     *   tags={"Timetable"},
     *   summary="Create a timetable",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"user_id","group_id","class_id","day_of_week","start_time","end_time"},
     *       @OA\Property(property="user_id", type="integer", example=10),
     *       @OA\Property(property="group_id", type="integer", example=1),
     *       @OA\Property(property="class_id", type="integer", example=3),
     *       @OA\Property(property="semester_id", type="integer", example=2),
     *       @OA\Property(property="subject_id", type="integer", example=5),
     *       @OA\Property(property="day_of_week", type="string", example="Mon"),
     *       @OA\Property(property="title", type="string", example="Network Fundamentals"),
     *       @OA\Property(property="start_time", type="string", example="08:00"),
     *       @OA\Property(property="end_time", type="string", example="10:00")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Timetable created successfully"
     *   )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'group_id'    => 'required|exists:groups,id',
            'class_id'    => 'required|exists:classes,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'subject_id'  => 'nullable|integer',
            'day_of_week' => 'required|in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'title'       => 'nullable|string',
            'start_time'  => 'required',
            'end_time'    => 'required',
        ]);

        return Timetable::create($data);
    }

    /**
     * @OA\Put(
     *   path="/api/timetable/{id}",
     *   tags={"Timetable"},
     *   summary="Update a timetable",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     @OA\JsonContent(
     *       @OA\Property(property="title", type="string", example="Updated Title"),
     *       @OA\Property(property="day_of_week", type="string", example="Tue"),
     *       @OA\Property(property="start_time", type="string", example="09:00"),
     *       @OA\Property(property="end_time", type="string", example="11:00")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Timetable updated successfully"
     *   )
     * )
     */
    public function update(Request $request, $id)
    {
        $timetable = Timetable::findOrFail($id);

        $data = $request->validate([
            'user_id'     => 'sometimes|exists:users,id',
            'group_id'    => 'sometimes|exists:groups,id',
            'class_id'    => 'sometimes|exists:classes,id',
            'semester_id' => 'nullable|exists:semesters,id',
            'subject_id'  => 'nullable|integer',
            'day_of_week' => 'sometimes|in:Mon,Tue,Wed,Thu,Fri,Sat,Sun',
            'title'       => 'sometimes|string',
            'start_time'  => 'sometimes',
            'end_time'    => 'sometimes',
        ]);

        $timetable->update($data);
        return $timetable;
    }

    /**
     * @OA\Delete(
     *   path="/api/timetable/{id}",
     *   tags={"Timetable"},
     *   summary="Delete a timetable",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Timetable deleted successfully"
     *   )
     * )
     */
    public function destroy($id)
    {
        Timetable::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted']);
    }
}