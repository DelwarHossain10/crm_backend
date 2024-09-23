<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class LeadController extends Controller
{
    // Display a listing of the resource.

    public function allLeadPaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = Lead::select('leads.*',
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
    public function index()
    {
        try {
            $leads = Lead::all();
            return response()->json($leads);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve leads', 'message' => $e->getMessage()], 500);
        }
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        // dd($request->all());
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
    }

    private function storeItems($items, $leadId)
    {
        foreach ($items as $item) {
            $itemJsonDecode = json_decode($item); // Decode the item JSON object

            DB::table('lead_items')->insert([
                'lead_id' => $leadId, // Use correct lead ID from parent lead creation
                'item_id' =>isset($itemJsonDecode->item_id) ? $itemJsonDecode->item_id:$itemJsonDecode->id, // Null if no item_id provided
                'model' => $itemJsonDecode->model,
                'qty' => $itemJsonDecode->qty,
                'unit_price' => $itemJsonDecode->unit_price,
                'line_total' => $itemJsonDecode->unit_price * $itemJsonDecode->qty, // Calculate total
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // Display the specified resource.
    public function show($id)
    {
        try {
            // Fetch the lead details
            $lead = DB::table('leads')->where('id', $id)->first();

            if (!$lead) {
                // Return a 404 response if the lead is not found
                return response()->json(['error' => 'Lead not found'], 404);
            }

            // Fetch the related items
            $items = DB::table('lead_items')
                ->where('lead_id', $id)
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
                'lead' => $lead,
                'items' => $items,
            ], 200);

        } catch (Exception $e) {
            // Handle any other errors
            return response()->json(['error' => 'Failed to fetch lead', 'message' => $e->getMessage()], 500);
        }
    }

    // Update the specified resource in storage.
    public function leadUpdate(Request $request, $id)
    {

        // Begin the transaction
        DB::beginTransaction();

        try {
            // Find the lead using Query Builder
            $lead = DB::table('leads')->where('id', $id)->first();

            if (!$lead) {
                return response()->json(['error' => 'Lead not found'], 404);
            }

            // Handle file upload if exists
            $filePath = $lead->attachment; // Keep the old file if not updating
            if ($request->hasFile('attachment')) {
                // Delete old file if necessary (optional)
                if ($lead->attachment && Storage::disk('public')->exists($lead->attachment)) {
                    Storage::disk('public')->delete($lead->attachment);
                }

                // Store the new file
                $filePath = $request->file('attachment')->store('attachments', 'public');
            }

            // Update lead using Query Builder
            DB::table('leads')
                ->where('id', $id)
                ->update([
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
                    'updated_by' => Auth::user()->id,
                    'updated_at' => now(),
                ]);

            // Update lead items if present
            if ($request->filled('items')) {
                // Clear existing items using Query Builder
                DB::table('lead_items')->where('lead_id', $id)->delete();

                // Store updated items
                $this->storeItems($request->items, $id);
            }

            // Commit the transaction if all is successful
            DB::commit();

            // Return successful response
            return response()->json(['message' => 'Lead updated successfully'], 200);

        } catch (ValidationException $e) {
            // Rollback the transaction on validation error
            DB::rollBack();
            return response()->json(['error' => 'Validation Error', 'messages' => $e->errors()], 422);

        } catch (Exception $e) {
            // Rollback the transaction on general error
            DB::rollBack();
            return response()->json(['error' => 'Failed to update lead', 'message' => $e->getMessage()], 500);
        }
    }

    // Remove the specified resource from storage.
    public function destroy($id)
    {
        // Begin the transaction
        DB::beginTransaction();

        try {
            // Find the lead
            $lead = Lead::findOrFail($id);

            // Delete associated lead items
            DB::table('lead_items')->where('lead_id', $lead->id)->delete();

            // Delete the lead
            $lead->delete();

            // Commit the transaction if all is successful
            DB::commit();

            // Return successful response
            return response()->json(['message' => 'Lead deleted successfully'], 200);

        } catch (Exception $e) {
            // Rollback the transaction on error
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete lead', 'message' => $e->getMessage()], 500);
        }
    }
}
