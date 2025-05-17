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
            'devices' => Devices::all(),
            'makanans' => Makanans::all(),
            'minumans' => Minumans::all(),
        ];
        return view('pemasukan/create', $data);
    }

    public function member(string $id)
    {
        $member = Members::where('kode_member', $id)->first();
        if (!$member) {
            return response()->json(['error' => 'Not found'], 404);
        }

        $bonus = MemberRewards::where('kode_member', $id)->whereNull('tanggal_klaim')->orderBy('id_member_reward')->get();

        return response()->json([
            'name' => $member->name,
            'nomor_telepon' => $member->nomor_telpon,
            'bonus' => $bonus ? $bonus : null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ], [
            'name.required' => 'nama tidak boleh kosong'
        ]);
        if ($request->input('device') === null && $request->input('makanan_id') === null && $request->input('minuman_id') === null) {
            return redirect()->back()->with('error', 'Data gagal ditambahkan');
        };

        $member = '';
        if ($request->input('kode_member')) {
            $member = Members::find($request->input('kode_member'));
            if (!$member) {
                return redirect()->back()->with('error', 'Data member tidak ditemukan');
            }
        }


        $bonus = 0;
        foreach ($request->input('id_member_rewards') ?? [] as $item) {
            $dataBonus = MemberRewards::find($item);
            $bonus += $dataBonus['durasi'];
        }

        $makanan = 0;
        foreach ($request->input('makanan_id') ?? [] as $index => $item) {
            $dataMakanan = Makanans::find($item);

            $makanan += $request->input('makanan_jumlah')[$index] * $dataMakanan['harga'];
        }

        $minuman = 0;
        foreach ($request->input('minuman_id') ?? [] as $index => $item) {
            $dataMinuman = Minumans::find($item);

            $minuman += $request->input('minuman_jumlah')[$index] * $dataMinuman['harga'];
        }

        $device = Devices::find($request->input('device'));
        if ($device) {
            $totalDevice = ($device['harga_perjam'] * $request->input('durasi_jam')) - ($device['harga_perjam'] * $bonus);
        } else {
            $totalDevice = 0;
        }
        //simpan transaksi 
        $transaksi = [
            'id_user' => Auth::id(),
            'id_shift' => session('shift.id_shift'),
            'kode_member' => $request->input('kode_member'),
            'id_device' => $request->input('device'),
            'name' => $request->input('name'),
            'no_telpon' => $request->input('nomor_telepon'),
            'tanggal' => Carbon::now()->toDateString(),
            'durasi_jam' => $request->input('durasi_jam'),
            'bonus_jam' => $bonus,
            'total_device' => $totalDevice,
            'total_makanan' => $makanan,
            'total_minuman' => $minuman,
            'total' => $totalDevice + $makanan + $minuman
        ];

        $query = Transaksis::create($transaksi);

        //tambah data ke tabel pivot makanan
        foreach ($request->input('makanan_id')  ?? [] as $index => $idMakanan) {
            $makanan = Makanans::find($idMakanan);
            if ($makanan) {
                $jumlah = $request->input('makanan_jumlah')[$index] ?? 0;
                $total = $makanan->harga * $jumlah;

                $query->makanans()->attach($makanan->id_makanan, [
                    'jumlah' => $jumlah,
                    'total' => $total,
                ]);
            }
        }

        //tambah data ke tabel pivot minuman
        foreach ($request->input('minuman_id') ?? [] as $index => $idMinuman) {
            $minuman = Minumans::find($idMinuman);
            if ($minuman) {
                $jumlah = $request->input('minuman_jumlah')[$index] ?? 0;
                $total = $minuman->harga * $jumlah;

                $query->minumans()->attach($minuman->id_minuman, [
                    'jumlah' => $jumlah,
                    'total' => $total,
                ]);
            }
        }

        //membuat bonus member
        if ($member && $request->input('device') !== null) {
            $totalTransaksi = Transaksis::where('kode_member', $member['kode_member'])->whereNotNull('id_device')->count();

            // Jika transaksi ini adalah transaksi ke-5, ke-10, dst.
            if ($totalTransaksi > 0 && ($totalTransaksi + 1) % 5 == 0) {
                MemberRewards::create([
                    'kode_member' => $member['kode_member'],
                    'id_transaksi' => null,
                    'durasi' => 2, // misal bonus 1 jam
                    'tanggal_klaim' => null,
                ]);
            }
        }

        if ($request->input('id_member_rewards')) {
            foreach ($request->input('id_member_rewards') ?? [] as $index => $idReward) {
                $data = [
                    'tanggal_klaim' => Carbon::now()->toDateString(),
                    'id_transaksi' => $query['id_transaksi']
                ];
                $dataBonus = MemberRewards::where('id_member_reward', $idReward[$index])->update($data);
            }
        }

        return redirect(route('pemasukan.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksis::where('id_transaksi', $id)->with(['user', 'shift', 'device', 'member', 'makanans', 'minumans'])->first();

        if ($transaksi['kode_member'] === null) {
            $rewardMember = null;
        } else {
            $rewardMember = MemberRewards::where('kode_member', $transaksi->member->kode_member)->where(function ($query) use ($transaksi) {
                $query->whereNull('id_transaksi')->orWhere('id_transaksi', $transaksi->id_transaksi);
            })->get();
        }

        $transaksiMakanans = $transaksi->makanans->map(function ($makanan) {
            return [
                'id_makanan' => $makanan->id_makanan,
                'jumlah' => $makanan->pivot->jumlah,
                'harga' => $makanan->harga,
            ];
        });
        $transaksiMinumans = $transaksi->minumans->map(function ($minuman) {
            return [
                'id_minuman' => $minuman->id_minuman,
                'jumlah' => $minuman->pivot->jumlah,
                'harga' => $minuman->harga,
            ];
        });
        $data = [
            'selected' =>  'Pemasukan',
            'page' => 'Pemasukan',
            'title' => 'Edit Pemasukan',
            'transaksi' => $transaksi,
            'devices' => Devices::all(),
            'makanans' => Makanans::all(),
            'minumans' => Minumans::all(),
            'memberRewards' => $rewardMember,
            'transaksiMinumans' => $transaksiMinumans,
            'transaksiMakanans' => $transaksiMakanans
        ];



        return view('pemasukan/show', $data);
    }

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

        $member = '';
        if ($request->input('kode_member')) {
            $member = Members::find($request->input('kode_member'));
            if (!$member) {
                return redirect()->back()->with('error', 'Data member tidak ditemukan');
            }
        }


        $bonus = 0;
        foreach ($request->input('id_member_rewards') ?? [] as $item) {
            $dataBonus = MemberRewards::find($item);
            $bonus += $dataBonus['durasi'];
        }

        $makanan = 0;
        foreach ($request->input('makanan_id') ?? [] as $index => $item) {
            $dataMakanan = Makanans::find($item);

            $makanan += $request->input('makanan_jumlah')[$index] * $dataMakanan['harga'];
        }

        $minuman = 0;
        foreach ($request->input('minuman_id') ?? [] as $index => $item) {
            $dataMinuman = Minumans::find($item);

            $minuman += $request->input('minuman_jumlah')[$index] * $dataMinuman['harga'];
        }

        $device = Devices::find($request->input('device'));
        if ($device) {
            $totalDevice = ($device['harga_perjam'] * $request->input('durasi_jam')) - ($device['harga_perjam'] * $bonus);
        } else {
            $totalDevice = 0;
        }
        //simpan transaksi 
        $transaksi = [
            'kode_member' => $request->input('kode_member'),
            'id_device' => $request->input('device'),
            'name' => $request->input('name'),
            'no_telpon' => $request->input('nomor_telepon'),
            'tanggal' => Carbon::now()->toDateString(),
            'durasi_jam' => $request->input('durasi_jam'),
            'bonus_jam' => $bonus,
            'total_device' => $totalDevice,
            'total_makanan' => $makanan,
            'total_minuman' => $minuman,
            'total' => $totalDevice + $makanan + $minuman
        ];

        Transaksis::where('id_transaksi', $id)->update($transaksi);

        $transaksi = Transaksis::findOrFail($id);
        // Hapus pivot lama
        $transaksi->makanans()->detach();
        $transaksi->minumans()->detach();

        // Update makanan ke pivot
        foreach ($request->input('makanan_id', []) as $index => $idMakanan) {
            $makanan = Makanans::find($idMakanan);
            if ($makanan) {
                $jumlah = $request->input('makanan_jumlah')[$index] ?? 0;
                $total = $makanan->harga * $jumlah;

                $transaksi->makanans()->attach($makanan->id_makanan, [
                    'jumlah' => $jumlah,
                    'total' => $total,
                ]);
            }
        }

        // Update minuman ke pivot
        foreach ($request->input('minuman_id', []) as $index => $idMinuman) {
            $minuman = Minumans::find($idMinuman);
            if ($minuman) {
                $jumlah = $request->input('minuman_jumlah')[$index] ?? 0;
                $total = $minuman->harga * $jumlah;

                $transaksi->minumans()->attach($minuman->id_minuman, [
                    'jumlah' => $jumlah,
                    'total' => $total,
                ]);
            }
        }

        if ($request->input('id_member_rewards')) {
            foreach ($request->input('id_member_rewards') ?? [] as $index => $idReward) {
                $data = [
                    'tanggal_klaim' => Carbon::now()->toDateString(),
                    'id_transaksi' => $transaksi['id_transaksi']
                ];
                $dataBonus = MemberRewards::where('id_member_reward', $idReward[$index])->update($data);
            }
        }

        return redirect(route('pemasukan.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksis::where('id_transaksi', $id)->first();

        $totalTransaksi = Transaksis::where('kode_member', $transaksi->kode_member)
            ->whereNotNull('id_device')
            ->count();
        if ($totalTransaksi > 0 && $totalTransaksi % 5 === 0) {
            MemberRewards::where('kode_member', $transaksi->kode_member)->where('id_transaksi', $id)->update([
                'id_transaksi' => null,
                'tanggal_klaim' => null
            ]);
        }
        if ($totalTransaksi > 0 && ($totalTransaksi + 1) % 5 === 0) {
            MemberRewards::where('kode_member', $transaksi->kode_member)
                ->orderByDesc('created_at')
                ->first()?->delete();
        }

        // Hapus transaksi
        $transaksi->delete();
        return redirect(route('pemasukan.index'))->with('success', 'Data berhasil dihapus');
    }
}
