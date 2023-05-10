<?php

namespace App\Http\Controllers;
use App\Models\AttendanceRecord;
use App\Models\LeaveCalender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function report()
    {
        $users = User::all(); // get all users
        $attendances = attendanceRecord::with('user')
            ->whereDate('date', '=', now()->toDateString()) // filter by today's date
            ->orderBy('date', 'desc')
            ->get();

        return view('report', ['users' => $users, 'attendances' => $attendances]);
    } 
    
    public function show(Request $request)
    {
        $users = User::all(); // get all users
        
        $year = $request->input('year', now()->year); // get year from request, default to current year

        //for the logegd in user 
        $attendance_records = AttendanceRecord::where('user_id', auth()->id())->whereYear('date', $year)->get();
        
        $attendances = attendanceRecord::with('user')
            ->whereDate('date', '=', now()->toDateString()) // filter by today's date
            ->orderBy('date', 'desc')
            ->get();

        $monthly_summary = collect();
        $present_days_in_year = 0;
        $absent_days_in_year = 0;
        $work_days_in_year = 0;

        foreach (range(1, 12) as $month) {
            $present_days = 0;
            $absent_days = 0;
            $total_work_days = 0;

            $month_name = Carbon::create($year, $month, 1)->format('F');
            $days_in_month = Carbon::create($year, $month, 1)->daysInMonth;
            $holidays_in_month = LeaveCalender::whereDate('start_date', '<=', Carbon::create($year, $month, $days_in_month))
            ->whereDate('end_date', '>=', Carbon::create($year, $month, 1))
            ->count();

            foreach ($attendance_records as $record) {
                $date = Carbon::parse($record->date);
                
                if ($date->month == $month && ($record->status == 'present' || $record->status == 'late')) {
                    $present_days++;
                }
                
            }

            $absent_days = $days_in_month - $present_days;
            $total_work_days = $days_in_month - $holidays_in_month;

            $monthly_summary->push([
                'month' => $month_name,
                'present_days' => $present_days,
                'absent_days' => $absent_days,
                'total_work_days' => $total_work_days,
            ]);
            $present_days_in_year += $present_days;
            $absent_days_in_year += $absent_days;
            $work_days_in_year += $total_work_days;
        }
        $summary['present_days_in_year'] = $present_days_in_year;
        $summary['absent_days_in_year'] = $absent_days_in_year;
        $summary['work_days_in_year'] = $work_days_in_year;
        return view('report', [
            'users' => $users,
            'monthly_summary' => $monthly_summary,
            'attendances' => $attendances,
            'year' => $year,
            'summary' => $summary, 
            'present_days_in_year' => $present_days_in_year,
            'absent_days_in_year' => $absent_days_in_year,
            'work_days_in_year' => $work_days_in_year,
        ]);
    }

    public function show2(Request $request)
    {
        $users = User::all(); // get all users
    
        $year = $request->input('year', now()->year); // get year from request, default to current year
        $user_id = $request->input('employee'); // get the selected user's ID from request
        $user = User::find($user_id); // get the selected user object
        $attendance_records = AttendanceRecord::where('user_id', $user_id)
            ->whereYear('date', $year)
            ->get(); // filter by the selected user's ID
    
        $monthly_summary = collect();
        $attendances = attendanceRecord::with('user')
            ->whereDate('date', '=', now()->toDateString()) // filter by today's date
            ->orderBy('date', 'desc')
            ->get();
    
        $present_days_in_year = 0;
        $absent_days_in_year = 0;
        $work_days_in_year = 0;
    
        foreach (range(1, 12) as $month) {
            $present_days = 0;
            $absent_days = 0;
            $total_work_days = 0;
    
            $month_name = Carbon::create($year, $month, 1)->format('F');
            $days_in_month = Carbon::create($year, $month, 1)->daysInMonth;
            $holidays_in_month = LeaveCalender::whereDate('start_date', '<=', Carbon::create($year, $month, $days_in_month))
                ->whereDate('end_date', '>=', Carbon::create($year, $month, 1))
                ->count();
    
            foreach ($attendance_records as $record) {
                $date = Carbon::parse($record->date);
    
                if ($date->month == $month && ($record->status == 'present' || $record->status == 'late')) {
                    $present_days++;
                }
            }
    
            $absent_days = $days_in_month - $present_days;
            $total_work_days = $days_in_month - $holidays_in_month;
    
            $monthly_summary->push([
                'month' => $month_name,
                'present_days' => $present_days,
                'absent_days' => $absent_days,
                'total_work_days' => $total_work_days,
            ]);
            $present_days_in_year += $present_days;
            $absent_days_in_year += $absent_days;
            $work_days_in_year += $total_work_days;
        }
        $summary['present_days_in_year'] = $present_days_in_year;
        $summary['absent_days_in_year'] = $absent_days_in_year;
        $summary['work_days_in_year'] = $work_days_in_year;
        return view('attendance.summerizedReport', [
            'users' => $users,
            'monthly_summary' => $monthly_summary,
            'attendances' => $attendances,
            'year' => $year,
            'summary' => $summary, 
            'present_days_in_year' => $present_days_in_year,
            'absent_days_in_year' => $absent_days_in_year,
            'work_days_in_year' => $work_days_in_year,
            'user' => $user,
        ]);
    }
    



    // to display users attendance details for the selected week
   public function showWeeklyAttendance(Request $request)
    {
        $employee_id = $request->input('employee');
        if ($employee_id == 'mine') {
            $user_id = Auth::id();
            $attendance = AttendanceRecord::where('user_id', $user_id)
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->get();
        } else {
            $attendance = AttendanceRecord::with('user')
                ->where('user_id', $employee_id)
                ->whereBetween('date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->get();
        }
        return view('attendance.show', compact('attendance'));
    }

}
