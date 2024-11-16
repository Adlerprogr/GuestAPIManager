<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Http\Requests\GuestRequest;
use App\Http\Resources\GuestResource;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     title="Guest API Documentation",
 *     version="1.0.0",
 * )
 *
 * @OA\Tag(
 *     name="Guests",
 *     description="API endpoints for managing guests"
 * )
 */
class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $startTime = microtime(true);
            $startMemory = memory_get_usage();

            $response = $next($request);

            return $response->header('X-Debug-Time', round((microtime(true) - $startTime) * 1000, 2) . 'ms')
                ->header('X-Debug-Memory', round((memory_get_usage() - $startMemory) / 1024, 2) . 'KB');
        });
    }
    /**
     * @OA\Post(
     *     path="/api/guests",
     *     summary="Create a new guest",
     *     tags={"Guests"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="phone", type="string", example="+12345678901"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="country", type="string", example="USA"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Guest created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GuestResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(GuestRequest $request): JsonResponse
    {
        $guest = Guest::create($request->validated());
        return (new GuestResource($guest))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/guests/{id}",
     *     summary="Get a guest by ID",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Guest ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Guest retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GuestResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Guest not found"
     *     )
     * )
     */
    public function show(Guest $guest): GuestResource
    {
        return new GuestResource($guest);
    }

    /**
     * @OA\Put(
     *     path="/api/guests/{id}",
     *     summary="Update a guest by ID",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Guest ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="phone", type="string", example="+12345678901"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="country", type="string", example="USA"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Guest updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GuestResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Guest not found"
     *     )
     * )
     */
    public function update(GuestRequest $request, Guest $guest): GuestResource
    {
        $guest->update($request->validated());
        return new GuestResource($guest);
    }

    /**
     * @OA\Delete(
     *     path="/api/guests/{id}",
     *     summary="Delete a guest by ID",
     *     tags={"Guests"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Guest ID"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Guest deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Guest not found"
     *     )
     * )
     */
    public function destroy(Guest $guest): JsonResponse
    {
        $guest->delete();
        return response()->json(null, 204);
    }
}
