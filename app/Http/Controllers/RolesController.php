<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Role $role, Request $request)
    {
        if ($request->ajax()) {
            $roles = $role->with('permissions')->orderBy('id', 'desc')->get();

            $sl = 1;

            return $this->table($roles)
                ->addColumn('sl', function ($row) use (&$sl) {
                    return $sl++;
                })
                ->addColumn('permissions', function ($row) {
                    return $row->permissions->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => url('/roles/' . $row->id . '/edit'),
                            'button_text' => 'Edit',
                            'is_modal' => false,
                        ],
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('auth.user.roles.index');
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
        return view('auth.user.services.edit', compact('service'));
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
