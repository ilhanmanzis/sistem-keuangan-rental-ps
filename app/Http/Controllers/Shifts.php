<?php

namespace App\Http\Controllers;

use App\Models\Shifts as ModelsShifts;
use Illuminate\Http\Request;

class Shifts extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Shift',
            'title' => 'Shift',
            'shifts' => ModelsShifts::paginate(10)->withQueryString()
        ];

        return view('shift/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Shift',
            'title' => 'Tambah Shift',
        ];

        return view('shift/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'jam_mulai.required' => 'jam mulai tidak boleh kosong',
            'jam_selesai.required' => 'jam selesai tidak boleh kosong',
        ]);

        $data = [
            'name' => $request->input('name'),
            'jam_mulai' => $request->input('jam_mulai'),
            'jam_selesai' => $request->input('jam_selesai'),
        ];
        ModelsShifts::create($data);
        return redirect(route('shift.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Shift',
            'title' => 'Edit Shift',
            'shift' => ModelsShifts::find($id)
        ];
        return view('shift/show', $data);
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
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'jam_mulai.required' => 'jam mulai tidak boleh kosong',
            'jam_selesai.required' => 'jam selesai tidak boleh kosong',
        ]);

        $data = [
            'name' => $request->input('name'),
            'jam_mulai' => $request->input('jam_mulai'),
            'jam_selesai' => $request->input('jam_selesai'),
        ];
        ModelsShifts::where('id_shift', $id)->update($data);
        return redirect(route('shift.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelsShifts::where('id_shift', $id)->delete();
        return redirect(route('shift.index'))->with('success', 'Data berhasil dihapus');
    }
}
