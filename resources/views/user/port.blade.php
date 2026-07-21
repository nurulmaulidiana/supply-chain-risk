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

@if($port->latitude && $port->longitude)

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

document.getElementById('portSelect').addEventListener('change', function(){

    const id = this.value;

    if(id && markers[id]){

        map.setView(markers[id].getLatLng(),8);

        markers[id].openPopup();

        document.getElementById('infoName').innerHTML = markers[id].info.name;
        document.getElementById('infoCountry').innerHTML = markers[id].info.country;
        document.getElementById('infoStatus').innerHTML = markers[id].info.status;
        document.getElementById('infoRisk').innerHTML = markers[id].info.risk;
        document.getElementById('infoDescription').innerHTML = markers[id].info.description;

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

        if(option.value == ""){

            option.hidden = false;
            return;

        }

        const marker = markers[option.value];

        if(country == "" || marker.country === country){

            option.hidden = false;

            marker.addTo(map);

            if(first === null){

                first = marker;
                firstId = option.value;

            }

        }else{

            option.hidden = true;

        }

    });

    if(first){

        map.setView(first.getLatLng(),8);

        first.openPopup();

        portSelect.value = firstId;

        document.getElementById('infoName').innerHTML = first.info.name;
        document.getElementById('infoCountry').innerHTML = first.info.country;
        document.getElementById('infoStatus').innerHTML = first.info.status;
        document.getElementById('infoRisk').innerHTML = first.info.risk;
        document.getElementById('infoDescription').innerHTML = first.info.description;

    }else{

        portSelect.value = "";

        map.setView([10,105],4);

    }

});

</script>

@endpush

@endsection