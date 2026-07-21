@extends('layouts.user')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h5 class="mb-4">
            📈 Risk & Economic Data Visualization
        </h5>


        <!-- SUMMARY -->
        <div class="row">


            <div class="col-md-3 mb-3">

                <div class="card shadow-sm text-center">

                    <div class="card-body">

                        <small class="text-muted">
                            Total Data Risk
                        </small>

                        <h3 class="fw-bold">
                            {{ $riskScores->count() }}
                        </h3>

                    </div>

                </div>

            </div>



            <div class="col-md-3 mb-3">

                <div class="card shadow-sm text-center">

                    <div class="card-body">

                        <small class="text-muted">
                            High Risk
                        </small>

                        <h3 class="fw-bold text-danger">

                            {{ $riskScores->where('risk_level','High Risk')->count() }}

                        </h3>

                    </div>

                </div>

            </div>




            <div class="col-md-3 mb-3">

                <div class="card shadow-sm text-center">

                    <div class="card-body">

                        <small class="text-muted">
                            Medium Risk
                        </small>

                        <h3 class="fw-bold text-warning">

                            {{ $riskScores->where('risk_level','Medium Risk')->count() }}

                        </h3>

                    </div>

                </div>

            </div>





            <div class="col-md-3 mb-3">

                <div class="card shadow-sm text-center">

                    <div class="card-body">

                        <small class="text-muted">
                            Low Risk
                        </small>

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


                        <h6>
                            📊 Risk Trend
                        </h6>


                        <div style="height:300px">

                            <canvas id="riskChart"></canvas>

                        </div>


                    </div>

                </div>

            </div>





            <!-- CURRENCY -->

            <div class="col-md-6 mb-4">


                <div class="card shadow-sm">


                    <div class="card-body">


                        <h6>
                            💱 Currency Trend
                        </h6>


                        <div style="height:300px">

                            <canvas id="currencyChart"></canvas>

                        </div>


                    </div>


                </div>


            </div>





            <!-- GDP -->


            <div class="col-md-6 mb-4">


                <div class="card shadow-sm">


                    <div class="card-body">


                        <h6>
                            💵 GDP Trend
                        </h6>


                        <div style="height:300px">


                            <canvas id="gdpChart"></canvas>


                        </div>


                    </div>


                </div>


            </div>





            <!-- INFLATION -->


            <div class="col-md-6 mb-4">


                <div class="card shadow-sm">


                    <div class="card-body>


                        <h6>
                            📉 Inflation Trend
                        </h6>


                        <div style="height:300px">


                            <canvas id="inflationChart"></canvas>


                        </div>


                    </div>


                </div>


            </div>



        </div>



        <hr>



        <!-- TABLE -->

        <h6 class="mb-3">
            Risk Score History
        </h6>



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


            @foreach($riskScores as $risk)


            <tr>


                <td>
                    {{ $risk->country }}
                </td>


                <td>
                    {{ $risk->weather_score }}
                </td>


                <td>
                    {{ $risk->inflation_score }}
                </td>


                <td>
                    {{ $risk->news_score }}
                </td>


                <td>
                    {{ $risk->currency_score }}
                </td>


                <td>
                    {{ number_format($risk->total_score,2) }}
                </td>


                <td>


                @if($risk->risk_level == 'High Risk')

                    <span class="badge bg-danger">
                        High Risk
                    </span>


                @elseif($risk->risk_level == 'Medium Risk')


                    <span class="badge bg-warning">
                        Medium Risk
                    </span>


                @else


                    <span class="badge bg-success">
                        Low Risk
                    </span>


                @endif


                </td>


            </tr>


            @endforeach


            </tbody>


        </table>



    </div>

</div>


@endsection





@push('scripts')


<script>


console.log("TES VISUALIZATION");

console.log(@json($countries));

console.log(@json($scores));

console.log(@json($gdp));

console.log(@json($inflation));

console.log(@json($currency));




// RISK

new Chart(document.getElementById('riskChart'),{


    type:'line',


    data:{


        labels:@json($countries),


        datasets:[{


            label:'Risk Score',


            data:@json($scores),


            borderWidth:2


        }]


    },


    options:{

        responsive:true,

        maintainAspectRatio:false

    }


});




// CURRENCY

new Chart(document.getElementById('currencyChart'),{


    type:'line',


    data:{


        labels:@json($countries),


        datasets:[{


            label:'Currency Risk',


            data:@json($currency),


            borderWidth:2


        }]


    },


    options:{

        responsive:true,

        maintainAspectRatio:false

    }


});






// GDP

new Chart(document.getElementById('gdpChart'),{


    type:'bar',


    data:{


        labels:@json($economicCountries),


        datasets:[{


            label:'GDP',


            data:@json($gdp),


            borderWidth:1


        }]


    },


    options:{

        responsive:true,

        maintainAspectRatio:false

    }


});





// INFLATION


new Chart(document.getElementById('inflationChart'),{


    type:'line',


    data:{


        labels:@json($economicCountries),


        datasets:[{


            label:'Inflation %',


            data:@json($inflation),


            borderWidth:2


        }]


    },


    options:{

        responsive:true,

        maintainAspectRatio:false

    }


});



</script>


@endpush