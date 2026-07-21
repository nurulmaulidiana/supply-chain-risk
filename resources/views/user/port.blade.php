@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <div class="row mb-4">

            <div class="col-md-6">

                <label class="form-label fw-bold">
                    Search Country
                </label>

                <select id="countrySelect" class="form-select">

                    <option value="">
                        All Countries
                    </option>

                    @foreach($ports->unique('country') as $port)

                        <option value="{{ $port->country }}">
                            {{ $port->country }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-6">

                <label class="form-label fw-bold">
                    Search Port
                </label>

                <select id="portSelect" class="form-select">

                    <option value="">
                        Select Port
                    </option>

                    @foreach($ports as $port)

    <option
        value="{{ $port->id }}"
        data-country="{{ $port->country }}">
        {{ $port->name }}
    </option>

@endforeach

                </select>

            </div>

        </div>

        <div id="map"
             style="height:320px;border-radius:10px;">
        </div>

        <hr>

        <div class="card shadow-sm">

            <div class="card-header bg-white">

                <strong>
                    ⚓ Port Information
                </strong>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="30%">Port Name</th>
                        <td id="infoName">-</td>
                    </tr>

                    <tr>
                        <th>Country</th>
                        <td id="infoCountry">-</td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td id="infoStatus">-</td>
                    </tr>

                    <tr>
                        <th>Risk Level</th>
                        <td id="infoRisk">-</td>
                    </tr>

                    <tr>
                        <th>Description</th>
                        <td id="infoDescription">-</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@push('scripts')

<script>

    const map = L.map('map').setView([10, 105], 4);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

const markers = {};

@foreach($ports as $port)

@if(!is_null($port->latitude) && !is_null($port->longitude))

const marker{{ $port->id }} = L.marker([
    {{ $port->latitude }},
    {{ $port->longitude }}
]);

marker{{ $port->id }}.bindPopup("<b>{{ $port->name }}</b>");

marker{{ $port->id }}.country = "{{ $port->country }}";

marker{{ $port->id }}.info = {
    name: "{{ $port->name }}",
    country: "{{ $port->country }}",
    status: "{{ $port->status }}",
    risk: "{{ $port->risk_level }}",
    description: "{{ $port->description }}"
};

marker{{ $port->id }}.on('click', function(){

    document.getElementById('infoName').innerHTML = this.info.name;
    document.getElementById('infoCountry').innerHTML = this.info.country;
    document.getElementById('infoStatus').innerHTML = this.info.status;
    document.getElementById('infoRisk').innerHTML = this.info.risk;
    document.getElementById('infoDescription').innerHTML = this.info.description;

});

markers[{{ $port->id }}] = marker{{ $port->id }};

@endif

@endforeach

Object.values(markers).forEach(marker => {
    marker.addTo(map);
});

const infoName = document.getElementById('infoName');
const infoCountry = document.getElementById('infoCountry');
const infoStatus = document.getElementById('infoStatus');
const infoRisk = document.getElementById('infoRisk');
const infoDescription = document.getElementById('infoDescription');

function showInfo(info){
    infoName.innerHTML = info.name;
    infoCountry.innerHTML = info.country;
    infoStatus.innerHTML = info.status;
    infoRisk.innerHTML = info.risk;
    infoDescription.innerHTML = info.description;
}

function clearInfo(message){
    infoName.innerHTML = '-';
    infoCountry.innerHTML = '-';
    infoStatus.innerHTML = '-';
    infoRisk.innerHTML = '-';
    infoDescription.innerHTML = message || '-';
}

document.getElementById('portSelect').addEventListener('change', function(){

    const id = this.value;
    const marker = markers[id];

    if(id && marker){

        map.setView(marker.getLatLng(), 8);
        marker.openPopup();
        showInfo(marker.info);

    } else if(id && !marker){

        // Port dipilih tapi tidak punya koordinat (latitude/longitude kosong di database)
        map.closePopup();
        map.setView([10, 105], 4);
        clearInfo('Koordinat lokasi belum tersedia untuk pelabuhan ini.');

    } else {

        map.closePopup();
        map.setView([10, 105], 4);
        clearInfo();

    }

});


const countrySelect = document.getElementById('countrySelect');
const portSelect = document.getElementById('portSelect');

countrySelect.addEventListener('change', function () {

    const country = this.value;

    Object.values(markers).forEach(marker => {
        map.removeLayer(marker);
    });

    let first = null;
    let firstId = null;

    Array.from(portSelect.options).forEach(option => {

        if(option.value === ""){
            option.hidden = false;
            return;
        }

        // Pakai data-country dari <option>, bukan marker.country,
        // karena marker bisa undefined kalau port tidak punya koordinat
        const optCountry = option.dataset.country;
        const marker = markers[option.value];

        if(country === "" || optCountry === country){

            option.hidden = false;

            if(marker){

                marker.addTo(map);

                if(first === null){
                    first = marker;
                    firstId = option.value;
                }

            }

        } else {

            option.hidden = true;

        }

    });

    if(first){

        map.setView(first.getLatLng(), 8);
        first.openPopup();
        portSelect.value = firstId;
        showInfo(first.info);

    } else {

        portSelect.value = "";
        map.setView([10, 105], 4);
        clearInfo();

    }

});

</script>

@endpush

@endsection