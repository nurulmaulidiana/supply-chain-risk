@extends('layouts.user')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">

        <form method="GET" action="{{ route('user.comparison') }}">

            <div class="row mb-4">

                <div class="col-md-5">
                    <label class="form-label fw-bold">Country 1</label>

                    <select name="country1" class="form-select">
                        @foreach($countries as $country)
                            <option value="{{ $country['name'] }}"
                                {{ $country1 == $country['name'] ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-5">

                    <label class="form-label fw-bold">Country 2</label>

                    <select name="country2" class="form-select">
                        @foreach($countries as $country)
                            <option value="{{ $country['name'] }}"
                                {{ $country2 == $country['name'] ? 'selected' : '' }}>
                                {{ $country['name'] }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="col-md-2 d-flex align-items-end">

                    <button type="submit" class="btn btn-primary w-100">
                        Compare
                    </button>

                </div>

            </div>

        </form>

        <table class="table table-bordered">

            <thead class="table-primary">

                <tr>
                    <th>Indicator</th>
                    <th>{{ $country1 }}</th>
                    <th>{{ $country2 }}</th>
                </tr>

            </thead>

            <tbody>

                <tr>
                    <td>Currency</td>
                    <td>{{ $first['currencies'][0]['code'] ?? '-' }}</td>
                    <td>{{ $second['currencies'][0]['code'] ?? '-' }}</td>
                </tr>

                <tr>
                    <td>GDP</td>
                    <td>{{ $firstGDP ? '$'.number_format($firstGDP,0) : '-' }}</td>
                    <td>{{ $secondGDP ? '$'.number_format($secondGDP,0) : '-' }}</td>
                </tr>

                <tr>
                    <td>Inflation</td>
                    <td>
                        {{ $firstInflation !== null ? number_format($firstInflation,2).' %' : '-' }}
                    </td>
                    <td>
                        {{ $secondInflation !== null ? number_format($secondInflation,2).' %' : '-' }}
                    </td>
                </tr>

                <tr>
                    <td>Weather</td>
                    <td>{{ $firstWeather }}</td>
                    <td>{{ $secondWeather }}</td>
                </tr>

                <tr>

                    <td>Risk</td>

                    <td>
                        @if($firstRisk >= 70)
                            <span class="badge bg-danger">{{ $firstRisk }} (High)</span>
                        @elseif($firstRisk >= 40)
                            <span class="badge bg-warning text-dark">{{ $firstRisk }} (Medium)</span>
                        @else
                            <span class="badge bg-success">{{ $firstRisk }} (Low)</span>
                        @endif
                    </td>

                    <td>
                        @if($secondRisk >= 70)
                            <span class="badge bg-danger">{{ $secondRisk }} (High)</span>
                        @elseif($secondRisk >= 40)
                            <span class="badge bg-warning text-dark">{{ $secondRisk }} (Medium)</span>
                        @else
                            <span class="badge bg-success">{{ $secondRisk }} (Low)</span>
                        @endif
                    </td>

                </tr>

            </tbody>

        </table>

    </div>
</div>

@endsection