<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LeaveCalender;
use App\Http\Controllers\AttendanceRecordController;
use Carbon\Carbon;
class AttendanceRecordController extends Controller
{
    public function index()
    {
        $users = User::all();
        $currentDate = now()->format('Y-m-d');
        $attendances = AttendanceRecord::where('date', $currentDate)->get();
        return view('attendances.index', compact('users', 'currentDate', 'attendances'));
    }

    public function create(Request $request)
    {
        // Get the user ID and date from the request
        $userId = $request->input('employee');
        $date = $request->input('date');

        // Check if an attendance record already exists for this date and user
        $attendanceRecord = AttendanceRecord::where('user_id', $userId)
            ->where('date', $date)
            ->first();

        // If an attendance record already exists, redirect back with an error message
        if ($attendanceRecord) {
            return redirect()->back()->with('error', 'An attendance record already exists for this date and user.');
        }

        // Otherwise, create a new attendance record with default values
        $attendanceRecord = new AttendanceRecord();
        $attendanceRecord->user_id = $userId;
        $attendanceRecord->date = $date;
        $attendanceRecord->status = 'present';
        $attendanceRecord->check_in = now();
        $attendanceRecord->check_out = now();
        $attendanceRecord->remarks = 'Overtime';
        $attendanceRecord->save();

        // Redirect to the edit page for the new attendance record

        return redirect()->route('attendance.edit', $attendanceRecord->id)->with('alert', 'Attendance record created successfully.')->with('alert-type', 'success');
    }


    public function store(Request $request)
    {
        $user_id = auth()->id();
        $dates = $request->input('date');
        $statuses = $request->input('status');
        $check_ins = $request->input('check_in');
        $check_outs = $request->input('check_out');
        $remarks = $request->input('remarks');

        foreach ($dates as $key => $date) {
            $attendance = AttendanceRecord::where('user_id', $user_id)
                ->whereDate('date', $date)
                ->first();
                if ($attendance) {
                    return redirect()->back()->with('error', 'Attendance has already been submitted for this day.');
                }
                
            $attendance = new AttendanceRecord();
            $attendance->user_id = $user_id;
            $attendance->date = Carbon::createFromFormat('Y-m-d', $date);
            $attendance->status = $statuses[$key] ?? '';
            $attendance->check_in = $check_ins[$key] ?? null;
            $attendance->check_out = $check_outs[$key] ?? date('18:30:00');
            $attendance->remarks = $remarks[$key] ?? '';
            if (!empty($attendance->status) || !empty($attendance->check_in)) {
                if (empty($attendance->check_in)) {
                    return redirect()->back()->with('error', 'Check-in time is required.');
                }
                $attendance->save();
            } else {
                // delete the record if there is no status, check_in, and check_out provided
                $attendance->delete();
            }
        }

        return redirect()->back()->with('alert', 'Attendance has been saved.')->with('alert-type', 'success');
    }


    public function generateReport(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $attendances = AttendanceRecord::whereYear('date', $year)
                                        ->whereMonth('date', $month)
                                        ->get();
        return view('attendance.report', [
            'attendances' => $attendances,
            'year' => $year,
            'month' => $month
        ]);
    }
    //yearly report for the admins to view of all the employeess
    public function generateEmployeesReport(Request $request)
    {
        $employeeId = $request->input('employee');
        $year = $request->input('year');
        $month = $request->input('month');
        $employee = User::findOrFail($employeeId);
        
        
        $attendances = AttendanceRecord::where('user_id', $employee)
                                ->whereYear('date', $year)
                                ->whereMonth('date', $month)
                                ->get();

        
        return view('attendance.reportEmployee', [
            'attendances' => $attendances,
            'employee' => $employee,
            'year' => $year,
            'month' => $month
        ]);
    }

    public function edit($id)
    {
        $attendance = AttendanceRecord::find($id);
        return view('attendance.edit', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $attendance = AttendanceRecord::find($id);
        $attendance->check_out = $request->input('check_out');
        $attendance->remarks = $request->input('remarks');
        $attendance->save();
        return redirect()->route('dashboard')->with('alert', 'Attendance updated successfully')->with('alert-type', 'success');

    }

    public function destroy(Request $request, $id)
    {
        $attendance = AttendanceRecord::findOrFail($id);
        $attendance->delete();
        return redirect()->route('report')->with('alert', 'Attendance Record has been deleted')->with('alert-type', 'success');
    }

    public function editRecord($id)
    {
        $attendance = AttendanceRecord::find($id);
        return view('attendance.editRecord', compact('attendance'));
    }
    
    public function updateRecord(Request $request, $id)
    {
        $attendance = AttendanceRecord::find($id);
        $attendance->check_out = $request->input('status');
        $attendance->check_out = $request->input('check_in');
        $attendance->check_out = $request->input('check_out');
        $attendance->remarks = $request->input('remarks');
        $attendance->save();
        return redirect()->route('report')->with('alert', 'Attendance updated successfully')->with('alert-type', 'success');
    }
    
    public function storeByAdmin(Request $request)
    {
        // validate the form data
        $validatedData = $request->validate([
            'employee_id' => 'required|numeric',
            'date' => 'required|date',
            'status' => 'required|string',
            'check_in' => 'nullable|date_format:H:i:s',
            'check_out' => 'nullable|date_format:H:i:s',
            'remarks' => 'nullable|string|max:255',
        ]);

        // create a new attendance record object
        $attendance = new AttendanceRecord();

        // fill the attendance record object with the form data
        $attendance->user_id = $validatedData['employee_id'];
        $attendance->date = $validatedData['date'];
        $attendance->status = $validatedData['status'];
        $attendance->check_in = $validatedData['check_in'];
        $attendance->check_out = $validatedData['check_out'];
        $attendance->remarks = $validatedData['remarks'];

        // save the attendance record to the database
        $attendance->save();

        // redirect back to the attendance report page with a success message
        return redirect()->back()->with('success', 'Attendance record added successfully.');
    }


}