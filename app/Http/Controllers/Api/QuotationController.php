<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuotationController extends Controller
{
    public function allQuotationPaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = Quotation::select('quotations.*',
            // 'quotations.quotation_number',
            // 'leads.lead_name',
        )
        // ->leftJoin('quotations', 'quotations.id', '=', 'sale_orders.prospect_id')
        // // ->leftJoin('prospects', 'prospects.id', '=', 'sale_orders.prospect_id')
        // ->leftJoin('leads', 'leads.id', '=', 'sale_orders.lead_id')
            ->latest();

        if ($search) {
            // $query->where('quotations.quotation_number', 'LIKE', '%' . $search . '%')
            // ->where('leads.lead_name', 'LIKE', '%' . $search . '%');
        }

        $data = $query->paginate($perPage);

        return response()->json($data, 200);
    }
    // Retrieve all quotations
    public function index()
    {
        try {
            $quotations = Quotation::all();

            $quotations->transform(function ($quotation) {
                $quotation->attachments = DB::table('quotation_attachments')
                    ->where('quotation_id', $quotation->id)
                    ->get();

                $quotation->quotation_items = DB::table('quotation_details')
                    ->where('quotation_id', $quotation->id)
                    ->get();

                return $quotation;
            });
            return response()->json($quotations);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    // Retrieve a specific quotation by ID
    public function show($id)
    {
        try {
            $quotation = Quotation::findOrFail($id);

            if (!$quotation) {
                return response()->json(['error' => 'Quotation not found'], 404);
            }

            // Fetch related attachments
            $attachments = DB::table('quotation_attachments')
                ->where('quotation_id', $id)
                ->get();

            // Fetch related quotation items
            $quotationItems = DB::table('quotation_details')
                ->where('quotation_id', $id)
                ->get();

            // Combine all the data
            $quotation->attachments = $attachments;
            $quotation->quotation_items = $quotationItems;

            return response()->json($quotation);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Quotation not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    // Delete a specific quotation by ID
    public function destroy($id)
    {
        try {
            $quotation = Quotation::findOrFail($id);

            // Delete the file if exists
            if ($quotation->attachments && Storage::exists('public/' . $quotation->attachments)) {
                Storage::delete('public/' . $quotation->attachments);
            }

            $quotation->delete();

            return response()->json(['message' => 'Quotation deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Quotation not found'], 404);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Database error: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'quotation_number' => 'required',
            'quotation_date' => 'required|date',
            'quotation_subject' => 'required|string',
            'prospect_id' => 'required|integer',
            'lead_id' => 'required|integer',
            'quoted_amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $quotationId = DB::table('quotations')->insertGetId([
                'quotation_number' => $request->quotation_number ?? null,
                'quotation_date' => $request->quotation_date ?? null,
                'quotation_subject' => $request->quotation_subject ?? null,
                'prospect_id' => $request->prospect_id ?? null,
                'lead_id' => $request->lead_id ?? null,
                'quoted_amount' => $request->quoted_amount ?? null,
                'sub_total' => $request->sub_total ?? null,
                'discount' => $request->discount ?? null,
                'amount_after_discount' => $request->amount_after_discount ?? null,
                'vat' => $request->vat ?? null,
                'alt' => $request->alt ?? null,
                'grand_total' => $request->grand_total ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($request->has('attachments')) {
                $this->storeAttachments($request->file('attachments'), $quotationId);
            }

            if ($request->filled('quotation_items')) {
                $this->storeQuotationItems($request->quotation_items, $quotationId);
            }

            DB::commit();

            return response()->json(['message' => 'Quotation created successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create quotation', 'message' => $e->getMessage()], 500);
        }
    }

    public function itemWiseQuotation(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'quotation_number' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $quotationId = DB::table('quotations')->insertGetId([
                'quotation_date' => now(),
                'quotation_number' => $request->quotation_number ?? null,
                'quotation_subject' => $request->quotation_subject ?? null,
                'lead_id' => $request->lead_id ?? null,
                'attention_person' => $request->attention_person ?? null,
                'email' => $request->email ?? null,
                'designation' => $request->designation ?? null,
                'sub_total' => $request->subTotal ?? null,
                'discount' => $request->discount ?? null,
                'quoted_amount' => $request->grand_total ?? null,
                'amount_after_discount' => $request->amountAfterDiscount ?? null,
                'vat' => $request->vat ?? null,
                'alt' => $request->alt ?? null,
                'grand_total' => $request->grandTotal ?? null,
                'created_at' => now(),
            ]);


            if ($request->filled('quotation_items')) {
                $this->storeQuotationItems($request->quotation_items, $quotationId);
            }

            DB::commit();

            return response()->json(['message' => 'Quotation created successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create quotation', 'message' => $e->getMessage()], 500);
        }
    }

    private function storeAttachments($attachments, $quotationId)
    {
        foreach ($attachments as $attachment) {
            $filePath = $attachment->store('quotation_attachments');

            DB::table('quotation_attachments')->insert([
                'quotation_id' => $quotationId,
                'file_path' => $filePath,
                'file_name' => $attachment->getClientOriginalName(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function storeQuotationItems($quotation_items, $quotationId)
    {

        foreach ($quotation_items as $item) {

            $itemJsonDecode = json_decode($item);

            DB::table('quotation_details')->insert([
                'quotation_id' => $quotationId,
                'item_id' => $itemJsonDecode->id ?? null,
                'description' => $itemJsonDecode->description ?? null,
                'model' => $itemJsonDecode->model,
                'qty' => $itemJsonDecode->qty,
                'unit_price' => $itemJsonDecode->unit_price,
                'created_at' => now(),
            ]);
        }
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'quotation_number' => 'required',
            'quotation_date' => 'required|date',
            'quotation_subject' => 'required|string',
            'prospect_id' => 'required|integer',
            'lead_id' => 'required|integer',
            'quoted_amount' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            DB::beginTransaction();

            $quotation = DB::table('quotations')->where('id', $id)->first();

            if (!$quotation) {
                return response()->json(['error' => 'Quotation not found'], 404);
            }

            DB::table('quotations')->where('id', $id)->update([
                'quotation_number' => $request->quotation_number,
                'quotation_date' => $request->quotation_date,
                'quotation_subject' => $request->quotation_subject,
                'prospect_id' => $request->prospect_id,
                'lead_id' => $request->lead_id,
                'quoted_amount' => $request->quoted_amount,
                'sub_total' => $request->sub_total,
                'discount' => $request->discount,
                'amount_after_discount' => $request->amount_after_discount,
                'vat' => $request->vat,
                'alt' => $request->alt,
                'grand_total' => $request->grand_total,
                'updated_at' => now(),
            ]);

            if ($request->has('attachments')) {
                $this->updateAttachments($request->file('attachments'), $id);
            }

            if ($request->filled('quotation_items')) {
                $this->updateQuotationItems(json_decode($request->quotation_items), $id);
            }

            DB::commit();

            return response()->json(['message' => 'Quotation updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update quotation', 'message' => $e->getMessage()], 500);
        }
    }

    private function updateAttachments($attachments, $quotationId)
    {
        if (!empty($attachments)) {
            DB::table('quotation_attachments')->where('quotation_id', $quotationId)->delete();

            foreach ($attachments as $attachment) {
                $filePath = $attachment->store('quotation_attachments');

                DB::table('quotation_attachments')->insert([
                    'quotation_id' => $quotationId,
                    'file_path' => $filePath,
                    'file_name' => $attachment->getClientOriginalName(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function updateQuotationItems($items, $quotationId)
    {

        DB::table('quotation_details')->where('quotation_id', $quotationId)->delete();

        foreach ($items as $item) {
            DB::table('quotation_details')->insert([
                'quotation_id' => $quotationId,
                'item_id' => $item->item_id,
                'description' => $item->description,
                'model' => $item->model,
                'qty' => $item->qty,
                'unit_price' => $item->unit_price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

}
