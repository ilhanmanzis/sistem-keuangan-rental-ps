<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Members as ModelsMembers;
use App\Models\Profile;
use Barryvdh\DomPDF\Facade\Pdf;

class Members extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Member',
            'title' => 'Member',
            'members' => ModelsMembers::filter(request()->only('name'))->orderBy('updated_at', 'desc')->paginate(10)->withQueryString()
        ];

        return view('member/index', $data);
    }

    public function print(string $id)
    {
        $profile = Profile::first();
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Member',
            'title' => 'Print Member',
            'member' => ModelsMembers::find($id),
            'logo' => public_path('storage/logo/' . $profile['logo'])
        ];

        //$pdf = Pdf::loadView('pdf.member_card', compact('member'))->setPaper([0, 0, 250, 150], 'landscape');
        $pdf = Pdf::loadView('member/print', $data);
        $customPaper = [0, 0, 200, 250];
        $pdf->setPaper($customPaper, 'landscape');

        return $pdf->stream('member.pdf');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Member',
            'title' => 'Tambah Member',
        ];

        return view('member/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nomor_telpon' => 'required|digits_between:10,14',
            'kode_member' => 'nullable|string|size:6|unique:members,kode_member',
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'nomor_telpon.required' => 'nomor telpon tidak boleh kosong',
            'nomor_telpon.digits_between' => 'nomor telpon harus berisi 10-14 digit',

        ]);

        if (empty($request->input('kode_member'))) {
            do {
                $kode = Str::upper(Str::random(6));
            } while (ModelsMembers::where('kode_member', $kode)->exists());
        } else {
            $kode = $request->input('kode_member');
        }

        $data = [
            'kode_member' => $kode,
            'name' => $request->input('name'),
            'nomor_telpon' => $request->input('nomor_telpon'),
        ];
        ModelsMembers::create($data);
        return redirect(route('member.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Member',
            'title' => 'Edit Member',
            'member' => ModelsMembers::find($id)
        ];
        return view('member/show', $data);
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
            'name' => 'required',
            'nomor_telpon' => 'required|digits_between:10,14',
            'kode_member' => 'nullable|string|size:6|unique:members,kode_member',
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'nomor_telpon.required' => 'nomor telpon tidak boleh kosong',
            'nomor_telpon.digits_between' => 'nomor telpon harus berisi 10-14 digit',

        ]);

        $data = [
            'name' => $request->input('name'),
            'nomor_telpon' => $request->input('nomor_telpon'),
        ];
        ModelsMembers::where('kode_member', $id)->update($data);
        return redirect(route('member.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelsMembers::where('kode_member', $id)->delete();
        return redirect(route('member.index'))->with('success', 'Data berhasil dihapus');
    }
}
