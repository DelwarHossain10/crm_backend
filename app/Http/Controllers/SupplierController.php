<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\SupplierConcern;
use App\Models\User;
use DB;
use Session;

class SupplierController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Supplier $supplier, Request $request)
    {
        if ($request->ajax()) {
            $supplier = Supplier::get();

            $sl = 1;

            return $this->table($supplier)
                ->addColumn('sl', function ($row) use (&$sl) {

                    return $sl++;

                })
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => url('/supplier/' . $row->id . '/edit'),
                            'button_text' => 'Edit',
                            'is_modal' => false,
                        ],
                    ]);
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        $users = User::all();
        return view('auth.user.supplier.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_item' => 'nullable|string',
            'important_note' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'zone' => 'nullable|string|max:100',
            'fax' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'zip_po' => 'nullable|string|max:20',
            'concern_person.*' => 'nullable|string|max:255',
            'mobile.*' => 'nullable|string|max:20',
            'designation.*' => 'nullable|string|max:255',
            'email_address.*' => 'nullable|email|max:255'
        ]);

        $supplierData = $request->only([
            'supplier_name',
            'supplier_item',
            'category_name',
            'reputation_name',
            'important_note',
            'address',
            'phone',
            'zone',
            'fax',
            'website',
            'zip_po'
        ]);

        if ($request->hasFile('attachment')) {
            $supplierData['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        $supplier = Supplier::create($supplierData);

        if ($request->has('concern_person')) {
            foreach ($request->concern_person as $index => $concernPerson) {
                SupplierConcern::create([
                    'supplier_id' => $supplier->id,
                    'concern_person' => $concernPerson,
                    'mobile' => $request->mobile[$index] ?? null,
                    'designation' => $request->designation[$index] ?? null,
                    'email_address' => $request->email_address[$index] ?? null
                ]);
            }
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $supplier = Supplier::with('concerns')->findOrFail($id);


        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        // Validate input
        $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_category_id' => 'nullable|exists:supplier_categories,id',
            'supplier_reputation_id' => 'nullable|exists:supplier_reputations,id',
            'important_note' => 'nullable|string',
            'attachment' => 'nullable|file',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'zone' => 'nullable|string',
            'fax' => 'nullable|string',
            'website' => 'nullable|string',
            'zip_po' => 'nullable|string',
            'concern_person.*' => 'required|string|max:255',
            'mobile.*' => 'required|string|max:255',
            'designation.*' => 'nullable|string|max:255',
            'email_address.*' => 'nullable|string|email|max:255',
        ]);

        // Update supplier
        $supplier->update($request->only([
            'supplier_name', 'supplier_item', 'supplier_category_id', 'supplier_reputation_id',
            'important_note', 'attachment', 'address', 'phone', 'zone', 'fax', 'website', 'zip_po'
        ]));

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments');
            $supplier->attachment = $filePath;
            $supplier->save();
        }

        // Update supplier concerns
        $supplier->concerns()->delete(); // Delete existing concerns
        foreach ($request->concern_person as $key => $concernPerson) {
            SupplierConcern::create([
                'supplier_id' => $supplier->id,
                'concern_person' => $concernPerson,
                'mobile' => $request->mobile[$key],
                'designation' => $request->designation[$key],
                'email_address' => $request->email_address[$key],
            ]);
        }

        return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
