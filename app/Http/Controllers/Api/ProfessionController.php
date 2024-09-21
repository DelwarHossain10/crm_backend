<?php

namespace App\Http\Controllers\Api;

use App\Models\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function allProfessionPaginated(Request $request)
     {
         $search = $request->input('search', '');
         $perPage = $request->input('paginate', 10);
 
         $query = Profession::latest();
 
         if ($search) {
             $query->where('name', 'LIKE', '%' . $search . '%');
         }
 
         $items = $query->paginate($perPage);
 
         return $items;
     }

    public function index()
    {
        try {
            $data = Profession::all();
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            Profession::create($request->all());
            return response()->json('Successfully created', 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Profession $profession)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $profession->update($request->all());
            return response()->json('Successfully updated', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profession  $profession
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Profession $profession)
    {
        try {
            $profession->delete();
            return response()->json('Successfully deleted', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete'], 500);
        }
    }

    public function show($id)
    {
        try {
            $profession = Profession::findOrFail($id);
            return response()->json($profession, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
    }
}
