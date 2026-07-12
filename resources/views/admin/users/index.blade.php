@extends('layouts.admin')

@section('content')

@if(session('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">

    {{ session('success') }}

    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

</div>

@endif

<div class="d-flex justify-content-between align-items-center mb-4">

    <h4 class="mb-0">Kelola User</h4>

    <a href="{{ route('users.create') }}"
       class="btn btn-sm text-white"
       style="background:#7A1F1F;">

        + Tambah User

    </a>

</div>

<div class="card shadow-sm border-0">

    <div class="card-body">

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-light">

                <tr>

                    <th width="60">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th width="120">Role</th>
                    <th width="180">Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ ucfirst($user->role) }}</td>

                    <td>

                        <a href="{{ route('users.edit', $user->id) }}"
                           class="btn btn-warning btn-sm">

                            Edit

                        </a>

                        <form action="{{ route('users.destroy', $user->id) }}"
                              method="POST"
                              style="display:inline;">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">

                        Belum ada data user.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection