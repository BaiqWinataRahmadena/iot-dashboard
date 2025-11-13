<?php

namespace App\Http\Controllers;
use App\Models\User; // <-- Tambahkan
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', ['users' => $users]);
    }
}