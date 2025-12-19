<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index(){
        $admin = User::where('role','admin')->get();
        $user = User::where('role','user')->get();

        return view('admin.akun', compact('admin','user'));
    }
}
