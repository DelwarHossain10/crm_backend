<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
            'attachments' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048', // Single attachment validation
        ]);

        try {
            DB::beginTransaction();

            // Insert supplier data
            $supplierId = DB::table('suppliers')->insertGetId([
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
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Handle attachments if any
            if ($request->hasFile('attachments')) {
                $attachment = $request->file('attachments'); // Access the single file
                $fileName = $attachment->getClientOriginalName();
                $filePath = $attachment->store('supplier_attachments', 'public');

                DB::table('supplier_attachments')->insert([
                    'supplier_id' => $supplierId,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();

            // Prepare the response with supplier data and attachments
            $supplier = DB::table('suppliers')->where('id', $supplierId)->first();
            $supplier->attachments = DB::table('supplier_attachments')->where('supplier_id', $supplierId)->get();

            return response()->json($supplier, 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Failed to create supplier', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {

            $supplier = DB::table('suppliers')->where('id', $id)->first();
            if (!$supplier) {
                return response()->json(['message' => 'Supplier not found'], 404);
            }
            $attachments = DB::table('supplier_attachments')->where('supplier_id', $id)->get();
            $supplier->attachments = $attachments;
            return response()->json($supplier, 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve supplier', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
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
