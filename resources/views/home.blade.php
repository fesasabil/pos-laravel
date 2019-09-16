@extends('Layouts.master')

@section('title')
    <title>Dashboard</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content" id="dw">
            <div class="container-fluid">

            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                    <h3>{{ $product }}</h3>

                    <p>Product</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                    <h3>{{ $order }}<sup style="font-size: 20px">%</sup></h3>

                    <p>Order</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                    <h3>{{ $user }}</h3>

                    <p>User Registrations</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                    <h3>{{ $customer }}</h3>

                    <p>Customer</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
                </div>
                <!-- ./col -->
            </div>

            <!-- YANG PERLU DIPERHATIKAN ADALAH LINE DIBAWAH -->
            <div class="row">
                    <!-- CHART.JS MEMINTA ELEMENT YANG MEMILIKI ID dw-chart -->
                    <canvas id="dw-chart"></canvas>
            </div>

            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection