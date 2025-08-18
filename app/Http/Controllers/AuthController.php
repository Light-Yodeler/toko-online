<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    // public function authentication(Request $request)
    // {
    //     $validation = $request->validate([
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);
    //     // $user = User::where('email', $request->email)->first();

    //     // // Kalau tidak ada user
    //     // if (!$user) {
    //     //     return back()->with('flash', [
    //     //         'type'    => 'error',
    //     //         'message' => 'Email tidak terdaftar.'
    //     //     ]);
    //     // }

    //     // if (!Hash::check($request->password, $user->password)) {
    //     //     return back()->with('flash', [
    //     //         'type'    => 'error',
    //     //         'message' => 'password salah'
    //     //     ]);
    //     // }


    //     if (Auth::attempt($validation)) {
    //         $request->session()->regenerate();

    //         $user = Auth::user();

    //         if ($user->isAdmin()) {
    //             return redirect()->route('admin.dashboard');
    //         }
    //         // if ($user->isKasir()) {
    //         //     return redirect()->route('kasir.dashboard');
    //         // }
    //         // if ($user->isManager()) {
    //         //     return redirect()->route('manager.dashboard');
    //         // }
    //     }

    //     $message = [
    //         'message' => 'Email atau password salah',
    //         'type' => 'error'

    //     ];

    //     return redirect()->route('login')->with('flash', $message);
    // }

    public function authentication(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email', // Tambah validasi format email
            'password' => 'required'
        ]);

        // Gunakan Auth::attempt() langsung dengan credentials
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::with('role')->find(Auth::id());

            // dd([
            //     'class' => get_class($user),
            //     'file' => (new \ReflectionC - lass($user))->getFileName(),
            //     'hasMethod_isAdmin' => method_exists($user, 'isAdmin'),
            // ]);
            // dd($user->isAdmin());

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            // Tambahkan role lainnya di sini...

            // Default redirect jika tidak ada role yang cocok
            abort(404);
        }

        // Jika Auth::attempt gagal
        return back()->with('flash', [
            'type' => 'error',
            'message' => 'Email atau password salah'
        ]);
    }
}
