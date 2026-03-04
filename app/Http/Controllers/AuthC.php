<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\User;
use App\Models\People;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthC extends Controller
{
    // ===== Form Login =====
    public function showLoginForm()
    {
        return view('auth.login'); // login untuk semua role
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();
            $user->last_login_at = now();
            $user->save();
            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'agent') {
                return redirect()->route('agent.dashboard');
            }

            if ($user->role === 'jemaah') {
                return redirect()->route('jemaah.dashboard');
            }

            Auth::logout();
            return redirect()->route('landingpage')
                ->with('error', 'Role tidak dikenali');
        }

        return back()->withInput()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }



    // ===== Logout =====
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();         // hapus semua session
        $request->session()->regenerateToken();    // proteksi CSRF
        return redirect()->route('login');
    }

    // ===== Form Register Jemaah =====
    public function showRegisterForm()
    {
        return view('auth.register'); // register khusus jemaah
    }

    // ===== Proses Register Jemaah =====
    public function registerJemaah(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // 1. Create People
            $people = People::create([
                'fullname' => $request->username,
            ]);

            // 2. Create User (akun login saja)
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true,
                'userable_id' => $people->id,
                'userable_type' => People::class,
            ]);

            // 3. Attach role jemaah
            $role = Role::where('name', 'jemaah')->first();
            if ($role) {
                $user->roles()->attach($role->id);
            }

            DB::commit();

            return redirect()->route('login')->with('success', 'Registrasi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Register gagal: ' . $e->getMessage());
        }
    }
}
