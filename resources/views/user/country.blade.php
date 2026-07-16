@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <form method="GET" action="{{ route('user.country') }}">

            <div class="mb-4">
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

        <div class="alert alert-success">
            <h5 class="mb-0">
                🌍 {{ $countryData['name'] }}
            </h5>
        </div>

        <div class="row">

            <!-- CARD KIRI -->
            <div class="col-lg-3">

                <!-- GDP -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">GDP</small>

                        <h6 class="mt-2 fw-bold">
                            {{ $gdp ? number_format($gdp,0,',','.') : '-' }}
                        </h6>

                    </div>
                </div>

                <!-- Inflation -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">Inflation</small>

                        <h6 class="mt-2 fw-bold">
                            {{ $inflation ? number_format($inflation,2).' %' : '-' }}
                        </h6>

                    </div>
                </div>

                <!-- Population -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">Population</small>

                        <h6 class="mt-2 fw-bold">
                            {{ $population ? number_format($population,0,',','.') : '-' }}
                        </h6>

                    </div>
                </div>

                <!-- Currency -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">Currency</small>
                        <h6 class="mt-2 fw-bold">
                             Coming Soon
                            </h6>

                    </div>
                </div>

                <!-- Weather -->
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">Weather</small>

                        <h6 class="mt-2 fw-bold">

                            @if($weather)
                                ⛅ {{ $weather['temperature_2m'] }} °C
                            @else
                                -
                            @endif

                        </h6>

                    </div>
                </div>

                <!-- Risk -->
                <div class="card shadow-sm">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">Risk Score</small>

                        <h6 class="mt-2 fw-bold text-danger">
                            Coming Soon
                        </h6>

                    </div>
                </div>

            </div>

            <!-- KANAN -->
            <div class="col-lg-9">

                <div class="card shadow-sm">

                    <div class="card-header bg-white">

                        <strong>Country Overview</strong>

                    </div>

                    <div class="card-body">

                        <h3>{{ $countryData['name'] }}</h3>

                        <p class="text-muted">

                            Dashboard monitoring negara yang dipilih.

                        </p>

                        <hr>

                        <div id="map"
                        style="height:520px;border-radius:10px;">
                    </div>
            @if($coordinate)
            
            <script>
            document.addEventListener("DOMContentLoaded", function () {
        var map = L.map('map').setView(
            [{{ $coordinate['latitude'] }}, {{ $coordinate['longitude'] }}],
        4
    );

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution: '&copy; OpenStreetMap'
        }
    ).addTo(map);

    L.marker([
        {{ $coordinate['latitude'] }},
        {{ $coordinate['longitude'] }}
    ])
    .addTo(map)
    .bindPopup("{{ $countryData['name'] }}")
    .openPopup();

});

</script>

@endif

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