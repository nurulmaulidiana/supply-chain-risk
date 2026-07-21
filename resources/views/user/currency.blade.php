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
                        <strong>Currency Trend @if($currencyCode)({{ $currencyCode }} / USD)@endif</strong>
                    </div>

                    <div class="card-body">

                        @if($country && $history->count() > 1)

                            <canvas id="currencyChart" height="100"></canvas>

                        @elseif($country)

                            <div class="text-center text-muted py-5">
                                Belum cukup data historis untuk menampilkan tren.
                                Data akan terkumpul seiring waktu setiap halaman ini diakses.
                            </div>

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
@if($country && $history->count() > 1)
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('currencyChart');

    if (!ctx) {
        return;
    }

    const labels = @json($history->pluck('recorded_date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M')));
    const dataPoints = @json($history->pluck('exchange_rate'));
    const currencyCode = @json($currencyCode);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: '1 USD to ' + currencyCode,
                data: dataPoints,
                borderColor: '#7A1F1F',
                backgroundColor: 'rgba(122,31,31,0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#7A1F1F',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return "1 USD = " + context.parsed.y + " " + currencyCode;
                        }
                    }
                }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Exchange Rate'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            }
        }
    });
});
</script>
@endif
@endpush