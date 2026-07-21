@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Dataset Pelabuhan</h4>
    <a href="{{ route('ports.create') }}" class="btn btn-sm text-white" style="background:#7A1F1F;">
        + Tambah Pelabuhan
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama Pelabuhan</th>
                    <th>Negara</th>
                    <th>Status</th>
                    <th>Risk</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th width="200">Deskripsi</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($ports as $port)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $port->name }}</td>
                    <td>{{ $port->country }}</td>
                    <td>
                        @if($port->status=='Normal')
                            <span class="badge bg-success">{{ $port->status }}</span>
                        @elseif($port->status=='Padat')
                            <span class="badge bg-warning text-dark">{{ $port->status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $port->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if($port->risk_level=='Rendah')
                            <span class="badge bg-success">{{ $port->risk_level }}</span>
                        @elseif($port->risk_level=='Sedang')
                            <span class="badge bg-warning text-dark">{{ $port->risk_level }}</span>
                        @else
                            <span class="badge bg-danger">{{ $port->risk_level }}</span>
                        @endif
                    </td>
                    <td>{{ $port->latitude ?? '-' }}</td>
                    <td>{{ $port->longitude ?? '-' }}</td>
                    <td>{{ $port->description }}</td>
                    <td>
                        <a href="{{ route('ports.edit', $port->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('ports.destroy', $port->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus data?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Belum ada data pelabuhan.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection