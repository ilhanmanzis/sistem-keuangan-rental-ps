<?php

namespace App\Http\Controllers;

use App\Models\Pengeluarans as ModelsPengeluarans;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Pengeluarans extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $pengeluarans = ModelsPengeluarans::with(['user', 'shift'])
                ->filter(request()->only(['user', 'tanggal']))
                ->orderBy('updated_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        } else {
            $pengeluarans = ModelsPengeluarans::with(['user', 'shift'])
                ->tanggal(request()->only('tanggal'))
                ->where('id_user', $user->id)
                ->orderBy('updated_at', 'desc')
                ->paginate(10)
                ->withQueryString();
        }
        $data = [
            'selected' =>  'Pengeluaran',
            'page' => 'Pengeluaran',
            'title' => 'Pengeluaran',
            'pengeluarans' => $pengeluarans,
            'karyawans' => User::all()
        ];

        return view('pengeluaran/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Pengeluaran',
            'page' => 'Pengeluaran',
            'title' => 'Tambah Pengeluaran',
        ];

        return view('pengeluaran/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'harga' => 'required|integer',
        ], [
            'keterangan.required' => 'keterangan tidak boleh kosong',
            'harga.required' => 'harga tidak boleh kosong',
            'harga.integer' => 'harga harus berupa angka',
        ]);

        return redirect(route('pengeluaran.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();

        $pengeluaran = ModelsPengeluarans::with(['user', 'shift'])->find($id);
        if ($user->role === 'admin' || $user->id === $pengeluaran->user->id) {
            $data = [
                'selected' =>  'Pengeluaran',
                'page' => 'Pengeluaran',
                'title' => 'Pengeluaran',
                'pengeluaran' => $pengeluaran,
                'karyawans' => User::all()
            ];

            return view('pengeluaran/show', $data);
        } else {
            return redirect('/');
        }
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
        $request->validate([
            'keterangan' => 'required',
            'harga' => 'required|integer',
        ], [
            'keterangan.required' => 'keterangan tidak boleh kosong',
            'harga.required' => 'harga tidak boleh kosong',
            'harga.integer' => 'harga harus berupa angka',
        ]);

        return redirect(route('pengeluaran.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        return redirect(route('pengeluaran.index'))->with('success', 'Data berhasil dihapus');
    }
}
