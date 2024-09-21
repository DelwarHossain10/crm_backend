<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\DataTables\UsersDataTable;
use DataTables;
use Session;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(User $user_manager, Request $request)
    {
        if ($request->ajax()) {
            $users = $user_manager->list($request);

            return $this->table($users)

                ->addColumn('roles', function ($row) {
                    return $row->roles->map(function ($role) {
                        return '<button type="button" class="btn btn-sm btn-primary">' . $role->name . '</button>';
                    })->implode(' ');
                })
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => url('/users/'.$row->id.'/edit'),
                            'button_text' => 'Edit',
                            'is_modal' => false,
                        ],
                    ]);
                })
                ->editColumn('active', function ($row) {
                    if ($row->active === 'Y') {
                        return '<button type="button" class="btn btn-sm btn-success">Active</button>';
                    } else {
                        return '<button type="button" class="btn btn-sm btn-danger">Inactive</button>';
                    }
                })
                ->escapeColumns(['roles'])
                ->rawColumns(['roles', 'action', 'active'])
                ->make(true);
        }

        $roles = Role::all();

        return view('auth.user.user_manager.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
              // Validate the request data
        // $request->validate([
        //     'full_name' => 'required|string|max:255',
        //     'phone_number' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email|max:255',
        //     'state_name' => 'nullable|string|max:255',
        //     'address' => 'nullable|string',
        //     'password' => 'required|string|min:8|confirmed',
        //     'roles' => 'required|array',
        //     'roles.*' => 'exists:roles,id',
        //     'status' => 'required|boolean',
        // ]);

        // Create the user
        $user = new User();
        $user->full_name = $request->input('full_name');
        $user->phone_number = $request->input('phone_number');
        $user->email = $request->input('email');
        $user->state_name = $request->input('state_name');
        $user->address = $request->input('address');
        $user->password = bcrypt($request->input('password'));
        $user->status = $request->input('status');
        $user->save();

       

        // Assign roles to the user
        $user->assignRole($request->input('roles'));

        // Redirect back with success message
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('auth.user.user_manager.edit', compact('user', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'state_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Update user details
            $user->full_name = $request->input('full_name');
            $user->phone_number = $request->input('phone_number');
            $user->email = $request->input('email');
            $user->state_name = $request->input('state_name');
            $user->address = $request->input('address');
            $user->status = $request->input('status');
            $user->save();

            // Sync user roles
            $user->roles()->sync($request->input('roles'));

            DB::commit();
            Session::flash('message', 'Successfully User Update!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
