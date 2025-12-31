<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if(!session('admin')) return redirect()->route('admin.login');
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users.index', compact('users'));
    }
}
