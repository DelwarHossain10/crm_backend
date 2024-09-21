<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Order $order, Request $request)
    {
        //
        if ($request->ajax()) {
            $order = Order::get();

            $sl = 1;

            return $this->table($order)
                ->addColumn('sl', function ($row) use (&$sl) {

                    return $sl++;

                })
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => url('/order/' . $row->id . '/edit'),
                            'button_text' => 'Edit',
                            'is_modal' => false,
                        ],
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('auth.user.order.index');
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
        

        $orderData = $request->only([
            'client_order_id',
            'sale_order_subject',
            'prospect_id',
            'company_attention_person',
            'phone',
            'designation',
            'order_item',
            'key_account_person_id',
            'sale_order_description',
            'lead_name',
            'sale_order_date',
            'client_order_date',
            'email_address',
            'Department',
            'quotation_id',
            'ordered_amount',
            'delivered'
        ]);

        if ($request->hasFile('attachment')) {
            $orderData['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        Order::create($orderData);

        return redirect()->route('order.index')->with('success', 'Order created successfully.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
