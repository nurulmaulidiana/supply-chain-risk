@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <!-- Select Country -->
        <div class="mb-4">

            <label class="form-label fw-bold">
                Select Country
            </label>

            <form method="GET" action="{{ route('user.currency') }}">

                <div style="max-width:300px;">

                    <select
                        name="country"
                        class="form-select"
                        onchange="this.form.submit()">

                        <option value="">-- Select Country --</option>

                        @foreach($countries as $item)

                            <option
                                value="{{ $item['name'] }}"
                                {{ $selected == $item['name'] ? 'selected' : '' }}>

                                {{ $item['name'] }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </form>

        </div>

        <!-- Currency Information -->
        <div class="row">

            <div class="col-lg-6">

                @if($country)

                <table class="table table-bordered">

                    <tr>
                        <th width="35%">Country</th>
                        <td>{{ $country['names']['common'] }}</td>
                    </tr>

                    <tr>
                        <th>Currency</th>
                        <td>
                            {{ $country['currencies'][0]['name'] }}
                            ({{ $currencyCode }})
                        </td>
                    </tr>

                    <tr>
                        <th>Exchange Rate</th>
                        <td>
                            1 USD =
                            {{ number_format($rates[$currencyCode] ?? 0,2) }}
                            {{ $currencyCode }}
                        </td>
                    </tr>

                    <tr>
                        <th>Last Updated</th>
                        <td>{{ now()->format('d F Y') }}</td>
                    </tr>

                </table>

                @else

                <div class="alert alert-secondary mb-0">
                    Please select a country to view currency information.
                </div>

                @endif

            </div>

        </div>

        <!-- Currency Trend -->
        <div class="row mt-4">

            <div class="col-lg-8">

                <div class="card shadow-sm">

                    <div class="card-header bg-white">
                        <strong>Currency Trend</strong>
                    </div>

                    <div class="card-body">

                        @if($country)

                            <canvas id="currencyChart" height="100"></canvas>

                        @else

                            <div class="text-center text-muted py-5">

                                Please select a country to display currency trend.

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

@if($country)

<script>

const ctx = document.getElementById('currencyChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [
            'EUR',
            'GBP',
            'JPY',
            'MYR',
            'SGD',
            '{{ $currencyCode }}'
        ],

        datasets: [{

            label: 'Exchange Rate (Base USD)',

            data: [

                {{ $rates['EUR'] ?? 0 }},
                {{ $rates['GBP'] ?? 0 }},
                {{ $rates['JPY'] ?? 0 }},
                {{ $rates['MYR'] ?? 0 }},
                {{ $rates['SGD'] ?? 0 }},
                {{ $rates[$currencyCode] ?? 0 }}

            ],

            backgroundColor: '#7A1F1F',

            borderRadius: 5

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                display: false

            }

        },

        scales: {

            y: {

                beginAtZero: true

            }

        }

    }

});

</script>

@endif

@endpush