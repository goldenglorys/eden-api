<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Models\CountriesOfDomicile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Cache;

class GardenersPerCountryController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/gardenersByCountry",
     * summary="Display all gardeners per country and their respective numbers of customers they have each.",
     * description="Get all gardeners per country and their respective numbers of  customers they have each",
     * operationId="countries",
     * tags={"gardenersByCountry"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     ),
     * )
     */
    public function index()
    {
        try {
            if (Cache::has('allGardenersByCountries')) {
                return Cache::get('allGardenersByCountries');
            }
            $gardenersByCountries = CountriesOfDomicile::with('gardeners')->withCount('customers')->get();
            if (empty($gardenersByCountries)) {
                return response()->json([
                    'success' => true,
                    'data' => $gardenersByCountries,
                ], 404);
            }
            $allGardenersByCountries = response()->json([
                'success' => true,
                'data' => $gardenersByCountries,
            ], Response::HTTP_OK);
            Cache::put('allGardenersByCountries', $allGardenersByCountries, 3);
            return $allGardenersByCountries;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     * path="/api/v1/gardenersByCountry/{countryId}",
     * summary="Country of domicile by id and gardeners per country and their respective numbers of  customers they have each",
     * description="Get country by id and gardeners per country and their respective numbers of  customers they have each",
     * operationId="countriesById",
     * tags={"gardenersByCountry"},
     * @OA\Parameter(
     *    description="ID of country",
     *    in="path",
     *    name="countryId",
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
     *    description="Gardener with given ID not found",
     *     ),
     * )
     */
    public function show($id)
    {
        try {
            if (Cache::has('singleGardenerByCountries')) {
                return Cache::get('singleGardenerByCountries');
            }
            $gardenersByCountries = CountriesOfDomicile::with('gardeners')->withCount('customers')->where('countries_of_domicile.id', $id)->get();
            if ($gardenersByCountries->isEmpty()) throw new ModelNotFoundException;
            $singleGardenerByCountries = response()->json([
                'success' => true,
                'data' => $gardenersByCountries,
            ], 200);
            Cache::put('singleGardenerByCountries', $singleGardenerByCountries, 3);
            return $singleGardenerByCountries;
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
