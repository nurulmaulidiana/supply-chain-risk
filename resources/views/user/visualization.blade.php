@extends('layouts.user')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <h5 class="mb-4">📈 Risk & Economic Data Visualization</h5>

        <!-- SUMMARY -->
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <small class="text-muted">Total Data Risk</small>
                        <h3 class="fw-bold">{{ $riskScores->count() }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <small class="text-muted">High Risk</small>
                        <h3 class="fw-bold text-danger">
                            {{ $riskScores->where('risk_level','High Risk')->count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <small class="text-muted">Medium Risk</small>
                        <h3 class="fw-bold text-warning">
                            {{ $riskScores->where('risk_level','Medium Risk')->count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <small class="text-muted">Low Risk</small>
                        <h3 class="fw-bold text-success">
                            {{ $riskScores->where('risk_level','Low Risk')->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <!-- ================= CHART AREA ================= -->
        <div class="row">

            <!-- RISK -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>📊 Risk Trend</h6>
                        @if($riskScores->count() > 0)
                            <div style="height:300px">
                                <canvas id="riskChart"></canvas>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada data risk.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- CURRENCY -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>💱 Currency Trend</h6>
                        @if($riskScores->count() > 0)
                            <div style="height:300px">
                                <canvas id="currencyChart"></canvas>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada data currency.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- GDP -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>💵 GDP Trend</h6>
                        @if($economicCountries->count() > 0)
                            <div style="height:300px">
                                <canvas id="gdpChart"></canvas>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada data GDP.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- INFLATION -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>📉 Inflation Trend</h6>
                        @if($economicCountries->count() > 0)
                            <div style="height:300px">
                                <canvas id="inflationChart"></canvas>
                            </div>
                        @else
                            <p class="text-muted mb-0">Belum ada data inflasi.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <hr>

        <!-- TABLE -->
        <h6 class="mb-3">Risk Score History</h6>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Country</th>
                    <th>Weather</th>
                    <th>Inflation</th>
                    <th>News</th>
                    <th>Currency</th>
                    <th>Total Score</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riskScores as $risk)
                <tr>
                    <td>{{ $risk->country }}</td>
                    <td>{{ $risk->weather_score }}</td>
                    <td>{{ $risk->inflation_score }}</td>
                    <td>{{ $risk->news_score }}</td>
                    <td>{{ $risk->currency_score }}</td>
                    <td>{{ number_format($risk->total_score, 2) }}</td>
                    <td>
                        @if($risk->risk_level == 'High Risk')
                            <span class="badge bg-danger">High Risk</span>
                        @elseif($risk->risk_level == 'Medium Risk')
                            <span class="badge bg-warning">Medium Risk</span>
                        @else
                            <span class="badge bg-success">Low Risk</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>

@endsection

@push('scripts')
<script>

// palet warna dipakai berulang buat chart yang butuh banyak kategori (GDP/Inflation)
const palette = [
    '#0d6efd', '#20c997', '#fd7e14', '#6f42c1',
    '#d63384', '#0dcaf0', '#ffc107', '#198754',
    '#dc3545', '#6c757d'
];

function colorAt(i) {
    return palette[i % palette.length];
}

// =========================
// RISK CHART
// =========================
@if($riskScores->count() > 0)
new Chart(document.getElementById('riskChart'), {
    type: 'line',
    data: {
        labels: @json($countries),
        datasets: [{
            label: 'Risk Score',
            data: @json($scores),
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.15)',
            pointBackgroundColor: @json($riskColors),
            pointRadius: 6,
            pointHoverRadius: 8,
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true, title: { display: true, text: 'Risk Score' } }
        },
        plugins: {
            legend: { display: true }
        }
    }
});
@endif

// =========================
// CURRENCY CHART
// =========================
@if($riskScores->count() > 0)
new Chart(document.getElementById('currencyChart'), {
    type: 'line',
    data: {
        labels: @json($countries),
        datasets: [{
            label: 'Currency Risk',
            data: @json($currency),
            borderColor: '#20c997',
            backgroundColor: 'rgba(32,201,151,0.15)',
            borderWidth: 2,
            fill: true,
            tension: 0.3,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
@endif

// =========================
// GDP CHART
// =========================
@if($economicCountries->count() > 0)
const gdpLabels = @json($economicCountries);
new Chart(document.getElementById('gdpChart'), {
    type: 'bar',
    data: {
        labels: gdpLabels,
        datasets: [{
            label: 'GDP',
            data: @json($gdp),
            backgroundColor: gdpLabels.map((_, i) => colorAt(i)),
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function (value) {
                        return new Intl.NumberFormat('en-US', { notation: 'compact' }).format(value);
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function (ctx) {
                        return ' GDP: ' + new Intl.NumberFormat('en-US').format(ctx.raw);
                    }
                }
            }
        }
    }
});
@endif

// =========================
// INFLATION CHART
// =========================
@if($economicCountries->count() > 0)
new Chart(document.getElementById('inflationChart'), {
    type: 'line',
    data: {
        labels: @json($economicCountries),
        datasets: [{
            label: 'Inflation %',
            data: @json($inflation),
            borderColor: '#dc3545',
            backgroundColor: 'rgba(220,53,69,0.15)',
            borderWidth: 2,
            fill: true,
            tension: 0.3,
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function (value) { return value + '%'; }
                }
            }
        }
    }
});
@endif

</script>
@endpush