<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


class TestController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tests",
     *     tags={"Tests"},
     *     summary="Get all tests",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of tests",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="List of tests retrieved successfully."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Test")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json([
            'message' => 'List of tests retrieved successfully.',
            'data' => Test::all(),
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/tests/{id}",
     *     tags={"Tests"},
     *     summary="Get a specific test",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Test retrieved",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Test retrieved successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Test")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Test not found")
     * )
     */
    public function show($id)
    {
        $test = Test::find($id);

        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }

        return response()->json([
            'message' => 'Test retrieved successfully.',
            'data' => $test,
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/tests",
     *     tags={"Tests"},
     *     summary="Create a new test",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Test Name"),
     *             @OA\Property(property="description", type="string", example="Test description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Test created",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Test created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Test")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test = Test::create($validated);

        return response()->json([
            'message' => 'Test created successfully.',
            'data' => $test,
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/tests/{id}",
     *     tags={"Tests"},
     *     summary="Update a specific test",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Updated Test Name"),
     *             @OA\Property(property="description", type="string", example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Test updated",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Test updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Test")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Test not found")
     * )
     */
    public function update(Request $request, $id)
    {
        $test = Test::find($id);

        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $test->update($validated);

        return response()->json([
            'message' => 'Test updated successfully.',
            'data' => $test,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/tests/{id}",
     *     tags={"Tests"},
     *     summary="Delete a specific test",
     *     security={{"ApiKeyAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the test",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Test deleted successfully.",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Test deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(response=404, description="Test not found")
     * )
     */
    public function destroy($id)
    {
        $test = Test::find($id);

        if (!$test) {
            return response()->json(['message' => 'Test not found.'], 404);
        }

        $test->delete();

        return response()->json(['message' => 'Test deleted successfully.']);
    }
}
