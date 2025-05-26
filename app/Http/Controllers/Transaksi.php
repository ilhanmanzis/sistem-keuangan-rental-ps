<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Devices;
use App\Models\Members;
use App\Models\Profile;
use App\Models\Makanans;
use App\Models\Minumans;
use App\Models\Transaksis;
use Illuminate\Http\Request;
use App\Models\MemberRewards;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class Transaksi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $transaksis = Transaksis::with(['user', 'shift', 'device', 'member'])
                ->filter(request()->only(['user', 'tanggal']))
                ->orderByDesc('created_at')
                ->paginate(10)
                ->withQueryString();
        } else {
            $transaksis = Transaksis::with(['user', 'shift', 'device', 'member'])
                ->tanggal(request()->only('tanggal'))
                ->where('id_user', $user->id)
                ->orderByDesc('created_at')
                ->paginate(10)
                ->withQueryString();
        }
        $data = [
            'selected' =>  'Pemasukan',
            'page' => 'Pemasukan',
            'title' => 'Pemasukan',
            'transaksis' => $transaksis,
            'karyawans' => User::all()
        ];
        return view('pemasukan/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Pemasukan',
            'page' => 'Pemasukan',
            'title' => 'Tambah Pemasukan',
        ];
        return view('pemasukan/create', $data);
    }

    public function member(string $id) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    public function print(string $id)
    {
        $transaksi = Transaksis::where('id_transaksi', $id)->with(['user', 'shift', 'device', 'member', 'makanans', 'minumans'])->first();


        $profile = Profile::first();
        $data = [
            'selected' =>  'Struk',
            'page' => 'Struk',
            'title' => 'Cetak Struk',
            'transaksi' => $transaksi,
            'profile' => $profile,
            'logo' => public_path('storage/logo/' . $profile['logo'])
        ];

        //dd($data);

        //return view('pemasukan/print', $data);

        $pdf = Pdf::loadView('pemasukan/print', $data);
        $customPaper = [0, 0, 227, 509];
        $pdf->setPaper($customPaper, 'potrait');

        return $pdf->stream('struk.pdf');
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
            'name' => 'required'
        ], [
            'name.required' => 'nama tidak boleh kosong'
        ]);
        if ($request->input('device') === null && $request->input('makanan_id') === null && $request->input('minuman_id') === null) {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        };

        $dataTransaksi = Transaksis::find($id);

        $member = '';
        if ($request->input('kode_member')) {
            $member = Members::find($request->input('kode_member'));
            if (!$member) {
                return redirect()->back()->with('error', 'Data member tidak ditemukan');
            }
        }




        return redirect(route('pemasukan.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
