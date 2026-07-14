@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-header bg-white">
        <h4 class="mb-0">🌍 Global Country Dashboard</h4>
    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('user.country') }}">

            <div class="mb-3">

                <label class="form-label fw-bold">
                    Pilih Negara
                </label>

                <select
                    name="country"
                    class="form-select"
                    onchange="this.form.submit()">

                    <option value="">-- Pilih Negara --</option>

                    @foreach($countries as $country)

                        <option
                            value="{{ $country['id'] }}"
                            {{ $selectedCountry == $country['id'] ? 'selected' : '' }}>

                            {{ $country['name'] }}

                        </option>

                    @endforeach

                </select>

            </div>

        </form>

        <hr>

        @if($countryData)

            <div class="alert alert-success">

                <h5 class="mb-0">

                    🌍 {{ $countryData['name'] }}

                </h5>

            </div>

            <div class="row mt-4">

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">GDP</small>
                <h4 class="mt-2">$1.39 T</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Inflation</small>
                <h4 class="mt-2">2.8%</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Population</small>
                <h4 class="mt-2">281 M</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Currency</small>
                <h4 class="mt-2">IDR</h4>
            </div>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Weather</small>
                <h4 class="mt-2">30°C</h4>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Risk Level</small>
                <h4 class="text-success mt-2">Low</h4>
            </div>
        </div>
    </div>

</div>

        @else

            <div class="alert alert-info">

                Silakan pilih negara terlebih dahulu.

            </div>

        @endif

    </div>

</div>

@endsection