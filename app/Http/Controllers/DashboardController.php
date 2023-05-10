<?php

namespace App\Http\Controllers;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $attendances = AttendanceRecord::where('user_id', $user->id)->orderBy('date', 'desc')->get();
        return view('dashboard', ['attendances' => $attendances]);
    }
}
