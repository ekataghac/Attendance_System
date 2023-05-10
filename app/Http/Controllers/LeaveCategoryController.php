<?php

namespace App\Http\Controllers;
use App\Models\LeaveCategory;
use Illuminate\Http\Request;

class LeaveCategoryController extends Controller
{
    public function editLeaveCategory($id)
    {
        $leaveCategory = LeaveCategory::findOrFail($id);
        return view('editLeaveCategory', compact('leaveCategory'));
    }
    
    public function updateLeaveCategory(Request $request, $id)
    {
        $leaveCategory = LeaveCategory::findOrFail($id);
        $leaveCategory->name = $request->input('name');
        $leaveCategory->annual_entitlement = $request->input('annual_entitlement');
        $leaveCategory->save();
        return redirect()->route('leaveCalender')->with('alert', 'Leave category updated successfully.')->with('alert-type', 'success');
    }
    
    public function deleteLeaveCategory($id)
    {
        $leaveCategory = LeaveCategory::findOrFail($id);
        $leaveCategory->delete();
        return redirect()->route('leaveCalender')->with('alert', 'Leave category deleted successfully.')->with('alert-type', 'success');
    }

    public function storeLeaveCategory(Request $request)
    {
        $leaveCategory = new LeaveCategory();
        $leaveCategory->name = $request->name;
        $leaveCategory->annual_entitlement = $request->annual_entitlement;
        $leaveCategory->save();
        return redirect()->route('leaveCategory')->with('alert', 'Leave Category Added successfully.')->with('alert-type', 'success');
    }
}
