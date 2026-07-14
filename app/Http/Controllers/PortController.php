<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    // Menampilkan semua data pelabuhan
    public function index()
    {
        $ports = Port::all();

        return view('admin.ports.index', compact('ports'));
    }

    // Form tambah pelabuhan
    public function create()
    {
        return view('admin.ports.create');
    }

    // Simpan pelabuhan
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'status' => 'required',
            'risk_level' => 'required',
            'description' => 'nullable'
        ]);

        Port::create($request->all());

        return redirect()
            ->route('ports.index')
            ->with('success','Data pelabuhan berhasil ditambahkan.');
    }

    // Detail (belum dipakai)
    public function show(Port $port)
    {

    }

    // Form edit
    public function edit($id)
    {
        $port = Port::findOrFail($id);

        return view('admin.ports.edit', compact('port'));
    }

    // Update
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'status' => 'required',
            'risk_level' => 'required',
            'description' => 'nullable'
        ]);

        $port = Port::findOrFail($id);

        $port->update($request->all());

        return redirect()
            ->route('ports.index')
            ->with('success','Data pelabuhan berhasil diupdate.');
    }

    // Hapus
    public function destroy($id)
    {
        $port = Port::findOrFail($id);

        $port->delete();

        return redirect()
            ->route('ports.index')
            ->with('success','Data pelabuhan berhasil dihapus.');
    }
}