@extends('layouts.user')

@section('content')

<div class="card">
    <div class="card-body">

        <h3>⚓ Port Location</h3>

        @foreach($ports as $port)

            <p>{{ $port->name }}</p>

        @endforeach

    </div>
</div>

@endsection