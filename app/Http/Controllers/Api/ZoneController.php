<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */

     public function allZonePaginated(Request $request)
     {
         $search = $request->input('search', '');
         $perPage = $request->input('paginate', 10);
 
         $query = Zone::latest();
 
         if ($search) {
             $query->where('name', 'LIKE', '%' . $search . '%');
         }
 
         $items = $query->paginate($perPage);
 
         return $items;
     }

    public function index()
    {
        try {
            $zones = Zone::all();
            return response()->json($zones, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve zones'], 500);
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
            Zone::create($request->all());
            return response()->json('Zone created successfully', 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create zone'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Zone $zone)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $zone->update($request->all());
            return response()->json('Zone updated successfully', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update zone'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Zone $zone)
    {
        try {
            $zone->delete();
            return response()->json('Zone deleted successfully', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete zone'], 500);
        }
    }

    public function show($id)
    {
        try {
            $zone = Zone::findOrFail($id);
            return response()->json($zone, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
    }


}
