<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function allAttendancePaginated(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = $request->input('paginate', 10);

        $query = Attendance::select('attendances.*', 'employees.name', 'employees.branch', 'employees.designation')->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')->latest();

        if ($search) {
            $query->where('employees.name', 'LIKE', '%' . $search . '%')
            ->where('employees.branch', 'LIKE', '%' . $search . '%')
            ->where('employees.designation', 'LIKE', '%' . $search . '%');
        }

        $data = $query->paginate($perPage);

        return response()->json($data, 200);
    }
    public function index()
    {
        //
        try {
            $data = Attendance::select('attendances.*', 'employees.name', 'employees.branch', 'employees.designation')
            ->leftJoin('employees', 'employees.id', '=', 'attendances.employee_id')->get();
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
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
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'check_in_latitude' => 'required',
            'check_in_longitude' => 'required',
            'employee_id' => 'required',
            'location' => 'required',
            'check_in_time' => 'required',
            'check_out_time' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $existingAttendance = DB::table('attendances')
                ->where('date', $request->date)
                ->where('employee_id', $request->employee_id)
                ->first();

            if ($existingAttendance) {
                return response()->json(['error' => 'Attendance record already exists for this date and employee'], 409);
            }

            $checkInTime = Carbon::parse($request->check_in_time);
            $checkOutTime = $request->check_out_time ? Carbon::parse($request->check_out_time) : null;
            $standardStartTime = Carbon::createFromTime(9, 0, 0);
            $standardWorkHours = 8;
            $lateTime = $checkInTime->greaterThan($standardStartTime) ? $checkInTime->diffInMinutes($standardStartTime) : 0;
            $hoursWorked = $checkOutTime ? $checkOutTime->diffInHours($checkInTime) : 0;
            $overTime = $hoursWorked > $standardWorkHours ? $hoursWorked - $standardWorkHours : 0;

            DB::table('attendances')->insert([
                'date' => $request->date,
                'employee_id' => $request->employee_id,
                'check_in_latitude' => $request->check_in_latitude,
                'check_in_longitude' => $request->check_in_longitude,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'location' => $request->location,
                'hours' => $hoursWorked,
                'late_time' => 0,
                'over_time' => $overTime,
                'status' => '1',
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            return response()->json(['success' => true, 'message' => 'Successfully created'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'check_out_time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $attendance = DB::table('attendances')
                ->where('id', $id)
                ->first();

            if (!$attendance) {
                return response()->json(['error' => 'Attendance record not found'], 404);
            }

            $checkInTime = Carbon::parse($attendance->check_in_time);
            $checkOutTime = Carbon::parse($request->check_out_time);
            $standardStartTime = Carbon::createFromTime(9, 0, 0);
            $standardWorkHours = 8;
            $hoursWorked = $checkOutTime->diffInHours($checkInTime);
            $overTime = $hoursWorked > $standardWorkHours ? $hoursWorked - $standardWorkHours : 0;

            $lateTime = $standardWorkHours > $hoursWorked ? $standardWorkHours - $hoursWorked : 0;

            DB::table('attendances')
                ->where('id', $id)
                ->update([
                    'check_out_time' => $request->check_out_time,
                    'hours' => $hoursWorked,
                    'late_time' => $lateTime,
                    'over_time' => $overTime,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now()
                ]);

            return response()->json('Successfully updated', 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update: ' . $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $data = Attendance::findOrFail($id);
            return response()->json($data, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
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
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();
            return response()->json('Successfully deleted', 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Data not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete'], 500);
        }
    }

    public function employee_list()
    {
        //
        try {
            $data = DB::table('employees')->get();
            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Unable to retrieve data'], 500);
        }
    }

    public function check_out(Request $request)
    {

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'check_out_time' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {

            $hours = 0;
            $over_time = 0;
            $late_time = 0;
            $status = '';

            $attendance = Attendance::findOrFail($request->id);

            // $date1 = Carbon::parse($attendance->check_in_time);
            // $date2 = Carbon::parse($request->check_out_time);

            // $hours= $date1->diffInRealHours($date2);

            // if($hours>8)
            // {
            //     $status = 'Regular';
            // }

            // if($hours<8)
            // {
            //     $status = 'Late';
            // }

            DB::table('attendances')
                ->where('id', $request->id)
                ->update([
                    'over_time' => $over_time,
                    'late_time' => $late_time,
                    'status' => $status,
                    'hours' => $hours,
                    'check_out_time' => $request->check_out_time,
                    'updated_by' => Auth::user()->id,
                    'updated_at' => Carbon::now(),
                ]);


            return response()->json('Successfully updated', 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update'], 500);
        }
    }
}
