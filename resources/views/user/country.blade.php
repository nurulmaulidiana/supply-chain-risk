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

        @if($countryData)

        <hr>

        <div class="alert alert-success">

            <h5 class="mb-0">
                🌍 {{ $countryData['name'] }}
            </h5>

        </div>

        <div class="row g-3">

            {{-- GDP --}}
            <div class="col-md-4">

                <div class="card shadow-sm h-100">

                    <div class="card-body text-center">

                        <small class="text-muted">GDP</small>

                        @if($gdp)

                            <h3 class="mt-2 text-primary">
                                {{ number_format($gdp,0,',','.') }}
                            </h3>

                        @else

                            <h3 class="mt-2 text-primary">-</h3>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Inflation --}}
            <div class="col-md-4">

                <div class="card shadow-sm h-100">

                    <div class="card-body text-center">

                        <small class="text-muted">Inflation</small>

                        @if($inflation)

                            <h3 class="mt-2 text-warning">
                                {{ number_format($inflation,2) }} %
                            </h3>

                        @else

                            <h3 class="mt-2 text-warning">-</h3>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Population --}}
            <div class="col-md-4">

                <div class="card shadow-sm h-100">

                    <div class="card-body text-center">

                        <small class="text-muted">Population</small>

                        @if($population)

                            <h3 class="mt-2 text-success">
                                {{ number_format($population,0,',','.') }}
                            </h3>

                        @else

                            <h3 class="mt-2 text-success">-</h3>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Currency --}}
            <div class="col-md-4">

                <div class="card shadow-sm h-100">

                    <div class="card-body text-center">

                        <small class="text-muted">Currency</small>

                        @if($currency)

                            <h3 class="mt-2 text-danger">
                                {{ $currency }}
                            </h3>

                        @else

                            <h3 class="mt-2 text-danger">-</h3>

                        @endif

                    </div>

                </div>

            </div>

            {{-- Weather --}}
            <div class="col-md-4">

                <div class="card shadow-sm h-100">

                    <div class="card-body text-center">

                        <small class="text-muted">Weather</small>

                        <h3 class="mt-2 text-info">
                            Loading...
                        </h3>

                    </div>

                </div>

            </div>

            {{-- Risk Score --}}
            <div class="col-md-4">

                <div class="card shadow-sm h-100">

                    <div class="card-body text-center">

                        <small class="text-muted">Risk Score</small>

                        <h3 class="mt-2 text-secondary">
                            Loading...
                        </h3>

                    </div>

                </div>

            </div>

        </div>

        @else

            <div class="alert alert-info mt-3">

                Silakan pilih negara terlebih dahulu.

            </div>

        @endif

    </div>

</div>

@endsection