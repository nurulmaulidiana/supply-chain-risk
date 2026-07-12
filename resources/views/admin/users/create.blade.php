@extends('layouts.admin')

@section('content')

<h4 class="mb-4">Tambah User</h4>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <form action="{{ route('users.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Role</label>

                <select name="role" class="form-control">

                    <option value="admin">Admin</option>

                    <option value="user">User</option>

                </select>

            </div>

            <button class="btn text-white" style="background:#7A1F1F">
                Simpan
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection