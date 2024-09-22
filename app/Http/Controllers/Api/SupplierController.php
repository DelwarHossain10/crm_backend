<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    public function allSupplierPaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = DB::table('suppliers')
            ->leftJoin('supplier_attachments', 'suppliers.id', '=', 'supplier_attachments.supplier_id')
            ->select('suppliers.*', 'supplier_attachments.file_name', 'supplier_attachments.file_path')
            ->latest();

        if ($search) {
            // Add search conditions if needed
        }

        $data = $query->paginate($perPage);

        // Process each supplier record
        $data->getCollection()->transform(function ($item) {
            if (isset($item->concern_person_info)) {
                $item->concern_person_info = json_decode($item->concern_person_info, true);
            }
            if (isset($item->supplier_item)) {
                $item->supplier_item = unserialize($item->supplier_item);
            }
            return $item;
        });

        return response()->json($data, 200);
    }

    public function index()
    {
        try {
            $suppliers = DB::table('suppliers')
                ->leftJoin('supplier_attachments', 'suppliers.id', '=', 'supplier_attachments.supplier_id')
                ->select('suppliers.*', 'supplier_attachments.file_name', 'supplier_attachments.file_path')
                ->get();
            return response()->json($suppliers, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve suppliers', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Handle file upload if exists
            $filePath = null;
            if ($request->hasFile('attachment')) {
                // Use try-catch for file upload as well
                try {
                    $filePath = $request->file('attachment')->store('attachments', 'public');
                } catch (\Exception $e) {
                    return response()->json(['message' => 'File upload failed', 'error' => $e->getMessage()], 500);
                }
            }

            // Insert supplier data
            $supplierId = DB::table('suppliers')->insertGetId([
                'supplier_name' => $request->input('supplier_name'),
                'supplier_category' => $request->input('supplier_category'),
                'supplier_reputation_brand' => $request->input('supplier_reputation_brand'),
                'important_note' => $request->input('important_note'),
                'concern_person_info' => $request->input('concern_person_info'),
                'country' => $request->input('country'),
                'zone' => $request->input('zone'),
                'zip_po' => $request->input('zip_po'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'fax' => $request->input('fax'),
                'website' => $request->input('website'),
                'social_network' => $request->input('social_network'),
                'attachment' => $filePath,
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Store items if available
            if ($request->filled('items')) {
                $this->storeItems($request->items, $supplierId);
            }

            DB::commit();

            return response()->json('Supplier Created Successfully', 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Failed to create supplier', 'error' => $e->getMessage()], 500);
        }
    }

    private function storeItems($items, $supplierId)
    {
        foreach ($items as $item) {
            // Decode the item JSON object
            $itemJsonDecode = json_decode($item);

            // Ensure item was properly decoded
            if (json_last_error() === JSON_ERROR_NONE && isset($itemJsonDecode->model, $itemJsonDecode->qty, $itemJsonDecode->unit_price)) {
                DB::table('supplier_items')->insert([
                    'supplier_id' => $supplierId, // Use correct supplier ID from parent supplier creation
                    'item_id' => $itemJsonDecode->id ?? null, // Null if no item_id provided
                    'model' => $itemJsonDecode->model,
                    'qty' => $itemJsonDecode->qty,
                    'unit_price' => $itemJsonDecode->unit_price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Handle invalid or incomplete item data
                throw new \Exception("Invalid item data for supplier ID: $supplierId");
            }
        }
    }

    public function show($id)
    {
        try {
            // Fetch the supplier details
            $supplier = DB::table('suppliers')->where('id', $id)->first();

            if (!$supplier) {
                // Return a 404 response if the supplier is not found
                return response()->json(['error' => 'supplier not found'], 404);
            }

            // Fetch the related items
            $items = DB::table('supplier_items')
                ->where('supplier_id', $id)
                ->get() // Retrieve the collection of items first
                ->map(function ($item) {
                    // Retrieve the item_name from the items table using item_id
                    $item->item_name = DB::table('items')
                        ->where('id', $item->item_id)
                        ->value('item_name'); // Fetch only the item_name column

                    return $item;
                });

            // Return the supplier with its associated items
            return response()->json([
                'supplier' => $supplier,
                'items' => $items,
            ], 200);

        } catch (Exception $e) {
            // Handle any other errors
            return response()->json(['error' => 'Failed to fetch supplier', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        dd($request->all(), $request, $id);

        // Validate incoming data
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_item' => 'required|array',
            'supplier_category' => 'required|string|max:255',
            'supplier_reputation_brand' => 'nullable|string|max:255',
            'important_note' => 'nullable|string',
            'concern_person_info' => 'nullable|string',
            'country' => 'required|string|max:255',
            'zone' => 'required|string|max:255',
            'zip_po' => 'nullable|string|max:20',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
            'social_network' => 'nullable|string|max:255',
            'attachments.*' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // Update supplier data
            DB::table('suppliers')->where('id', $id)->update([
                'supplier_name' => $request->input('supplier_name'),
                'supplier_item' => serialize($request->input('supplier_item')),
                'supplier_category' => $request->input('supplier_category'),
                'supplier_reputation_brand' => $request->input('supplier_reputation_brand'),
                'important_note' => $request->input('important_note'),
                'concern_person_info' => $request->input('concern_person_info'),
                'country' => $request->input('country'),
                'zone' => $request->input('zone'),
                'zip_po' => $request->input('zip_po'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'fax' => $request->input('fax'),
                'website' => $request->input('website'),
                'social_network' => $request->input('social_network'),
                'updated_at' => now(),
            ]);

            // Handle attachments if any
            if ($request->hasFile('attachments')) {

                // Delete existing attachments
                $existingAttachments = DB::table('supplier_attachments')
                    ->where('supplier_id', $id)
                    ->get();

                foreach ($existingAttachments as $attachment) {
                    Storage::disk('public')->delete($attachment->file_path);
                }

                DB::table('supplier_attachments')->where('supplier_id', $id)->delete();

                // Add new attachments
                foreach ($request->file('attachments') as $attachment) {
                    $fileName = $attachment->getClientOriginalName();
                    $filePath = $attachment->store('supplier_attachments', 'public');

                    DB::table('supplier_attachments')->insert([
                        'supplier_id' => $id,
                        'file_name' => $fileName,
                        'file_path' => $filePath,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            // Retrieve the updated supplier data and its attachments
            $supplier = DB::table('suppliers')->where('id', $id)->first();
            $supplier->attachments = DB::table('supplier_attachments')->where('supplier_id', $id)->get();

            return response()->json($supplier, 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update supplier', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $attachments = DB::table('supplier_attachments')->where('supplier_id', $id)->get();
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            DB::table('supplier_attachments')->where('supplier_id', $id)->delete();
            DB::table('suppliers')->where('id', $id)->delete();
            DB::commit();
            return response()->json(['message' => 'Supplier and its attachments deleted successfully.'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to delete supplier', 'error' => $e->getMessage()], 500);
        }
    }
}
