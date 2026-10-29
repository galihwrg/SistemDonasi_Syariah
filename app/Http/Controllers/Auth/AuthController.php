<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request): RedirectResponse
    {
        $userType = $request->input('user_type', 'umum');

        if ($userType === 'mahasiswa') {
            $validated = $request->validate([
                'credential' => ['required', 'string'],
                'password'   => ['required', 'string'],
            ], [
                'credential.required' => 'NIM/email kampus wajib diisi.',
                'password.required'   => 'Kata sandi wajib diisi.',
            ]);

            // Coba login via NIM/NIK dulu, lalu email
            $user = User::where('nim_nik', $validated['credential'])
                ->orWhere('email', $validated['credential'])
                ->where('user_type', 'mahasiswa')
                ->first();
        } else {
            $validated = $request->validate([
                'credential' => ['required', 'string'],
                'password'   => ['required', 'string'],
            ], [
                'credential.required' => 'Email atau nama pengguna wajib diisi.',
                'password.required'   => 'Kata sandi wajib diisi.',
            ]);

            $user = User::where('email', $validated['credential'])
                ->orWhere('name', $validated['credential'])
                ->first();
        }

        if (! $user || ! Hash::check($validated['password'], $user->password)) {
            return back()
                ->withInput($request->only('credential', 'user_type'))
                ->withErrors(['credential' => 'Kredensial yang dimasukkan tidak sesuai.']);
        }

        Auth::login($user, (bool) $request->boolean('remember'));

        $request->session()->regenerate();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended(route('home'));
    }

    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    /**
     * Proses pendaftaran akun baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $userType = $request->input('user_type', 'umum');

        $commonRules = [
            'name'                  => ['required', 'string', 'max:100'],
            'email'                 => ['required', 'email', 'unique:users,email'],
            'phone_number'          => ['required', 'string', 'max:20'],
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'agree_tos'             => ['accepted'],
        ];

        $commonMessages = [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'name.max'               => 'Nama lengkap maksimal 100 karakter.',
            'email.required'         => 'Email aktif wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email ini sudah terdaftar. Silakan masuk.',
            'phone_number.required'  => 'Nomor WhatsApp/HP wajib diisi.',
            'password.required'      => 'Kata sandi wajib diisi.',
            'password.min'           => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'     => 'Konfirmasi kata sandi tidak cocok.',
            'agree_tos.accepted'     => 'Anda harus menyetujui Ketentuan Layanan untuk mendaftar.',
        ];

        if ($userType === 'mahasiswa') {
            $extraRules = [
                'campus_name' => ['required', 'string', 'max:200'],
                'nim_nik'     => ['required', 'string', 'max:50'],
            ];
            $extraMessages = [
                'campus_name.required' => 'Nama perguruan tinggi wajib diisi.',
                'nim_nik.required'     => 'NIM/NIDN wajib diisi.',
            ];
            $validated = $request->validate(
                array_merge($commonRules, $extraRules),
                array_merge($commonMessages, $extraMessages)
            );
        } else {
            $validated = $request->validate($commonRules, $commonMessages);
        }

        $userData = [
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password'     => Hash::make($validated['password']),
            'role'         => 'user',
            'user_type'    => $userType,
            'is_verified'  => false,
        ];

        if ($userType === 'mahasiswa') {
            $userData['campus_name'] = $validated['campus_name'];
            $userData['nim_nik']     = $validated['nim_nik'];
        }

        $user = User::create($userData);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('success', 'Akun berhasil dibuat! Selamat datang, ' . $user->name . '.');
    }

    /**
     * Logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
