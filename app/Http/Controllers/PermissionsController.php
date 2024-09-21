<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use DB;
use Session;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Permission $permission, Request $request)
    {
        if ($request->ajax()) {
            $permissions = $permission->orderBy('id', 'desc')->get();
            $sl = 1;

            return $this->table($permissions)
                ->addColumn('sl', function ($row) use (&$sl) {
                    return $sl++;
                })
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => url('/permissions/'. $row->id .'/edit'),
                            'button_text' => 'Edit',
                            'is_modal' => false,
                        ],
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('auth.user.permissions.index');
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

        //
        DB::beginTransaction();
        try {
            $permission = new Permission();
            $permission->name = $request->name ?? null;
            $permission->guard_name = 'web';
            $permission->save();

            DB::commit();
            Session::flash('message', 'Permission created successfully!');
            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
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
    public function edit(Permission $permission)
    {
        //
        return view('auth.user.permissions.edit', compact('permission'));
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
