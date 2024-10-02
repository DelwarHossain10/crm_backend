<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SalesOrderController extends Controller
{

    public function allSalesOrderPaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = SalesOrder::select('sale_orders.*',
            'quotations.quotation_number',
            'leads.lead_name',
        )
            ->leftJoin('quotations', 'quotations.id', '=', 'sale_orders.prospect_id')
        // ->leftJoin('prospects', 'prospects.id', '=', 'sale_orders.prospect_id')
            ->leftJoin('leads', 'leads.id', '=', 'sale_orders.lead_id')
            ->latest();

        if ($search) {
            $query->where('quotations.quotation_number', 'LIKE', '%' . $search . '%')
                ->where('leads.lead_name', 'LIKE', '%' . $search . '%');
        }

        $data = $query->paginate($perPage);

        return response()->json($data, 200);
    }

    public function index()
    {
        try {
            $saleOrders = SalesOrder::all();
            return response()->json($saleOrders);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve sale orders.'], 500);
        }
    }

    public function store(Request $request)
    {

        dd($request);

        // Begin the transaction
        DB::beginTransaction();

        try {
            // Handle file upload if exists
            $filePath = null;
            if ($request->hasFile('attachment')) {
                $filePath = $request->file('attachment')->store('attachments', 'public');
            }

            // Create the lead record
            $lead = Lead::create([
                'prospect_id' => $request->prospect_id,
                'lead_name' => $request->lead_name,
                'win_probability_id' => $request->win_probability_id,
                'estimated_closing_date' => $request->estimated_closing_date,
                'estimated_closing_amount' => $request->estimated_closing_amount,
                'attention_person' => $request->attention_person,
                'lead_stage' => $request->lead_stage,
                'stage_date' => $request->stage_date,
                'priority' => $request->priority,
                'comment' => $request->comment,
                'attachment' => $filePath,
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Store lead items if present
            if ($request->filled('items')) {
                $this->storeItems($request->items, $lead->id); // Fixed typo: $$lead->id to $lead->id
            }

            // Commit the transaction if all is successful
            DB::commit();

            // Return successful response
            return response()->json($lead, 201);

        } catch (ValidationException $e) {
            // Rollback the transaction on validation error
            DB::rollBack();
            return response()->json(['error' => 'Validation Error', 'messages' => $e->errors()], 422);

        } catch (Exception $e) {
            // Rollback the transaction on general error
            DB::rollBack();
            return response()->json(['error' => 'Failed to create lead', 'message' => $e->getMessage()], 500);
        }

        $validator = Validator::make($request->all(), [
            'sale_order_date' => 'required|date',
            'client_order_no' => 'required|string|max:191',
            'client_order_date' => 'required|date',
            'sale_order_subject' => 'required|string|max:191',
            'prospect_id' => 'nullable|integer',
            'lead_id' => 'nullable|integer',
            'quotation_id' => 'nullable|integer',
            'ordered_amount' => 'nullable|numeric',
            'key_account_person_id' => 'nullable|integer',
            'sale_order_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $data = $request->all();
            $data['sale_order_date'] = Carbon::parse($data['sale_order_date']);
            $data['client_order_date'] = Carbon::parse($data['client_order_date']);
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();

            if ($request->hasFile('attachment')) {
                $data['attachment'] = $request->file('attachment')->store('sales_order', 'public');
            }

            SalesOrder::create($data);

            return response()->json(['message' => 'Sale order created successfully.'], 201);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to create sale order.'], 500);
        }
    }

    public function show($id)
    {

        try {
            $saleOrder = SalesOrder::find($id);
            if (!$saleOrder) {
                return response()->json(['error' => 'Sale order not found.'], 404);
            }
            return response()->json($saleOrder);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve sale order.'], 500);
        }
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'sale_order_date' => 'required|date',
            'client_order_no' => 'required|string|max:191',
            'client_order_date' => 'required|date',
            'sale_order_subject' => 'required|string|max:191',
            'prospect_id' => 'nullable|integer',
            'lead_id' => 'nullable|integer',
            'quotation_id' => 'nullable|integer',
            'ordered_amount' => 'nullable|numeric',
            'key_account_person_id' => 'nullable|integer',
            'sale_order_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $saleOrder = SalesOrder::find($id);
            if (!$saleOrder) {
                return response()->json(['error' => 'Sale order not found.'], 404);
            }

            $data = $request->all();
            $data['sale_order_date'] = Carbon::parse($data['sale_order_date']);
            $data['client_order_date'] = Carbon::parse($data['client_order_date']);
            $data['updated_at'] = Carbon::now();

            if ($request->hasFile('attachment')) {

                if ($saleOrder->attachment) {
                    Storage::disk('public')->delete($saleOrder->attachment);
                }
                // Store new attachment
                $data['attachment'] = $request->file('attachment')->store('sales_order', 'public');
            }

            $saleOrder->update($data);

            return response()->json(['message' => 'Sale order updated successfully.']);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to update sale order.'], 500);
        }
    }

    // Delete Sale Order
    public function destroy($id)
    {
        try {
            $saleOrder = SalesOrder::find($id);
            if (!$saleOrder) {
                return response()->json(['error' => 'Sale order not found.'], 404);
            }

            $saleOrder->delete();

            return response()->json(['message' => 'Sale order deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete sale order.'], 500);
        }
    }

}
