@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between mb-3">

    <h4>Artikel Analisis</h4>

    <a href="{{ route('articles.create') }}"
       class="btn text-white"
       style="background:#7A1F1F">
        Tambah Artikel
    </a>

</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow-sm border-0">

    <div class="card-body">

        <table class="table table-bordered">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th width="170">Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($articles as $article)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $article->title }}</td>

                    <td>{{ $article->category }}</td>

                    <td>

                        <a href="{{ route('articles.edit',$article->id) }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('articles.destroy',$article->id) }}"
                              method="POST"
                              class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Hapus artikel?')">

                                Hapus

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">
                        Belum ada artikel.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection