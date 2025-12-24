<?php

namespace App\Http\Controllers;

use App\Models\ClassRoom;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/classes",
     *   tags={"Classes"},
     *   summary="Get all classrooms",
     *   @OA\Response(
     *     response=200,
     *     description="List of classrooms with building"
     *   )
     * )
     */
    public function get()
    {
        return ClassRoom::with('building')->get();
    }
    /**
     * @OA\Post(
     *   path="/api/classes",
     *   tags={"Classes"},
     *   summary="Create a new classroom",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name","building_id","room_type"},
     *       @OA\Property(property="name", type="string", example="Room A101"),
     *       @OA\Property(property="building_id", type="integer", example=1),
     *       @OA\Property(property="floor", type="integer", example=1),
     *       @OA\Property(
     *         property="room_type",
     *         type="string",
     *         enum={"normal","lab","meeting","other"},
     *         example="lab"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Classroom created"
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
            'name' => 'required|string',
            'building_id' => 'required|exists:buildings,id',
            'floor' => 'nullable|integer',
            'room_type' => 'required|in:normal,lab,meeting,other'
        ]);

        return ClassRoom::create($validated);
    }

    /**
     * @OA\Get(
     *   path="/api/classes/{id}",
     *   tags={"Classes"},
     *   summary="Get classroom by ID",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Classroom detail with building"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Classroom not found"
     *   )
     * )
     */
    public function show($id)
    {
        return ClassRoom::with('building')->findOrFail($id);
    }

    /**
     * @OA\Put(
     *   path="/api/classes/{id}",
     *   tags={"Classes"},
     *   summary="Update classroom",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Room B202"),
     *       @OA\Property(property="building_id", type="integer", example=2),
     *       @OA\Property(property="floor", type="integer", example=2),
     *       @OA\Property(
     *         property="room_type",
     *         type="string",
     *         enum={"normal","lab","meeting","other"},
     *         example="normal"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Classroom updated"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Classroom not found"
     *   )
     * )
     */

    public function update(Request $request, $id)
    {
        $class = ClassRoom::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'building_id' => 'sometimes|exists:buildings,id',
            'floor' => 'sometimes|integer',
            'room_type' => 'sometimes|in:normal,lab,meeting,other'
        ]);

        $class->update($validated);

        return $class;
    }

    /**
     * @OA\Delete(
     *   path="/api/classes/{id}",
     *   tags={"Classes"},
     *   summary="Delete classroom",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Classroom deleted"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Classroom not found"
     *   )
     * )
     */
    public function destroy($id)
    {
        ClassRoom::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted']);
    }
}
