<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ManajemenUser extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'selected' =>  'Manajemen User',
            'page' => 'Manajemen User',
            'title' => 'Manajemen User',
            'users' => User::paginate(10)->withQueryString()
        ];
        return view('manajemen/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Manajemen User',
            'page' => 'Manajemen User',
            'title' => 'Tambah User',
        ];
        return view('manajemen/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string',
            'role' => 'required|in:admin,karyawan', // Validasi role, hanya admin atau karyawan
            'foto' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048', // Maksimal 2MB
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'role.required' => 'Role harus dipilih',
            'foto.image' => 'foto harus berupa gambar',
            'foto.mimes' => 'foto harus berformat png, jpg, jpeg, atau webp',
            'foto.max' => 'foto harus berukuran max 2MB',
        ]);


        // Simpan file gambar jika ada
        if ($request->hasFile('foto')) {
            $extension = $request->file('foto')->extension();
            $uuidName = Str::uuid() . '.' . $extension;

            // Simpan ke storage/app/public/user
            $request->file('foto')->storeAs('user', time() . $uuidName, 'public');

            // Simpan nama file-nya ke database
            $imagePath = time() . $uuidName;
        } else {
            $imagePath = null;
        }

        // Simpan data user
        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'foto' => $imagePath,
        ]);

        return redirect()->route('users')->with('success', 'User berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'selected' =>  'Manajemen User',
            'page' => 'Manajemen User',
            'title' => 'Edit User',
            'user' => User::find($id)
        ];
        return view('manajemen/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        if ($id != Auth::id()) {
            return redirect('/');
        }
        $data = [
            'selected' =>  'Edit Profile',
            'page' => 'Edit Profile',
            'title' => 'Edit Profile',
            'user' => User::find($id)
        ];
        return view('edit-profile', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|max:255|email|unique:users,email,' .  $id,
            'password' => 'nullable|string',
            'role' => 'required|in:admin,karyawan', // Validasi role, hanya admin atau karyawan
            'foto' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048', // Maksimal 2MB
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'role.required' => 'Role harus dipilih',
            'foto.image' => 'foto harus berupa gambar',
            'foto.mimes' => 'foto harus berformat png, jpg, jpeg, atau webp',
            'foto.max' => 'foto harus berukuran max 2MB',
        ]);

        // Ambil data user
        $user = User::findOrFail($id);

        // Update data
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Proses foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists('user/' . $user->foto)) {
                Storage::disk('public')->delete('user/' . $user->foto);
            }

            // Simpan foto baru
            $extension = $request->file('foto')->extension();
            $uuidName = Str::uuid() . '.' . $extension;

            // Simpan ke storage/app/public/user
            $request->file('foto')->storeAs('user', time() . $uuidName, 'public');


            // Simpan nama file ke database
            $user->foto = time() . $uuidName;
        }

        // Simpan perubahan
        $user->save();

        return redirect()->route('users')->with('success', 'Data berhasil diperbarui.');
    }

    public function updateProfile(Request $request, string $id)
    {

        if ($id != Auth::id()) {
            return redirect('/');
        }
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|max:255|email|unique:users,email,' .  $id,
            'password' => 'nullable|string',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048', // Maksimal 2MB
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'foto.image' => 'foto harus berupa gambar',
            'foto.mimes' => 'foto harus berformat png, jpg, jpeg, atau webp',
            'foto.max' => 'foto harus berukuran max 2MB',
        ]);

        // Ambil data user
        $user = User::findOrFail($id);

        // Update data
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];


        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Proses foto jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists('user/' . $user->foto)) {
                Storage::disk('public')->delete('user/' . $user->foto);
            }

            // Simpan foto baru
            $extension = $request->file('foto')->extension();
            $uuidName = Str::uuid() . '.' . $extension;

            // Simpan ke storage/app/public/user
            $request->file('foto')->storeAs('user', time() . $uuidName, 'public');


            // Simpan nama file ke database
            $user->foto = time() . $uuidName;
        }

        // Simpan perubahan
        $user->save();

        return redirect(route('users.edit', ['id' => $id]))->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil user
        $user = User::findOrFail($id);
        if ($user->id === 1) {
            return redirect()->route('users');
        }

        if ($user->foto && Storage::disk('public')->exists('user/' . $user->foto)) {
            Storage::disk('public')->delete('user/' . $user->foto);
        }

        // Hapus user dari database
        $user->delete();

        return redirect()->route('users')->with('success', 'User berhasil dihapus.');
    }
}
