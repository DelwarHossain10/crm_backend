<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use DB;
use Session;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Attendance $attendance, Request $request)
    {
        if ($request->ajax()) {
            $today = Carbon::today();

            $user = User::all();

            $attendance = collect($user)->map(function ($data) use ($today)  {

                $attendance = Attendance::where('user_id',$data->id)->whereDate('created_at', $today)->first();
                $data->check_in_latitude = $attendance->check_in_latitude??null;
                $data->check_in_longitude = $attendance->check_in_latitude??null;
                $data->check_in_location = $attendance->check_in_location??null;

                return $data;

            });


            $sl = 1;

            return $this->table($attendance)
                ->addColumn('sl', function ($row) use (&$sl) {

                    return $sl++;

                })
                ->addColumn('action', function ($row) {
                    return action_button([
                        'first_link' => [
                            'route' => url('/attendance/' . $row->id . '/edit'),
                            'button_text' => 'Edit',
                            'is_modal' => false,
                        ],
                        'last_link' => [
                            'route' => url('/attendance/' . $row->id),
                            'button_text' => 'Show',
                            'is_modal' => false,
                        ],
                    ]);
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        $users = User::all();
        return view('auth.user.attendance.index', compact('users'));
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

        DB::beginTransaction();
        try {
            Attendance::create([
                'check_in_latitude' => $request->check_in_latitude,
                'check_in_longitude' => $request->check_in_longitude,
                'check_in_location' => $request->check_in_location,
                'user_id' => $request->user_id,
            ]);
            DB::commit();
            Session::flash('message', 'Attendance created successfully.');
            return redirect()->route('attendance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {

        return view('auth.user.attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $today = Carbon::today();
        $users = User::all();
        $attendance = Attendance::where('user_id',$id)
        ->whereDate('created_at', $today)->first();
        return view('auth.user.attendance.edit', compact('attendance', 'users', 'id'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $today = Carbon::today();
            $attendance = Attendance::where('user_id',$id)
            ->whereDate('created_at', $today);

            $attendance->check_in_latitude = $request->input('check_in_latitude');
            $attendance->check_in_longitude = $request->input('check_in_longitude');
            $attendance->check_in_location = $request->input('check_in_location');
            $attendance->user_id = $id;
            $attendance->save();
            
            DB::commit();
            Session::flash('message', 'Attendance updated successfully.');
            return redirect()->route('attendance.index');
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
