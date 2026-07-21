<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    public function index()
    {
        $ports = Port::all();

        return view('admin.ports.index', compact('ports'));
    }

    public function create()
    {
        return view('admin.ports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country' => 'required',
            'status' => 'required',
            'risk_level' => 'required',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'description' => 'nullable'
        ]);

        Port::create([
            'name' => $request->name,
            'country' => $request->country,
            'status' => $request->status,
            'risk_level' => $request->risk_level,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'description' => $request->description
        ]);

        return redirect()
            ->route('ports.index')
            ->with('success', 'Pelabuhan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $port = Port::findOrFail($id);

        return view('admin.ports.edit', compact('port'));
    }

    public function update(Request $request, $id)
    {
        $port = Port::findOrFail($id);

        $port->update($request->all());

        return redirect()
            ->route('ports.index')
            ->with('success', 'Pelabuhan berhasil diubah');
    }

    public function destroy($id)
    {
        Port::findOrFail($id)->delete();

        return redirect()
            ->route('ports.index')
            ->with('success', 'Pelabuhan berhasil dihapus');
    }
}