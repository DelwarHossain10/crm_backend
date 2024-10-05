<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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

        // Begin the transaction
        DB::beginTransaction();

        try {
            // Handle file upload if exists
            $filePath = null;
            if ($request->hasFile('attachment')) {
                $filePath = $request->file('attachment')->store('attachments', 'public');
            }

            // Create the lead record
            $salesOrder = SalesOrder::create([
                'sale_order_no' => $request->sale_order_no,
                'sale_order_date' => $request->sale_order_date,
                'client_order_no' => $request->client_order_no,
                'client_order_date' => $request->client_order_date,
                'sale_order_subject' => $request->sale_order_subject,
                'prospect_id' => $request->prospect_id,
                'lead_id' => $request->lead_id,
                'quotation_id' => $request->quotation_id,
                'company_attention_person' => $request->company_attention_person,
                'phone' => $request->phone,
                'email_address' => $request->email_address,
                'designation' => $request->designation,
                'ordered_amount' => $request->ordered_amount,
                'delivered_status' => $request->delivered_status,
                'sale_order_description' => $request->sale_order_description,
                'key_account_person' => $request->key_account_person,
                'department' => $request->department,
                'attachment' => $filePath,
                'created_by' => Auth::user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Store Sales Order items if present
            if ($request->filled('items')) {
                $this->storeItems($request->items, $salesOrder->id); // Fixed typo: $$salesOrder->id to $salesOrder->id
            }

            // Commit the transaction if all is successful
            DB::commit();

            // Return successful response
            return response()->json($salesOrder, 201);

        } catch (ValidationException $e) {
            // Rollback the transaction on validation error
            DB::rollBack();
            return response()->json(['error' => 'Validation Error', 'messages' => $e->errors()], 422);

        } catch (Exception $e) {
            // Rollback the transaction on general error
            DB::rollBack();
            return response()->json(['error' => 'Failed to create lead', 'message' => $e->getMessage()], 500);
        }

    }

    private function storeItems($items, $leadId)
    {
        foreach ($items as $item) {
            $itemJsonDecode = json_decode($item); // Decode the item JSON object

            DB::table('order_items')->insert([
                'order_id' => $leadId, // Use correct lead ID from parent lead creation
                'item_id' =>isset($itemJsonDecode->item_id) ? $itemJsonDecode->item_id:$itemJsonDecode->id, // Null if no item_id provided
                'model' => $itemJsonDecode->model,
                'qty' => $itemJsonDecode->qty,
                'unit_price' => $itemJsonDecode->unit_price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function show($id)
    {

        try {
            // Fetch the order details
            $order = DB::table('sale_orders')->where('id', $id)->first();

            if (!$order) {
                // Return a 404 response if the order is not found
                return response()->json(['error' => 'Order not found'], 404);
            }

            // Fetch the related items
            $items = DB::table('order_items')
                ->where('order_id', $id)
                ->get() // Retrieve the collection of items first
                ->map(function ($item) {
                    // Retrieve the item_name from the items table using item_id
                    $item->item_name = DB::table('items')
                        ->where('id', $item->item_id)
                        ->value('item_name'); // Fetch only the item_name column

                    return $item;
                });

            // Return the lead with its associated items
            return response()->json([
                'order' => $order,
                'items' => $items,
            ], 200);

        } catch (Exception $e) {
            // Handle any other errors
            return response()->json(['error' => 'Failed to fetch lead', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Retrieve the existing sales order record
            $salesOrder = SalesOrder::findOrFail($request->id);

            // Handle file upload if exists
            $filePath = $salesOrder->attachment; // Keep current attachment
            if ($request->hasFile('attachment')) {
                // Delete the old attachment if exists
                if ($salesOrder->attachment) {
                    Storage::disk('public')->delete($salesOrder->attachment);
                }
                // Store the new attachment
                $filePath = $request->file('attachment')->store('attachments', 'public');
            }

            // Update the sales order record
            $salesOrder->update([
                'sale_order_no' => $request->sale_order_no,
                'sale_order_date' => $request->sale_order_date,
                'client_order_no' => $request->client_order_no,
                'client_order_date' => $request->client_order_date,
                'sale_order_subject' => $request->sale_order_subject,
                'prospect_id' => $request->prospect_id,
                'lead_id' => $request->lead_id,
                'quotation_id' => $request->quotation_id,
                'company_attention_person' => $request->company_attention_person,
                'phone' => $request->phone,
                'email_address' => $request->email_address,
                'designation' => $request->designation,
                'ordered_amount' => $request->ordered_amount,
                'delivered_status' => $request->delivered_status,
                'sale_order_description' => $request->sale_order_description,
                'key_account_person' => $request->key_account_person,
                'department' => $request->department,
                'attachment' => $filePath,
                'updated_at' => now(),
            ]);

            // Update or store sales order items if present
            if ($request->filled('items')) {
                // Optionally, you can clear existing items and store new ones
                $this->updateItems($request->items, $salesOrder->id); // Implement `updateItems` to handle item updates
            }

            // Commit the transaction
            DB::commit();

            // Return successful response
            return response()->json($salesOrder, 200);

        } catch (ValidationException $e) {
            // Rollback the transaction on validation error
            DB::rollBack();
            return response()->json(['error' => 'Validation Error', 'messages' => $e->errors()], 422);

        } catch (Exception $e) {
            // Rollback the transaction on general error
            DB::rollBack();
            return response()->json(['error' => 'Failed to update sales order', 'message' => $e->getMessage()], 500);
        }
    }

    private function updateItems($items, $orderId)
{
    // Remove existing items for the given order ID
    DB::table('order_items')->where('order_id', $orderId)->delete();

    // Reinsert the updated items
    foreach ($items as $item) {
        $itemJsonDecode = json_decode($item); // Decode the item JSON object

        DB::table('order_items')->insert([
            'order_id' => $orderId, // Use correct order ID from parent order update
            'item_id' => isset($itemJsonDecode->item_id) ? $itemJsonDecode->item_id : $itemJsonDecode->id, // Null if no item_id provided
            'model' => $itemJsonDecode->model,
            'qty' => $itemJsonDecode->qty,
            'unit_price' => $itemJsonDecode->unit_price,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

    // Delete Sale Order
    public function destroy($id)
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Find the SalesOrder by ID
            $salesOrder = SalesOrder::findOrFail($id);

            // Delete related items from the order_items table
            DB::table('order_items')->where('order_id', $id)->delete();

            // Delete the SalesOrder itself
            $salesOrder->delete();

            // Commit the transaction
            DB::commit();

            // Return success response
            return response()->json(['message' => 'Sales order and its items deleted successfully'], 200);

        } catch (ValidationException $e) {
            // Rollback the transaction on not found error
            DB::rollBack();
            return response()->json(['error' => 'Sales order not found'], 404);

        } catch (Exception $e) {
            // Rollback the transaction on any other error
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete sales order', 'message' => $e->getMessage()], 500);
        }
    }


}
