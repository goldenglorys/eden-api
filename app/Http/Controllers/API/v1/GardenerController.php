<?php

namespace App\Http\Controllers\APi\v1;

use App\Models\Gardeners;
use Illuminate\Http\Request;
use App\Models\LocationAreas;
use App\Models\CountriesOfDomicile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GardenerController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/gardeners",
     * summary="Display all Gardeners",
     * description="Get all gardeners",
     * operationId="gardeners",
     * tags={"gardeners"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     ),
     * )
     */
    public function index()
    {
        try {
            $gardeners = Gardeners::all();
            return response()->json([
                'success' => true,
                'data' => $gardeners,
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
     * path="/api/v1/gardeners/{gardenerId}",
     * summary="Gardener by id",
     * description="Get gardener by id",
     * operationId="gardenersById",
     * tags={"gardeners"},
     * @OA\Parameter(
     *    description="ID of gardener",
     *    in="path",
     *    name="gardenerId",
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
            $gardener = Gardeners::findorFail($id);
            return response()->json([
                'success' => true,
                'data' => $gardener,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     * path="/api/v1/gardeners",
     * summary="Register Gardeners",
     * description="Add a new gardener to the garden/system",
     * operationId="gardenerRegister",
     * tags={"gardeners"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass gardeners details (Location-Area and Country must be code-name returned from each of their endpoint)",
     *    @OA\JsonContent(
     *       required={"full_name","email", "location_area", "country_of_domicile"},
     *       @OA\Property(property="full_name", type="string", example="Firstname Lastname"),
     *       @OA\Property(property="email", type="string", format="email", example="gardener@mail.com"),
     *       @OA\Property(property="location_area", type="string", example="LA"),
     *       @OA\Property(property="country_of_domicile", type="string", example="NG"),
     *    ),
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Bad Request"
     *     ),
     * @OA\Response(
     *     response=422,
     *     description="Validation error",
     *     @OA\JsonContent(
     *        @OA\Property(property="success", type="boolean", example="false"),
     *        @OA\Property(
     *           property="errors",
     *           type="object",
     *           @OA\Property(
     *              property="full_name",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The full name field is required."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="email",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The email field is required."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="location_area",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The location area field is required."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="country_of_domicile",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The country of domicile field is required."},
     *              )
     *           )
     *        )
     *     )
     *  )
     * )
     */
    public function store(Request $request)
    {
        $validationArray = [
            'full_name'             => 'required',
            'email'                 => 'required',
            'location_area'         => 'required',
            'country_of_domicile'   => 'required',
        ];
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $getCountry = CountriesOfDomicile::where('code', $request->country_of_domicile)->first();
        if (empty($getCountry)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid country code. Please pick from the available code in the system'
            ], Response::HTTP_BAD_REQUEST);
        }

        $getLocationArea = LocationAreas::where(['code' => $request->location_area, 'country' => $getCountry->id])->first();
        if (empty($getLocationArea)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid location area code. Please pick from the available code in the system'
            ], Response::HTTP_BAD_REQUEST);
        }


        if (!empty($getCountry) && !empty($getLocationArea)) {
            $request['location_area'] = $getLocationArea->id;
            $request['country_of_domicile'] = $getCountry->id;
            try {
                $gardener = Gardeners::create($request->all());
                return response()->json([
                    'success' => true,
                    'data' => $gardener,
                ], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @OA\Put(
     * path="/api/v1/gardeners/{id}",
     * summary="Update Existing Gardener",
     * description="Returns updated gardner data",
     * operationId="gardenerUpdate",
     * tags={"gardeners"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Gardener id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass gardeners details (Location-Area and Country must be code-name returned from each of their endpoint)",
     *    @OA\JsonContent(
     *       required={"full_name","email", "location_area", "country_of_domicile"},
     *       @OA\Property(property="full_name", type="string", example="Firstname Lastname"),
     *       @OA\Property(property="email", type="string", format="email", example="gardener@mail.com"),
     *       @OA\Property(property="location_area", type="string", example="LA"),
     *       @OA\Property(property="country_of_domicile", type="string", example="NG"),
     *    ),
     * ),
     * @OA\Response(
     *    response=202,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Bad Request"
     *     ),
     * @OA\Response(
     *     response=422,
     *     description="Validation error",
     *     @OA\JsonContent(
     *        @OA\Property(property="success", type="boolean", example="false"),
     *        @OA\Property(
     *           property="errors",
     *           type="object",
     *           @OA\Property(
     *              property="full_name",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The full name field is required."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="email",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The email field is required."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="location_area",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The location area field is required."},
     *              )
     *           ),
     *           @OA\Property(
     *              property="country_of_domicile",
     *              type="array",
     *              collectionFormat="multi",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The country of domicile field is required."},
     *              )
     *           )
     *        )
     *     )
     *  )
     * )
     */
    public function update(Request $request, $id)
    {
        $validationArray = [
            'full_name'             => 'required',
            'email'                 => 'required',
            'location_area'         => 'required',
            'country_of_domicile'   => 'required',
        ];
        $validator = Validator::make($request->all(), $validationArray);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $getCountry = CountriesOfDomicile::where('code', $request->country_of_domicile)->first();
        if (empty($getCountry)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid country code. Please pick from the available code in the system'
            ], Response::HTTP_BAD_REQUEST);
        }

        $getLocationArea = LocationAreas::where(['code' => $request->location_area, 'country' => $getCountry->id])->first();
        if (empty($getLocationArea)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid location area code. Please pick from the available code in the system'
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!empty($getCountry) && !empty($getLocationArea)) {
            $request['location_area'] = $getLocationArea->id;
            $request['country_of_domicile'] = $getCountry->id;
            try {
                $gardener = Gardeners::where('id', $id)->update($request->all());
                return response()->json([
                    'success' => true,
                    'data' => Gardeners::where('id', $id)->first(),
                ], Response::HTTP_ACCEPTED);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/gardeners/{id}",
     *      operationId="deleteGardener",
     *      tags={"gardeners"},
     *      summary="Delete existing gardener",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Gardener id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *       ),
     * ),
     * )
     */
    public function destroy($id)
    {
        try {
            $gardener = Gardeners::destroy($id);
            return response()->json([
                'success' => true,
                'data' => $gardener,
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
