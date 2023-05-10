<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    use AuthorizesRequests;
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', ['user' => $user]);
    }

    public function index()
    {
        //dd(Gate::allows('superadmin'));
        $users = User::all();
        return view('dashboard', compact('users'));
    }
    

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()->with('alert', 'User has been deleted')->with('alert-type', 'success');
    }

    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Validate input fields
        $validatedData = $request->validate([

            'first_name' => 'required|max:255',
            'middle_name' => 'nullable|max:255',
            'last_name' => 'required|max:255',
            'number' => 'required|numeric',
            'address' => 'nullable|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'position' => 'required|max:255',
            'user_role' => 'required|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user with the validated data
        $user->update($validatedData);

        // Handle image upload and update user's image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/', $filename);
            $user->image = $filename;
            $user->save();
        }

        // Redirect to the user's details page
        return redirect()->route('users.edit', $id)->with('alert', 'User updated successfully.')->with('alert-type', 'success');
    }

    //to create the user form the backend
    public function create()
    {
        return view('users.create');
    }

    //to store the created value for the new Employee
    public function store(Request $request)
    {
        // Validate input fields
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'middle_name' => 'nullable|max:255',
            'last_name' => 'required|max:255',
            'number' => 'required',
            'address' => 'required',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'position' => 'required|max:255',
            'user_role' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable', 
        ]);

        // Create the user with the validated data
        $user = User::create($validatedData);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'.'.$image->getClientOriginalExtension();
            Storage::putFileAs('public/images', $image, $filename);
            $user->image = $filename;
        }else{
            $user -> image = 'default-user-image.jpg';
        }

        $user->save();

        // Redirect to the user's details page
        return redirect()->route('users.create')->with('alert', 'User created successfully.')->with('alert-type', 'success');

    }


}
