<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class EmployeeController extends Controller
{
    use AuthorizesRequests;
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', ['user' => $user]);
    }

    public function index()
    {
        $users = User::latest()->paginate(5);
        return view('employeeCrud', compact('users'));
    }
}
