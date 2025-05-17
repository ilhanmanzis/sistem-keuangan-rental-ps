<?php

namespace App\Http\Controllers;

use App\Models\Minumans as ModelsMinumans;
use Illuminate\Http\Request;

class Minumans extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Minuman',
            'title' => 'Minuman',
            'minumans' => ModelsMinumans::orderBy('updated_at', 'desc')->paginate(20)->withQueryString()
        ];

        return view('minuman/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Minuman',
            'title' => 'Tambah Minuman',
        ];

        return view('minuman/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'harga' => 'required|integer',
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'harga.required' => 'harga tidak boleh kosong',
            'harga.integer' => 'harga harus berupa angka',
        ]);

        $data = [
            'name' => $request->input('name'),
            'harga' => $request->input('harga'),
        ];
        ModelsMinumans::create($data);
        return redirect(route('minuman.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Minuman',
            'title' => 'Edit Minuman',
            'minuman' => ModelsMinumans::find($id)
        ];
        return view('minuman/show', $data);
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
            'harga' => 'required|integer',
        ], [
            'name.required' => 'nama tidak boleh kosong',
            'harga.required' => 'harga tidak boleh kosong',
            'harga.integer' => 'harga harus berupa angka',
        ]);

        $data = [
            'name' => $request->input('name'),
            'harga' => $request->input('harga'),
        ];
        ModelsMinumans::where('id_minuman', $id)->update($data);
        return redirect(route('minuman.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelsMinumans::where('id_minuman', $id)->delete();
        return redirect(route('minuman.index'))->with('success', 'Data berhasil dihapus');
    }
}
