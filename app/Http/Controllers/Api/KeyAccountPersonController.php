<?php

namespace App\Http\Controllers\Api;

use App\Models\KeyAccountPerson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KeyAccountPersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allKeyAccountPersonPaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = KeyAccountPerson::latest();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $items = $query->paginate($perPage);

        return $items;
    }

    public function index()
    {
        try {
            $data = KeyAccountPerson::all();
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
            KeyAccountPerson::create($request->all());
            return response()->json('Successfully created', 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KeyAccountPerson  $keyAccountPerson
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, KeyAccountPerson $keyAccountPerson)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $keyAccountPerson->update($request->all());
            return response()->json('Successfully updated', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KeyAccountPerson  $keyAccountPerson
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(KeyAccountPerson $keyAccountPerson)
    {
        try {
            $keyAccountPerson->delete();
            return response()->json('Successfully deleted', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete'], 500);
        }
    }

    public function show($id)
    {
        try {
            $keyAccountPerson = KeyAccountPerson::findOrFail($id);
            return response()->json($keyAccountPerson, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
    }
}
