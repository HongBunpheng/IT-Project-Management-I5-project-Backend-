<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * @OA\Get(
     *   path="/api/buildings",
     *   tags={"Buildings"},
     *   summary="Get all buildings",
     *   @OA\Response(
     *     response=200,
     *     description="List of buildings"
     *   )
     * )
     */
    public function get()
    {
        return Building::all();
    }

    /**
     * @OA\Post(
     *   path="/api/buildings",
     *   tags={"Buildings"},
     *   summary="Create a new building",
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       required={"name","code"},
     *       @OA\Property(property="name", type="string", example="Main Building"),
     *       @OA\Property(property="address", type="string", example="ITC Campus"),
     *       @OA\Property(property="code", type="string", example="B01")
     *     )
     *   ),
     *   @OA\Response(
     *     response=201,
     *     description="Building created"
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
            'address' => 'nullable|string',
            'code' => 'required|string|unique:buildings,code'
        ]);

        return Building::create($validated);
    }

    /**
     * @OA\Get(
     *   path="/api/buildings/{id}",
     *   tags={"Buildings"},
     *   summary="Get building by ID",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Building detail"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Building not found"
     *   )
     * )
     */
    public function show($id)
    {
        return Building::findOrFail($id);
    }

    /**
     * @OA\Put(
     *   path="/api/buildings/{id}",
     *   tags={"Buildings"},
     *   summary="Update building",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="Updated Building"),
     *       @OA\Property(property="address", type="string", example="New Address"),
     *       @OA\Property(property="code", type="string", example="B02")
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Building updated"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Building not found"
     *   )
     * )
     */
    public function update(Request $request, $id)
    {
        $building = Building::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string',
            'address' => 'sometimes|string',
            'code' => 'sometimes|string|unique:buildings,code,' . $id
        ]);

        $building->update($validated);

        return $building;
    }

    /**
     * @OA\Delete(
     *   path="/api/buildings/{id}",
     *   tags={"Buildings"},
     *   summary="Delete building",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Building deleted"
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Building not found"
     *   )
     * )
     */
    public function destroy($id)
    {
        Building::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted']);
    }
}
