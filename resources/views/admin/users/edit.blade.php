@extends('layouts.admin')

@section('content')

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h4>Edit User</h4>

        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Kembali
        </a>

    </div>

    <div class="card-body">

        <form action="{{ route('users.update', $user->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ $user->name }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ $user->email }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Password Baru</label>
                <input
                    type="password"
                    name="password"
                    class="form-control">

                <small class="text-muted">
                    Kosongkan jika password tidak ingin diubah.
                </small>
            </div>

            <div class="mb-3">
                <label>Role</label>

                <select name="role" class="form-control">

                    <option value="admin"
                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="user"
                        {{ $user->role == 'user' ? 'selected' : '' }}>
                        User
                    </option>

                </select>

            </div>

            <button class="btn btn-warning">
                Update
            </button>

        </form>

    </div>

</div>

@endsection