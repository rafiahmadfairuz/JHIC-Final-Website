<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah.');
        }

        Auth::login($user);

        switch ($user->role) {
            case 'admin_utama':
            case 'admin_perpus':
                return redirect('/dashboardLanding/profileSekolah')->with('success', 'Login berhasil!');
            case 'admin_bkk':
                return redirect('/dashboard/jobfair')->with('success', 'Login berhasil!');
            case 'guru':
                return redirect('/lms/dashboard/jurusan')->with('success', 'Login berhasil!');
            case 'siswa':
                return redirect('/')->with('success', 'Login berhasil!');
            case 'alumni':
                return redirect('/jobfair')->with('success', 'Login berhasil!');
            case "perusahaan":
                return redirect('/dashboard/jobfair/lamaran')->with('success', 'Login berhasil!');
            default:
                Auth::logout();
                return back()->with('error', 'Role tidak dikenali.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil logout.');
    }
}
