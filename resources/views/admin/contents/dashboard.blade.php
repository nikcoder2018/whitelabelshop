@extends('admin.layouts.main')

@section('external_css')
<link href="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css')}}" rel="stylesheet" type="text/css" media="screen"/>
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
                <h1 class=" count2">
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
            <h3>Visitors Graph</h3>
        </div>
        <div class="custom-bar-chart">
            <ul class="y-axis">
                <li><span>100</span></li>
                <li><span>80</span></li>
                <li><span>60</span></li>
                <li><span>40</span></li>
                <li><span>20</span></li>
                <li><span>0</span></li>
            </ul>
            <div class="bar">
                <div class="title">JAN</div>
                <div class="value tooltips" data-original-title="80%" data-toggle="tooltip" data-placement="top">80%</div>
            </div>
            <div class="bar ">
                <div class="title">FEB</div>
                <div class="value tooltips" data-original-title="50%" data-toggle="tooltip" data-placement="top">50%</div>
            </div>
            <div class="bar ">
                <div class="title">MAR</div>
                <div class="value tooltips" data-original-title="40%" data-toggle="tooltip" data-placement="top">40%</div>
            </div>
            <div class="bar ">
                <div class="title">APR</div>
                <div class="value tooltips" data-original-title="55%" data-toggle="tooltip" data-placement="top">55%</div>
            </div>
            <div class="bar">
                <div class="title">MAY</div>
                <div class="value tooltips" data-original-title="20%" data-toggle="tooltip" data-placement="top">20%</div>
            </div>
            <div class="bar ">
                <div class="title">JUN</div>
                <div class="value tooltips" data-original-title="39%" data-toggle="tooltip" data-placement="top">39%</div>
            </div>
            <div class="bar">
                <div class="title">JUL</div>
                <div class="value tooltips" data-original-title="75%" data-toggle="tooltip" data-placement="top">75%</div>
            </div>
            <div class="bar ">
                <div class="title">AUG</div>
                <div class="value tooltips" data-original-title="45%" data-toggle="tooltip" data-placement="top">45%</div>
            </div>
            <div class="bar ">
                <div class="title">SEP</div>
                <div class="value tooltips" data-original-title="50%" data-toggle="tooltip" data-placement="top">50%</div>
            </div>
            <div class="bar ">
                <div class="title">OCT</div>
                <div class="value tooltips" data-original-title="42%" data-toggle="tooltip" data-placement="top">42%</div>
            </div>
            <div class="bar ">
                <div class="title">NOV</div>
                <div class="value tooltips" data-original-title="60%" data-toggle="tooltip" data-placement="top">60%</div>
            </div>
            <div class="bar ">
                <div class="title">DEC</div>
                <div class="value tooltips" data-original-title="90%" data-toggle="tooltip" data-placement="top">90%</div>
            </div>
        </div>
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

@section('script')
<!--script for this page-->
<script src="{{asset('js/sparkline-chart.js')}}"></script>
<script src="{{asset('js/easy-pie-chart.js')}}"></script>
<script src="{{asset('js/count.js')}}"></script>

<script>

    //owl carousel

    $(document).ready(function() {
        $("#owl-demo").owlCarousel({
            navigation : true,
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem : true,
            autoPlay:true

        });
    });

    //custom select box

    $(function(){
        $('select.styled').customSelect();
    });

    $(window).on("resize",function(){
        var owl = $("#owl-demo").data("owlCarousel");
        owl.reinit();
    });

</script>
@endsection