<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LeaveCalenderController;
use App\Http\Controllers\LeaveCategoryController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/report', [\App\Http\Controllers\ReportController::class, 'report'])
    ->middleware(['auth', 'verified'])
    ->name('report');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users/{id}', [UserController::class, 'show'])->middleware(['auth', 'verified']);

Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);
//to add the employee in the system
Route::get('/users/add-create', [UserController::class, 'create'])->name('users.create')->middleware(['auth', 'verified','can:adminOrSuperadmin']);

Route::post('/users/store', [UserController::class, 'store'])->name('users.store')->middleware(['auth', 'verified']);


//to edit the employee from the system
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware(['auth', 'verified','can:adminOrSuperadmin']);

//updating the employees details
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware(['auth', 'verified']);

// to delet the employee from the system
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware(['auth', 'verified']);


Route::get('/employeecrud', [EmployeeController::class, 'index'])->name('employeecrud')->middleware(['auth', 'verified']);

//viewing all the leave requests of the user
Route::get('/leave-request', [LeaveRequestController::class, 'index'])->name('leaveRequest')->middleware(['auth', 'verified']);
Route::get('/leave-request/create', [LeaveRequestController::class, 'create'])->name('leave-request.create')->middleware(['auth', 'verified']);

Route::post('/store/leave-requests', [LeaveRequestController::class, 'store'])->name('store/leave-requests.store')->middleware(['auth', 'verified']);
//route for the responding the pending status for the leave requests
Route::get('/leave-requests/respond/{id}',  [LeaveRequestController::class, 'respond'])->name('leave-requests.respond')->middleware(['auth', 'verified','can:superadmin']);

//to define a route to update the response in the leaveRequest 
Route::put('/leave-requests/respond/{id}', [LeaveRequestController::class, 'update'])->name('leaveRequest.respond.update')->middleware(['auth', 'verified']);

//to handle the attendance 
Route::post('/attendance', [AttendanceRecordController::class, 'store'])->name('attendance')->middleware(['auth', 'verified']);

//to update the attendance check_out time or the remarks 
Route::put('/attendance/{id}', [AttendanceRecordController::class, 'update'])->name('attendance.update')->middleware(['auth', 'verified']);

//editing the attendance 
Route::get('/attendance/{id}/edit', [AttendanceRecordController::class, 'edit'])->name('attendance.edit')->middleware(['auth', 'verified']);

// to delete the employee attendance from the system
Route::delete('/attendance/{attendance}', [AttendanceRecordController::class, 'destroy'])
    ->name('attendance.destroy')
    ->middleware(['auth', 'verified']);

Route::get('/attendance/{id}/editRecord', [AttendanceRecordController::class, 'editRecord'])->name('attendance.editRecord')->middleware(['auth', 'verified']);
Route::put('/attendance/{id}/updateRecord', [AttendanceRecordController::class, 'updateRecord'])->name('attendance.updateRecord')->middleware(['auth', 'verified']);


Route::post('/attendance-report', [AttendanceRecordController::class, 'generateReport'])->name('attendance.report')->middleware(['auth', 'verified']);
Route::get('/attendance-weekly-report', [AttendanceRecordController::class, 'index'])->name('attendance.index');
Route::post('/attendance/show', [ReportController::class, 'showWeeklyAttendance'])->name('attendance.show')->middleware(['auth', 'verified']);
Route::post('/attendance/report-employee', [AttendanceRecordController::class, 'generateEmployeesReport'])->name('attendance.reportEmployee')->middleware(['auth', 'verified']);

Route::get('/attendance/create', [AttendanceRecordController::class, 'create'])->name('attendance.create');


Route::get('/report', [ReportController::class, 'show'])->name('report')->middleware(['auth', 'verified']);
Route::get('/attendance/summerizedReport', [ReportController::class, 'show2'])->name('attendance.summerizedReport')->middleware(['auth', 'verified']);

Route::get('/leaveRecord', [LeaveRequestController::class, 'LeaveRecord'])->name('leaveRecord')->middleware(['auth', 'verified']);

//for the leave_calenders table
//to show the all the content of the leave_calenders table
Route::get('/leave-calender', [LeaveCalenderController::class, 'leaveCalender'])->name('leaveCalender')->middleware(['auth', 'verified']);

//add the holiday from the ui by the admin
Route::post('/store-holiday', [LeaveCalenderController::class, 'storeHoliday'])->name('storeHoliday')->middleware(['auth', 'verified']);
Route::post('/store-leaveCategory', [LeaveCalenderController::class, 'storeLeaveCategory'])->name('storeLeaveCategory')->middleware(['auth', 'verified']);


//for the leave calender data edit and deletion 

Route::get('/leaveCalender/edit/{id}', [LeaveCalenderController::class, 'editLeaveCalender'])->name('editLeaveCalender')->middleware(['auth', 'verified']);
Route::put('/leaveCalender/update/{id}', [LeaveCalenderController::class, 'updateLeaveCalender'])->name('updateLeaveCalender.update')->middleware(['auth', 'verified']);
Route::delete('/leaveCalender/delete/{id}', [LeaveCalenderController::class, 'deleteLeaveCalender'])->name('deleteLeaveCalender')->middleware(['auth', 'verified']);

Route::get('/LeaveCategory/edit/{id}', [LeaveCategoryController::class, 'editLeaveCategory'])->name('editLeaveCategory')->middleware(['auth', 'verified']);
Route::put('/LeaveCategory/update/{id}', [LeaveCategoryController::class, 'updateLeaveCategory'])->name('updateLeaveCategory')->middleware(['auth', 'verified']);
Route::delete('/LeaveCategory/delete/{id}', [LeaveCategoryController::class, 'deleteLeaveCategory'])->name('deleteLeaveCategory')->middleware(['auth', 'verified']);


require __DIR__.'/auth.php';

