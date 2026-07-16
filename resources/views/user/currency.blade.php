@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">
        <h5 class="mb-0">Exchange Rate</h5>
    </div>

    <div class="card-body">

        @if($rates)

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>Currency</th>
                        <th>Rate (Base USD)</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($rates as $code => $rate)

                    <tr>
                        <td>{{ $code }}</td>
                        <td>{{ $rate }}</td>
                    </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="alert alert-danger">
                Failed to load exchange rates.
            </div>

        @endif

    </div>

</div>

@endsection