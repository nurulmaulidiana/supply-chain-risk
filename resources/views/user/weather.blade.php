@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <form method="GET" action="{{ route('user.weather') }}">

            <div class="mb-3" style="max-width:300px;">

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

        <div class="row">

            <!-- CARD KIRI -->
            <div class="col-lg-3">

                <div class="card shadow-sm mb-2">
                    <div class="card-body text-center py-2">

                        <small class="text-muted">Temperature</small>

                        <h5 class="mt-1 fw-bold">

                            {{ $weather['temperature_2m'] ?? '-' }} °C

                        </h5>

                    </div>
                </div>

                <div class="card shadow-sm mb-2">
                    <div class="card-body text-center py-2">

                        <small class="text-muted">Wind Speed</small>

                        <h5 class="mt-1 fw-bold">

                            {{ $weather['wind_speed_10m'] ?? '-' }} km/h

                        </h5>

                    </div>
                </div>

                <div class="card shadow-sm mb-2">
                    <div class="card-body text-center py-2">

                        <small class="text-muted">Rain</small>

                        <h5 class="mt-1 fw-bold">

                            {{ $weather['rain'] ?? 0 }} mm

                        </h5>

                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body text-center py-2">

                        <small class="text-muted">
                            Weather Status
                        </small>

                        <h5 class="mt-1 fw-bold text-success">

                            Live Data

                        </h5>

                    </div>
                </div>

            </div>

            <!-- BAGIAN KANAN -->

            <div class="col-lg-9">

                <div class="card shadow-sm">

                    <div class="card-header bg-white">

                        <strong>Weather Overview</strong>

                    </div>

                    <div class="card-body">

                        <h3>{{ $countryData['name'] }}</h3>

                        <p class="text-muted">

                            Live weather monitoring menggunakan Open-Meteo API.

                        </p>

                        <hr>

                        <div id="map"
                             style="height:360px;border-radius:10px;">
                        </div>

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

@if($coordinate)

<script>

document.addEventListener("DOMContentLoaded", function(){

    var map = L.map('map').setView(
        [{{ $coordinate['latitude'] }}, {{ $coordinate['longitude'] }}],
        5
    );

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        {
            attribution:'© OpenStreetMap'
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

@endsection