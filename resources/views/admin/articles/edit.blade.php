@extends('layouts.admin')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">
        <h4>Edit Artikel</h4>
    </div>

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('articles.update', $article->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul</label>
                <input
                    type="text"
                    name="title"
                    class="form-control"
                    value="{{ old('title', $article->title) }}"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input
                    type="text"
                    name="category"
                    class="form-control"
                    value="{{ old('category', $article->category) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Isi Artikel</label>
                <textarea
                    name="content"
                    rows="8"
                    class="form-control"
                    required>{{ old('content', $article->content) }}</textarea>
            </div>

            <button class="btn text-white" style="background:#7A1F1F">
                Update
            </button>

            <a href="{{ route('articles.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection