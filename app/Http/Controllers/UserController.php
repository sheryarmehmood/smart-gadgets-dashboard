<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query();
            
            return DataTables::of($users)
                ->addColumn('actions', function ($user) {
                    return '<a href="'.route('users.show', $user->id).'" class="btn btn-primary btn-sm">View</a>';
                })
                ->rawColumns(['actions']) // Allow raw HTML for the actions column
                ->make(true);
        }

        return view('users');
    }
}
