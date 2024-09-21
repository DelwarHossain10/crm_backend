<?php

namespace App\Http\Controllers\Api;

use App\Models\IndustryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class IndustryTypeController extends Controller
{
    public function allIndustryTypePaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = IndustryType::latest();

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $items = $query->paginate($perPage);

        return $items;
    }
    public function index()
    {
        try {
            $data = IndustryType::all();
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            IndustryType::create($request->all());
            return response()->json('Successfully created', 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create'], 500);
        }
    }

    public function show($id)
    {
        try {
            $industryType = IndustryType::findOrFail($id);
            return response()->json($industryType, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $industryType = IndustryType::findOrFail($id);
            $industryType->update($request->all());
            return response()->json('Successfully updated', 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $industryType = IndustryType::findOrFail($id);
            $industryType->delete();
            return response()->json('Successfully deleted', 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete'], 500);
        }
    }
}
