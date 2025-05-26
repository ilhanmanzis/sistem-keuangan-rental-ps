<?php

namespace App\Http\Controllers;

use App\Models\Pengeluarans;
use App\Models\Profile;
use App\Models\Transaksis;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Psy\Readline\Transient;

class Laporan extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'selected' => 'Laporan',
            'page' => 'Laporan',
            'title' => 'Laporan',
            'karyawans' => User::all()
        ];

        return view('laporan/index', $data);
    }

    public function print(Request $request)
    {
        //dd($request['karyawan']);
        $request->validate([
            'mulai' => 'required',
            'selesai' => 'required',
            'transaksi' => 'required',
            'karyawan' => 'required',
        ]);
        $karyawan = $request['karyawan'];
        $transaksi = $request['transaksi'];
        $mulai = $request['mulai'];
        $selesai = $request['selesai'];
        $profile = Profile::first();

        if ($karyawan === 'all' &&  $transaksi === 'all') {
            $pemasukan = Transaksis::whereBetween('tanggal', [$mulai, $selesai])->get();
            $pengeluaran = Pengeluarans::whereBetween('tanggal', [$mulai, $selesai])->get();

            $data = [
                'pemasukans' => $pemasukan,
                'pengeluarans' => $pengeluaran,
                'profile' => $profile,
                'logo' => public_path('storage/logo/' . $profile['logo']),
                'mulai' => $mulai,
                'selesai' => $selesai
            ];

            $pdf = Pdf::loadView('laporan/print-all', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('laporan-transaksi.pdf');
        }

        if ($karyawan === 'all' && $transaksi === 'pemasukan') {
            $pemasukan = Transaksis::whereBetween('tanggal', [$mulai, $selesai])->get();
            $data = [
                'pemasukans' => $pemasukan,
                'profile' => $profile,
                'logo' => public_path('storage/logo/' . $profile['logo']),
                'mulai' => $mulai,
                'selesai' => $selesai
            ];

            $pdf = Pdf::loadView('laporan/print-all-karyawan-pemasukan', $data);
            $pdf->setPaper('A4', 'portrait');
            return $pdf->stream('laporan-all-karyawan-pemasukan.pdf');
        }



        return redirect(route('laporan.index'))->with('error', 'data tidak ditemukan');
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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
