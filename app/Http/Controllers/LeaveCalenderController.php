<?php

namespace App\Http\Controllers;
use App\Models\LeaveCalender;
use App\Models\LeaveCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaveCalenderController extends Controller
{

    public function leaveCalender()
    {
        $leaveCalenders = LeaveCalender::all();
        $leaveCategories = LeaveCategory::all(); // get all leave categories
        return view('leaveCalender', ['leaveCalenders' => $leaveCalenders, 'leaveCategories' => $leaveCategories]);
    }

    public function storeHoliday(Request $request)
    {
        $leaveCalender = new LeaveCalender();
        $leaveCalender->name = $request->name;
        $leaveCalender->start_date = $request->start_date;
        $leaveCalender->end_date = $request->end_date;
        $leaveCalender->save();
        return redirect()->route('leaveCalender')->with('alert', 'Holiday Added successfully.')->with('alert-type', 'success');
    }

    public function storeLeaveCategory(Request $request)
    {
        $leaveCategoy= new LeaveCategory();
        $leaveCategoy->name = $request->name;
        $leaveCategoy->annual_entitlement = $request->annual_entitlement;
        $leaveCategoy->save();
        return redirect()->route('leaveCalender')->with('alert', 'Leave Categories Added successfully.')->with('alert-type', 'success');
    }

    public function showLeaveRecord($id)
    {
        $user = User::findOrFail($id);
        $leave_requests_user = LeaveRequest::where('user_id', $id)->get();
        $leave_categories = LeaveCategory::all();
    
        return view('leaveRecord.show')
            ->with('user', $user)
            ->with('leave_requests_user', $leave_requests_user)
            ->with('leave_categories', $leave_categories);
    }
    
    public function editLeaveCalender($id)
    {
        $leaveCalender = LeaveCalender::find($id);
        $leaveCategories = LeaveCategory::all(); // get all leave categories
        return view('editLeaveCalender', ['leaveCalender' => $leaveCalender, 'leaveCategories' => $leaveCategories]);
    }

    public function updateLeaveCalender(Request $request, $id)
    {
        $leaveCalender = LeaveCalender::find($id);
        $leaveCalender->name = $request->input('name');
        $leaveCalender->start_date = $request->input('start_date');
        $leaveCalender->end_date = $request->input('end_date');
        $leaveCalender->save();
        return redirect()->route('leaveCalender')->with('alert', 'Leave Calender updated successfully.')->with('alert-type', 'success');
    }

    public function deleteLeaveCalender($id)
    {
        $leaveCalender = LeaveCalender::find($id);
        $leaveCalender->delete();
        return redirect()->route('leaveCalender')->with('alert', 'Leave Calender deleted successfully.')->with('alert-type', 'success');
    }



    public function getHolidays()
    {
        $holidays = LeaveCalender::all();
        $formattedHolidays = $holidays->map(function($holiday) {
            return [
                'id' => $holiday->id,
                'name' => $holiday->name,
                'start_date' => date('Y-m-d', strtotime($holiday->start_date)),
                'end_date' => date('Y-m-d', strtotime($holiday->end_date)),
            ];
        });
        return response()->json($formattedHolidays);
    }
    
}
