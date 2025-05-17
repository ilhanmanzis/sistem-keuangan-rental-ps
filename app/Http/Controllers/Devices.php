<?php

namespace App\Http\Controllers;

use App\Models\Devices as ModelsDevices;
use Illuminate\Http\Request;

class Devices extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Device',
            'title' => 'Device',
            'devices' => ModelsDevices::orderBy('updated_at', 'desc')->paginate(10)->withQueryString()
        ];

        return view('device/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Device',
            'title' => 'Tambah Device',
        ];

        return view('device/create', $data);
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
            'harga_perjam' => $request->input('harga'),
        ];
        ModelsDevices::create($data);
        return redirect(route('device.index'))->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = [
            'selected' =>  'Master Data',
            'page' => 'Device',
            'title' => 'Edit Device',
            'device' => ModelsDevices::find($id)
        ];
        return view('device/show', $data);
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
            'harga_perjam' => $request->input('harga'),
        ];
        ModelsDevices::where('id_device', $id)->update($data);
        return redirect(route('device.index'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ModelsDevices::where('id_device', $id)->delete();
        return redirect(route('device.index'))->with('success', 'Data berhasil dihapus');
    }
}
