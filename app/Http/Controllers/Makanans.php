<?php

namespace App\Http\Controllers;

use App\Models\Makanans as ModelsMakanans;
use Illuminate\Http\Request;

class Makanans extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Makanan',
            'title' => 'Makanan',
            'makanans' => ModelsMakanans::orderBy('updated_at', 'desc')->paginate(10)->withQueryString()
        ];

        return view('makanan/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Makanan',
            'title' => 'Tambah Makanan',
        ];

        return view('makanan/create', $data);
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
        ModelsMakanans::create($data);
        return redirect(route('makanan.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Makanan',
            'title' => 'Edit Makanan',
            'makanan' => ModelsMakanans::find($id)
        ];
        return view('makanan/show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

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
        ModelsMakanans::where('id_makanan', $id)->update($data);
        return redirect(route('makanan.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelsMakanans::where('id_makanan', $id)->delete();
        return redirect(route('makanan.index'))->with('success', 'Data berhasil dihapus');
    }
}
