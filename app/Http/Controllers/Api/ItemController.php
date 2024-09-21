<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    public function allItemPaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = Item::latest();

        if ($search) {
            $query->where('item_name', 'LIKE', '%' . $search . '%')
                ->orWhere('model', 'LIKE', '%' . $search . '%')
                ->orWhere('unit_price', 'LIKE', '%' . $search . '%')
                ->orWhere('qty', 'LIKE', '%' . $search . '%');
        }

        $items = $query->paginate($perPage);

        return $items;
    }
    public function index()
    {
        try {
            $items = Item::select('id', 'item_name', 'model', 'qty', 'unit_price')->get();
            return response()->json($items);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve branches', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:191',
            'model' => 'nullable|string|max:191',
            'qty' => 'nullable|numeric',
            'unit_price' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $item = Item::create($request->all());

            DB::commit();
            return response()->json(['message' => 'Item created successfully', 'item' => $item], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create item', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $item = Item::find($id);

            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve item', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|string|max:191',
            'model' => 'nullable|string|max:191',
            'qty' => 'nullable|numeric',
            'unit_price' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $item = Item::find($id);

            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            $item->update($request->all());

            DB::commit();
            return response()->json(['message' => 'Item updated successfully', 'item' => $item], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update item', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $item = Item::find($id);

            if (!$item) {
                return response()->json(['error' => 'Item not found'], 404);
            }

            $item->delete();

            DB::commit();
            return response()->json(['message' => 'Item deleted successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete item', 'message' => $e->getMessage()], 500);
        }
    }
}
