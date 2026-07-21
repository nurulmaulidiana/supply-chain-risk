@extends('layouts.admin')

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <h4 class="mb-0">Edit Pelabuhan</h4>
    </div>

    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ports.update', $port->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Pelabuhan</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    value="{{ old('name', $port->name) }}" 
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Negara</label>
                <input 
                    type="text" 
                    name="country" 
                    class="form-control" 
                    value="{{ old('country', $port->country) }}" 
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Normal" {{ old('status', $port->status) == 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Padat" {{ old('status', $port->status) == 'Padat' ? 'selected' : '' }}>Padat</option>
                    <option value="Terganggu" {{ old('status', $port->status) == 'Terganggu' ? 'selected' : '' }}>Terganggu</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Risk Level</label>
                <select name="risk_level" class="form-select">
                    <option value="Rendah" {{ old('risk_level', $port->risk_level) == 'Rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="Sedang" {{ old('risk_level', $port->risk_level) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="Tinggi" {{ old('risk_level', $port->risk_level) == 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Latitude</label>
                    <input 
                        type="number" 
                        step="any" 
                        name="latitude" 
                        class="form-control" 
                        value="{{ old('latitude', $port->latitude ?? '') }}" 
                        placeholder="Contoh: -7.2058">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Longitude</label>
                    <input 
                        type="number" 
                        step="any" 
                        name="longitude" 
                        class="form-control" 
                        value="{{ old('longitude', $port->longitude ?? '') }}" 
                        placeholder="Contoh: 112.7341">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea 
                    name="description" 
                    rows="4" 
                    class="form-control">{{ old('description', $port->description) }}</textarea>
            </div>

            <button type="submit" class="btn text-white" style="background:#7A1F1F">
                Update
            </button>

            <a href="{{ route('ports.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </form>
    </div>
</div>

@endsection