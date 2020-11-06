@extends('admin.layouts.main')

@section('external_css')
<link rel="stylesheet" href="{{asset('assets/chart.js/dist/Chart.min.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('css/owl.carousel.css')}}" type="text/css">
@endsection

@section('content')
<!--state overview start-->
<div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
        <section class="card">
            <div class="symbol terques">
                <i class="fa fa-user"></i>
            </div>
            <div class="value">
                <h1 class="count">
                    {{$total_vendors}}
                </h1>
                <p>Vendors</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="card">
            <div class="symbol red">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="value">
                <h1 class="count2">
                    {{$total_products}}
                </h1>
                <p>Products</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="card">
            <div class="symbol yellow">
                <i class="fa fa-comments-o"></i>
            </div>
            <div class="value">
                <h1 class=" count3">
                    {{$total_enquiries}}
                </h1>
                <p>Enquiries</p>
            </div>
        </section>
    </div>
    <div class="col-lg-3 col-sm-6">
        <section class="card">
            <div class="symbol blue">
                <i class="fa fa-bar-chart-o"></i>
            </div>
            <div class="value">
                <h1 class=" count4">
                    {{$total_traffics}}
                </h1>
                <p>Traffics</p>
            </div>
        </section>
    </div>
</div>
<!--state overview end-->

<div class="row">
    <div class="col-lg-8">
        <!--custom chart start-->
        <div class="border-head">
            <h3>Statistics</h3>
        </div>
        <div class="text-center">
            <button class="btn btn-primary btn-sm btn-action" type="today">1 day</button>
            <button class="btn btn-primary btn-sm btn-action" type="daily">7 days</button>
            <button class="btn btn-primary btn-sm btn-action" type="weekly">1 Month</button>
            <button class="btn btn-primary btn-sm btn-action" type="monthly">12 Months</button>
            <button class="btn btn-primary btn-sm btn-action" type="yearly">All</button>
        </div>
        <canvas id="line" height="300" width="730"></canvas>
        <!--custom chart end-->
    </div>
    <div class="col-lg-4">
        <!--new earning start-->
        <div class="card terques-chart">
            <div class="card-body chart-texture">
                <div class="chart">
                    <div class="heading">
                        <span>Friday</span>
                        <strong>57,009 | 15%</strong>
                    </div>
                    <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,564,455]"></div>
                </div>
            </div>
            <div class="chart-tittle">
                <span class="title">New Visitors</span>
                <span class="value">
                    <a href="#" class="active">Market</a>
                    |
                    <a href="#">Referal</a>
                    |
                    <a href="#">Online</a>
                </span>
            </div>
        </div>
        <!--new earning end-->

        <!--total earning start-->
        <div class="card green-chart">
            <div class="card-body">
                <div class="chart">
                    <div class="heading">
                        <span>June</span>
                        <strong>23 Days | 65%</strong>
                    </div>
                    <div id="barchart"></div>
                </div>
            </div>
            <div class="chart-tittle">
                <span class="title">Total Visitors</span>
                <span class="value">76,54,678</span>
            </div>
        </div>
        <!--total earning end-->
    </div>
</div>

@endsection

@section('scripts')
<!--script for this page-->
<script src="{{asset('assets/chart.js/dist/Chart.min.js')}}"></script>
<script>
    var ctx = document.getElementById("line").getContext('2d');
    var myChart = new Chart(ctx, {});
    $('.btn-action').on('click', function(){
        let type = $(this).attr('type');
        $.get("{{route('charts.index')}}", {type}, function(response){
            myChart.destroy();
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.labels,
                    datasets:[
                        {
                            label: 'Phone Views',
                            borderColor: "#8e5ea2",
                            borderWidth: 1,
                            data : response.data.phoneviews
                        },
                        {
                            label: 'Product Views',
                            borderColor: "#3e95cd",
                            borderWidth: 1,
                            data : response.data.productviews
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        });
    });

    $('.btn-action:first').trigger('click');
</script>
@endsection