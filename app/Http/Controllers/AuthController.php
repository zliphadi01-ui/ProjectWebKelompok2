<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $credentials['username'];
        $password = $credentials['password'];

        // Coba autentikasi menggunakan email atau nama
        try {
            if (Schema::hasTable('users')) {
                // Cari pengguna berdasarkan email atau nama
                $user = User::where('email', $username)->orWhere('name', $username)->first();

                if ($user && Hash::check($password, $user->password)) {
                    // Berhasil login menggunakan Auth Facade
                    Auth::login($user);
                    // Set session manual untuk kompatibilitas dengan kode lama yang mungkin pakai session('user')
                    session(['user' => $user->name, 'user_id' => $user->id, 'user_photo' => $user->profile_photo ?? null]);
                    
                    if ($request->wantsJson() || $request->ajax()) {
                        return response()->json(['ok' => true, 'redirect' => url('/dashboard')]);
                    }
                    return redirect()->intended('/dashboard');
                }
            }
        } catch (\Exception $e) {
            logger()->error('DB Auth Error: ' . $e->getMessage());
        }

        // Gagal login
        $errorMessage = 'Username atau password salah!';
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['ok' => false, 'message' => $errorMessage], 422);
        }

        return back()->withInput()->withErrors(['username' => $errorMessage]);
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget(['user', 'user_id', 'user_photo']); // Hapus sesi manual juga
        return redirect('/login');
    }
}