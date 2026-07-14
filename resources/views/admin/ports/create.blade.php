@extends('layouts.admin')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h4 class="mb-0">Tambah Pelabuhan</h4>

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

        <form action="{{ route('ports.store') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">Nama Pelabuhan</label>

                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">Negara</label>

                <input
                    type="text"
                    name="country"
                    class="form-control"
                    value="{{ old('country') }}"
                    required>

            </div>

            <div class="mb-3">

                <label class="form-label">Status</label>

                <select
                    name="status"
                    class="form-select">

                    <option value="Normal">Normal</option>

                    <option value="Padat">Padat</option>

                    <option value="Terganggu">Terganggu</option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">Risk Level</label>

                <select
                    name="risk_level"
                    class="form-select">

                    <option value="Rendah">Rendah</option>

                    <option value="Sedang">Sedang</option>

                    <option value="Tinggi">Tinggi</option>

                </select>

            </div>

            <div class="mb-3">

                <label class="form-label">Deskripsi</label>

                <textarea
                    name="description"
                    rows="4"
                    class="form-control">{{ old('description') }}</textarea>

            </div>

            <button
                class="btn text-white"
                style="background:#7A1F1F">

                Simpan

            </button>

            <a
                href="{{ route('ports.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </form>

    </div>

</div>

@endsection