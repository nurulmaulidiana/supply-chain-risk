@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h4 class="mb-0">
            ⭐ Favorite Monitoring List
        </h4>
    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        @if($watchlists->count())

            @foreach($watchlists as $item)

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h4 class="mb-3">
                        🌍 {{ $item->country->name }}
                    </h4>

                    <div class="row">

                        <div class="col-md-3">

                            <small class="text-muted">
                                GDP
                            </small>

                            <h6 class="fw-bold">
                                {{ $item->gdp ? number_format($item->gdp,0,',','.') : '-' }}
                            </h6>

                        </div>

                        <div class="col-md-2">

                            <small class="text-muted">
                                Inflation
                            </small>

                            <h6 class="fw-bold">
                                {{ $item->inflation ? number_format($item->inflation,2) . ' %' : '-' }}
                            </h6>

                        </div>

                        <div class="col-md-2">

                            <small class="text-muted">
                                Weather
                            </small>

                            <h6 class="fw-bold">
                                {{ $item->weather }} °C
                            </h6>

                        </div>

                        <div class="col-md-2">

                            <small class="text-muted">
                                Currency
                            </small>

                            <h6 class="fw-bold">
                                {{ $item->currency }}
                            </h6>

                        </div>

                        <div class="col-md-3 text-end">

                            <a
                                href="{{ route('user.country',['country'=>$item->country->id]) }}"
                                class="btn btn-primary btn-sm">

                                View Dashboard

                            </a>

                            <form
                                action="{{ route('watchlist.destroy',$item->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        @else

            <div class="alert alert-info">

                No favorite countries yet.

            </div>

        @endif

    </div>

</div>

@endsection