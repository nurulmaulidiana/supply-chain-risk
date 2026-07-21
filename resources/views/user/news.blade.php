@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <form method="GET" action="{{ route('user.news') }}">

            <div class="mb-3" style="max-width:300px;">

                <label class="form-label fw-bold">
                    Select Country
                </label>

                <select
                    name="country"
                    class="form-select"
                    onchange="this.form.submit()">

                    <option value="">
                        -- Select Country --
                    </option>

                    @foreach($countries as $country)

                        <option
                            value="{{ $country['name'] }}"
                            {{ $selectedCountry == $country['name'] ? 'selected' : '' }}>

                            {{ $country['name'] }}

                        </option>

                    @endforeach

                </select>

            </div>

        </form>

        <hr>

        @if($selectedCountry)

            @if($articles->count())

                @foreach($articles as $article)

                    <div class="card mb-3">

                        <div class="card-body">

                            @if($article->image)
                                <img
                                    src="{{ $article->image }}"
                                    class="img-fluid rounded mb-3"
                                    style="max-height:250px; width:100%; object-fit:cover;">
                            @endif

                            <h5>{{ $article->title }}</h5>

@if($article->sentiment == 'Positive')

    <span class="badge bg-success mb-2">
        🟢 Positive
    </span>

@elseif($article->sentiment == 'Negative')

    <span class="badge bg-danger mb-2">
        🔴 Negative
    </span>

@else

    <span class="badge bg-secondary mb-2">
        ⚪ Neutral
    </span>

@endif

<p class="text-muted">
    {{ $article->source }}
</p>

                            <p>
                                {{ $article->description }}
                            </p>

                            <a
                                href="{{ $article->url }}"
                                target="_blank"
                                class="btn btn-primary btn-sm">

                                Read More

                            </a>

                        </div>

                    </div>

                @endforeach

            @else

                <div class="alert alert-secondary">
                    No news available.
                </div>

            @endif

        @endif

    </div>

</div>

@endsection