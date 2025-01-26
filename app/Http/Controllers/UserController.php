<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query();
            
            return DataTables::of($users)
                ->addColumn('actions', function ($user) {
                    return '<a href="' . route('users.show', $user->id) . '" class="btn btn-primary btn-sm">View</a>
                    <a href="' . route('users.edit', $user->id) . '" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-user" data-id="' . $user->id . '">Delete</button>';
                })
                ->rawColumns(['actions']) // Allow raw HTML for the actions column
                ->make(true);
        }

        return view('users.index');
    }


    public function create(Request $request)
    {
        return view('users.create');
    }        

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        // Store User
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Redirect with success message
        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:user,admin',
        ]);

        $user = User::findOrFail($id);

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => 'User deleted successfully!']);
    }



}
