<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:50',
        ]);
        if(FacadesAuth::attempt($request -> only('email', 'password'), $request->remember)){
            if(FacadesAuth::user()->role == 'admin'){
                return redirect()->route('dashboard');
            } 
            return redirect()->route('home');
        }
        return back() -> with('failed', 'Email atau Password salah');
    }
    
        private function generateNoUser()
    {
        // Ambil user terakhir
        $lastUser = User::orderBy('idUser', 'desc')->first();

        // Buat increment
        $increment = $lastUser ? $lastUser->id + 1 : 1;

        // Format: YYYYMMDDHHMMSS + increment
        return now()->format('YmdHis') . $increment;
    }

    public function register(Request $request){
        $register = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:50|min:8|confirmed',
            'photo' => 'image|min:1|mimes:png,jpg,jpeg,webp',
            'role' => 'min:1'
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $no_user = $this->generateNoUser();

        User::create([
            'name' => $register['name'],
            'email' => $register['email'],
            'password' => bcrypt($register['password']),
            'photo' => 'defaultphoto',
            'status' => 'active',
            'no_user' => $no_user
        ]);
        return redirect('login');
    }

    public function logout(){
        FacadesAuth::logout(FacadesAuth::user());
        return redirect('/login');
    }
}

