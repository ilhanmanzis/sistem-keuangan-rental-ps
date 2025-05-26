<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Shifts;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class Auth extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = ['profile' => Profile::first()];
        return view('auth/login', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|max:255',
            'password' => 'required|max:255',
        ], [
            'email.required' => 'email or username tidak boleh kosong',
            'password.required' => 'password tidak boleh kosong',
        ]);

        $login = $request->input('email'); // Bisa username atau email
        $password = $request->input('password');

        // Deteksi apakah email atau username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Login menggunakan field yang sesuai dan role
        $credentials = [
            $field => $login,
            'password' => $password,
        ];



        if (FacadesAuth::attempt($credentials)) {
            $request->session()->regenerate();
            // Ambil jam saat ini dalam format HH:MM:SS
            $now = Carbon::now()->format('H:i:s');

            // Ambil semua shift
            $shifts = Shifts::all();
            $activeShift = $shifts->first(function ($shift) use ($now) {
                $start = Carbon::createFromFormat('H:i:s', $shift->jam_mulai);
                $end = Carbon::createFromFormat('H:i:s', $shift->jam_selesai);

                // Kasus shift yang melewati tengah malam
                if ($end->lessThanOrEqualTo($start)) {
                    return Carbon::createFromFormat('H:i:s', $now)->between($start, $end->addDay()) ||
                        Carbon::createFromFormat('H:i:s', $now)->lessThan($end);
                }

                return Carbon::createFromFormat('H:i:s', $now)->between($start, $end);
            });

            // Simpan shift ke session
            if ($activeShift) {
                session([
                    'shift' => [
                        'id_shift'    => $activeShift->id_shift,
                        'name'        => $activeShift->name,
                        'jam_mulai'   => $activeShift->jam_mulai,
                        'jam_selesai' => $activeShift->jam_selesai,
                    ],
                ]);
            }
            return redirect()->intended(route('dashboard'));
        } else {
            return redirect('login')->with('message', 'email, username dan password salah');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        FacadesAuth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
