<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Models\LocationAreas;
use App\Models\CountriesOfDomicile;
use App\Http\Controllers\Controller;
use App\Models\Gardeners;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CustomerController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/v1/customers",
     * summary="Display all Customers and their respective gardener",
     * description="Get all customers and their respective gardener",
     * operationId="customers",
     * tags={"customers"},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *     ),
     * )
     */
    public function index()
    {
        try {
            $customers = Customers::with(['gardener', 'country', 'location'])->get();
            return response()->json([
                'success' => true,
                'data' => $customers,
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
     * path="/api/v1/customers/{customerId}",
     * summary="Customer by id and their gardener",
     * description="Get customer by id and their gardener",
     * operationId="customersById",
     * tags={"customers"},
     * @OA\Parameter(
     *    description="ID of customer",
     *    in="path",
     *    name="customerId",
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
     *    description="Customer with given ID not found",
     *     ),
     * )
     */
    public function show($id)
    {
        try {
            $customer = Customers::with(['gardener', 'country', 'location'])->findorFail($id);
            return response()->json([
                'success' => true,
                'data' => $customer,
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

    /**
     * @OA\Post(
     * path="/api/v1/customers",
     * summary="Register Customers",
     * description="Add a new customer to the system",
     * operationId="customerRegister",
     * tags={"customers"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass customers details (Location-Area and Country must be code-name returned from each of their endpoint)",
     *    @OA\JsonContent(
     *       required={"full_name","email", "location_area", "country_of_domicile"},
     *       @OA\Property(property="full_name", type="string", example="Firstname Lastname"),
     *       @OA\Property(property="email", type="string", format="email", example="customer@mail.com"),
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
     @OA\Response(
     *    response=406,
     *    description="Not acceptable",
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
            $gardener = Gardeners::where(['location_area' => $getLocationArea->id, 'country_of_domicile' => $getCountry->id])->inRandomOrder()->first();

            $request['location_area'] = $getLocationArea->id;
            $request['country_of_domicile'] = $getCountry->id;
            $request['gardener'] = $gardener->id;

            try {
                $customer = Customers::create($request->all());
                return response()->json([
                    'success' => true,
                    'data' => $customer,
                ], Response::HTTP_CREATED);
            } catch (\Exception $e) {
                if ($e instanceof QueryException) {
                    return response()->json([
                        'success' => true,
                        'error' => 'Customer with ' . $request->email . ' email aleady exists.'
                    ], Response::HTTP_NOT_ACCEPTABLE);
                }
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
    /**
     * @OA\Put(
     * path="/api/v1/customers/{id}",
     * summary="Update Existing Customer",
     * description="Returns updated customer data",
     * operationId="customerUpdate",
     * tags={"customers"},
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass customer details (Location-Area and Country must be code-name returned from each of their endpoint)",
     *    @OA\JsonContent(
     *       required={"full_name","email", "location_area", "country_of_domicile"},
     *       @OA\Property(property="full_name", type="string", example="Firstname Lastname"),
     *       @OA\Property(property="email", type="string", format="email", example="customer@mail.com"),
     *       @OA\Property(property="location_area", type="string", example="LA"),
     *       @OA\Property(property="country_of_domicile", type="string", example="NG"),
     *       @OA\Property(property="gardener", type="integer"),
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
     *    response=404,
     *    description="Customer with given ID not found",
     *     ),
     @OA\Response(
     *    response=406,
     *    description="Not acceptable",
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
     *           ),
     *           @OA\Property(
     *              property="gardener",
     *              type="array",
     *              @OA\Items(
     *                 type="string",
     *                 example={"The gardener ID area field is required."},
     *              )
     *           ),
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
            'gardener'              => 'required'
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

        $getGardener = Gardeners::where('id', $request->gardener)->first();
        if (empty($getGardener)) {
            return response()->json([
                'success' => false,
                'error' => 'Invalid gardener ID. Please pick from the available gardener in the system'
            ], Response::HTTP_BAD_REQUEST);
        }

        if (!empty($getCountry) && !empty($getLocationArea)) {
            $request['location_area'] = $getLocationArea->id;
            $request['country_of_domicile'] = $getCountry->id;
            $request['gardener'] = $getGardener->id;

            $getCustomer = Customers::where('id', $id)->first();
            if (empty($getCustomer)) {
                return response()->json([
                    'success' => true,
                    'error' => 'Data not found.'
                ], Response::HTTP_NOT_FOUND);
            };

            try {
                $customer = Customers::where('id', $id)->update($request->all());
                return response()->json([
                    'success' => true,
                    'data' => Customers::where('id', $id)->first(),
                ], Response::HTTP_ACCEPTED);
            } catch (\Exception $e) {
                if ($e instanceof QueryException) {
                    return response()->json([
                        'success' => true,
                        'error' => 'Customer with ' . $request->email . ' email aleady exists.'
                    ], Response::HTTP_NOT_ACCEPTABLE);
                }
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/v1/customers/{id}",
     *      operationId="deleteCustomer",
     *      tags={"customers"},
     *      summary="Delete existing customer",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Customer id",
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
     *      @OA\Response(
     *          response=404,
     *          description="Customer with given ID not found",
     *     ),
     * ),
     * )
     */
    public function destroy($id)
    {
        $getCustomer = Customers::where('id', $id)->first();
        if (empty($getCustomer)) {
            return response()->json([
                'success' => true,
                'error' => 'Data not found.'
            ], Response::HTTP_NOT_FOUND);
        };
        try {
            $customer = Customers::destroy($id);
            return response()->json([
                'success' => true,
                'data' => $customer,
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
