<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserPhotoController extends Controller
{
    // model binding melalui parameter (User $user) sistem akan melakukan $user = User::findOrFail($request->route('user'));
    public function show(User $user)
    {
        // dd(Auth::id(), request()->getHost());
        // Izin: pemilik atau admin (sesuaikan)
        // if (Auth::check() || (Auth::id() !== $user->id && Auth::User()->role_id !== 1)) {
        //     abort(403);
        // }
        // dd($user->id);
        Gate::authorize('viewPhoto', $user);

        $path = $user->photo_path; // "users/xxx.jpg"
        // dd($user);
        if (empty($path) || !Storage::disk('private')->exists($path)) {
            // Jika foto tidak ada, tampilkan avatar default dari public folder.
            return response()->file(Storage::disk('public')->path('users/avatar-default.png'));
        }

        $absolutePath = Storage::disk('private')->path($path);
        return response()->file($absolutePath, [
            'Cache-Control' => 'private, max-age=86400', // Cache di browser selama 1 hari
        ]);
    }
}
