@extends('layouts.admin')

@section('content')

<div class="row g-3">


    <div class="col-auto">

        <div class="card dashboard-card">

            <div class="card-top"></div>

            <div class="card-body">

                <h6>Total User</h6>

                <h2>{{ $totalUser }}</h2>

            </div>

        </div>

    </div>



    <div class="col-auto">

        <div class="card dashboard-card">

            <div class="card-top"></div>

            <div class="card-body">

                <h6>Pelabuhan</h6>

                <h2>{{ $totalPort }}</h2>

            </div>

        </div>

    </div>



    <div class="col-auto">

        <div class="card dashboard-card">

            <div class="card-top"></div>

            <div class="card-body">

                <h6>Negara</h6>

                <h2>{{ $totalCountry }}</h2>

            </div>

        </div>

    </div>



    <div class="col-auto">

        <div class="card dashboard-card">

            <div class="card-top"></div>

            <div class="card-body">

                <h6>Artikel</h6>

                <h2>{{ $totalArtikel }}</h2>

            </div>

        </div>

    </div>


</div>


@endsection