@extends('layouts.user')

@section('content')

<div class="card shadow-sm">
    <div class="card-body p-3">

        <form method="GET" action="{{ route('user.risk-scoring') }}">

            <div class="mb-3" style="max-width:320px;">

                <label class="fw-bold mb-1">
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
                            {{ ($selectedCountry ?? '') == $country['name'] ? 'selected' : '' }}>

                            {{ $country['name'] }}

                        </option>

                    @endforeach

                </select>

            </div>

        </form>

        <hr class="my-3">

        <div class="row g-3">

            <div class="col-md-3">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body py-3 px-2">

                        <h5 class="mb-2">Weather</h5>

                        <h2 class="mb-1">
                            {{ $selectedCountry ? $weatherScore : '--' }}
                        </h2>

                        <small class="text-secondary">
                            @if($selectedCountry)
                                {{ number_format($temperature, 1) }} °C
                            @else
                                Belum dipilih
                            @endif
                        </small>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body py-3 px-2">

                        <h5 class="mb-2">Inflation</h5>

                        <h2 class="mb-1">
                            {{ $selectedCountry ? $inflationScore : '--' }}
                        </h2>

                        <small class="text-secondary">
                            @if($selectedCountry)
                                {{ number_format($inflation, 2) }} %
                            @else
                                Belum dipilih
                            @endif
                        </small>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body py-3 px-2">

                        <h5 class="mb-2">Currency</h5>

                        <h2 class="mb-1">
                            {{ $selectedCountry ? $currencyScore : '--' }}
                        </h2>

                        <small class="text-secondary">
                            {{ $selectedCountry ? ucfirst($currency) : 'Belum dipilih' }}
                        </small>

                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body py-3 px-2">

                        <h5 class="mb-2">News</h5>

                        <h2 class="mb-1">
                            {{ $selectedCountry ? $newsScore : '--' }}
                        </h2>

                        <small class="text-secondary">
                            {{ $selectedCountry ? ucfirst($news) : 'Belum dipilih' }}
                        </small>

                    </div>
                </div>
            </div>

        </div>

        @php
            $bg = "secondary text-white";

            if ($selectedCountry) {
                if ($riskLevel == "Medium Risk") {
                    $bg = "warning text-dark";
                } elseif ($riskLevel == "High Risk") {
                    $bg = "danger text-white";
                } else {
                    $bg = "success text-white";
                }
            }
        @endphp

        <div class="card bg-{{ $bg }} shadow text-center mt-3">

            <div class="card-body py-3">

                <h1 class="fw-bold mb-1">
                    {{ $selectedCountry ? round($totalScore) : '--' }}
                </h1>

                <h5 class="mb-1">Total Risk Score</h5>

                <h3 class="mb-0">
                    {{ $selectedCountry ? $riskLevel : 'Belum dihitung' }}
                </h3>

            </div>

        </div>

    </div>

</div>

@endsection