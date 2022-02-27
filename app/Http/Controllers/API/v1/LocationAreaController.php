<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Models\LocationAreas;

class LocationAreaController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/locations",
     * summary="Display all Location Areas",
     * description="Get all location areas",
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
            $locationAreas = LocationAreas::all();
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
     * summary="Location Area by id",
     * description="Get location area by id",
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
     * )
     */
    public function show($id)
    {
        try {
            $locationArea = LocationAreas::findorFail($id);
            return response()->json([
                'success' => true,
                'data' => $locationArea,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
