<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LocationAreas;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationAreaController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/locations",
     * summary="Display all Location Areas and their respective customers",
     * description="Get all location areas and their respective customers",
     * operationId="locations",
     * tags={"locations"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     ),
     * )
     */
    public function index()
    {
        try {
            $locationAreas = LocationAreas::with(['customers', 'country'])->get();
            return response()->json([
                'success' => true,
                'data' => $locationAreas,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/api/v1/locations/{locationId}",
     * summary="Location Area by id and their respective customers",
     * description="Get location area by id and their respective customers",
     * operationId="locationsById",
     * tags={"locations"},
     * @OA\Parameter(
     *    description="ID of location",
     *    in="path",
     *    name="locationId",
     *    required=true,
     *    example="1",
     *    @OA\Schema(
     *       type="integer",
     *       format="int64"
     *    )
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Location with given ID not found",
     *     ),
     * )
     */
    public function show($id)
    {
        try {
            $locationArea = LocationAreas::with(['customers', 'country'])->where('location_areas.id', $id)->get();
            if ($locationArea->isEmpty()) throw new ModelNotFoundException;
            return response()->json([
                'success' => true,
                'data' => $locationArea,
            ], 200);
        } catch (\Exception $e) {
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'success' => true,
                    'error' => 'Data not found.'
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
