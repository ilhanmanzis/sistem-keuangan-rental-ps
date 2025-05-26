<?php

namespace App\Http\Controllers;

use App\Models\Pengeluarans;
use App\Models\Shifts;
use App\Models\Transaksis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil tahun dari data pertama, atau bisa set manual, misal:
        $tahun = date('Y'); // misal tahun sekarang, atau tahun tertentu

        // Buat list semua bulan dalam setahun, format "YYYY-MM"
        $allMonths = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulan = $m < 10 ? "0$m" : $m;
            $allMonths[] = "$tahun-$bulan";
        }

        // Query pemasukan dan pengeluaran seperti sebelumnya
        $pemasukan = Transaksis::select(
            DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as bulan"),
            DB::raw("SUM(total) as total_pemasukan")
        )->groupBy('bulan')->orderBy('bulan')->get();

        $pengeluaran = Pengeluarans::select(
            DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as bulan"),
            DB::raw("SUM(harga) as total_pengeluaran")
        )->groupBy('bulan')->orderBy('bulan')->get();

        // $bulanList adalah semua bulan dari Januari sampai Desember
        $bulanList = collect($allMonths);

        $chartData = [];

        foreach ($bulanList as $bulan) {
            $chartData[] = [
                'bulan' => $bulan,
                'pemasukan' => (float) ($pemasukan->firstWhere('bulan', $bulan)->total_pemasukan ?? 0),
                'pengeluaran' => (float) ($pengeluaran->firstWhere('bulan', $bulan)->total_pengeluaran ?? 0),
            ];
        }


        // Ambil data pemasukan hari ini dari DB (contoh)
        $pemasukanHariIni = Transaksis::whereDate('created_at', date('Y-m-d'))
            ->sum('total');

        // Hitung persentase peningkatan dibanding hari sebelumnya, misal:
        $pemasukanKemarin = Transaksis::whereDate('created_at', date('Y-m-d', strtotime('-1 day')))
            ->sum('total');

        $persentasePeningkatan = 0;
        if ($pemasukanKemarin == 0) {
            if ($pemasukanHariIni > 0) {
                // Misal: anggap peningkatan tak terbatas (bisa gunakan angka tetap atau tanda khusus)
                $persentasePeningkatan = 100; // atau bisa juga null / 'infinity' tergantung kebutuhan tampilan
            } else {
                $persentasePeningkatan = 0;
            }
        } elseif ($pemasukanHariIni > $pemasukanKemarin) {
            $persentasePeningkatan = (($pemasukanHariIni - $pemasukanKemarin) / $pemasukanKemarin) * 100;
        }
        $persentasePenurunan = 0;

        if ($pemasukanKemarin == 0) {
            // Jika tidak ada pemasukan kemarin, tidak mungkin ada penurunan (karena dibandingkan dengan nol)
            $persentasePenurunan = 0;
        } elseif ($pemasukanKemarin > $pemasukanHariIni) {
            $persentasePenurunan = (($pemasukanKemarin - $pemasukanHariIni) / $pemasukanKemarin) * 100;
        }


        ///
        // Ambil data pengeluaran hari ini dari DB (contoh)
        $pengeluaranHariIni = Pengeluarans::whereDate('created_at', date('Y-m-d'))
            ->sum('harga');

        // Ambil data pengeluaran kemarin dari DB
        $pengeluaranKemarin = Pengeluarans::whereDate('created_at', date('Y-m-d', strtotime('-1 day')))
            ->sum('harga');

        // Hitung persentase peningkatan pengeluaran
        $persentasePengeluaranNaik = 0;

        if ($pengeluaranKemarin == 0) {
            if ($pengeluaranHariIni > 0) {
                $persentasePengeluaranNaik = 100; // Atau bisa 'infinity'
            } else {
                $persentasePengeluaranNaik = 0;
            }
        } elseif ($pengeluaranHariIni > $pengeluaranKemarin) {
            $persentasePengeluaranNaik = (($pengeluaranHariIni - $pengeluaranKemarin) / $pengeluaranKemarin) * 100;
        }

        // Hitung persentase penurunan pengeluaran
        $persentasePengeluaranTurun = 0;

        if ($pengeluaranKemarin == 0) {
            $persentasePengeluaranTurun = 0;
        } elseif ($pengeluaranKemarin > $pengeluaranHariIni) {
            $persentasePengeluaranTurun = (($pengeluaranKemarin - $pengeluaranHariIni) / $pengeluaranKemarin) * 100;
        }


        ///
        // Ambil pemasukan bulan ini
        $pemasukanBulanIni = Transaksis::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total');

        // Ambil pemasukan bulan lalu
        $pemasukanBulanLalu = Transaksis::whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->sum('total');

        // Hitung persentase peningkatan pemasukan
        $persentasePemasukanNaikBulan = 0;
        if ($pemasukanBulanLalu == 0) {
            if ($pemasukanBulanIni > 0) {
                $persentasePemasukanNaikBulan = 100;
            } else {
                $persentasePemasukanNaikBulan = 0;
            }
        } elseif ($pemasukanBulanIni > $pemasukanBulanLalu) {
            $persentasePemasukanNaikBulan = (($pemasukanBulanIni - $pemasukanBulanLalu) / $pemasukanBulanLalu) * 100;
        }

        // Hitung persentase penurunan pemasukan
        $persentasePemasukanTurunBulan = 0;
        if ($pemasukanBulanLalu > $pemasukanBulanIni) {
            $persentasePemasukanTurunBulan = (($pemasukanBulanLalu - $pemasukanBulanIni) / $pemasukanBulanLalu) * 100;
        }



        // Ambil pengeluaran bulan ini
        $pengeluaranBulanIni = Pengeluarans::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('harga');

        // Ambil pengeluaran bulan lalu
        $pengeluaranBulanLalu = Pengeluarans::whereMonth('created_at', date('m', strtotime('-1 month')))
            ->whereYear('created_at', date('Y', strtotime('-1 month')))
            ->sum('harga');

        // Hitung persentase peningkatan pengeluaran
        $persentasePengeluaranNaikBulan = 0;
        if ($pengeluaranBulanLalu == 0) {
            if ($pengeluaranBulanIni > 0) {
                $persentasePengeluaranNaikBulan = 100;
            } else {
                $persentasePengeluaranNaikBulan = 0;
            }
        } elseif ($pengeluaranBulanIni > $pengeluaranBulanLalu) {
            $persentasePengeluaranNaikBulan = (($pengeluaranBulanIni - $pengeluaranBulanLalu) / $pengeluaranBulanLalu) * 100;
        }

        // Hitung persentase penurunan pengeluaran
        $persentasePengeluaranTurunBulan = 0;
        if ($pengeluaranBulanLalu > $pengeluaranBulanIni) {
            $persentasePengeluaranTurunBulan = (($pengeluaranBulanLalu - $pengeluaranBulanIni) / $pengeluaranBulanLalu) * 100;
        }


        $data = [
            'selected' =>  'Dashboard',
            'page' => 'Dashboard',
            'title' => 'Dashboard',
            'chartData' => $chartData,
            'pemasukanKemarin' => $pemasukanKemarin,
            'pemasukanHariIni' => $pemasukanHariIni,
            'persentasePenurunan' => $persentasePenurunan,
            'persentasePeningkatan' => $persentasePeningkatan,
            'persentasePengeluaranTurun' => $persentasePengeluaranTurun,
            'persentasePengeluaranNaik' => $persentasePengeluaranNaik,
            'pengeluaranKemarin' => $pengeluaranKemarin,
            'pengeluaranHariIni' => $pengeluaranHariIni,
            'pemasukanBulanIni' => $pemasukanBulanIni,
            'pemasukanBulanLalu' => $pemasukanBulanLalu,
            'persentasePemasukanNaikBulan' => $persentasePemasukanNaikBulan,
            'persentasePemasukanTurunBulan' => $persentasePemasukanTurunBulan,

            'pengeluaranBulanIni' => $pengeluaranBulanIni,
            'pengeluaranBulanLalu' => $pengeluaranBulanLalu,
            'persentasePengeluaranNaikBulan' => $persentasePengeluaranNaikBulan,
            'persentasePengeluaranTurunBulan' => $persentasePengeluaranTurunBulan,
        ];

        return view('dashboard', $data);
    }

    public function setShift(Request $request)
    {

        $shift = Shifts::where('id_shift', $request->input('id_shift'))->first();

        if ($shift) {
            session([
                'shift' => [
                    'id_shift' => $shift->id_shift,
                    'name' => $shift->name,
                    'jam_mulai' => $shift->jam_mulai,
                    'jam_selesai' => $shift->jam_selesai,
                ]
            ]);
        }

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

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
