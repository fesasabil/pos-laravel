@extends('Layouts.master')

@section('title')
    <title>Manajement Order</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">List Transaction</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content" id="dw">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @card
                            @slot('title')
                                Filter Transaction
                            @endslot

                            <form action="{{ route('order.index') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Start Date</label>
                                            <input type="text" name="start_date" class="form-control {{ $errors->has('start_date') ? 'is-invalid': ''}}" id="start_date" value="{{ request()->get('start_date') }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="">End Date</label>
                                            <input type="text" name="end_date" class="form-control {{ $errors->has('end_date') ? 'is-invalid': ''}}" id="end_date" value="{{ request()->get('end_date') }}">
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-primary btn-sm">Search</button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Customer</label>
                                            <select name="customer_id" class="form-control">
                                                <option value="">Choose</option>
                                                @foreach ($customer as $cust)
                                                <option value="{{ $cust->id }}" {{ request()->get('customer_id') == $cust->id ? 'selected': ''}}>
                                                    {{ $cust->name }} - {{ $cust->email }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="">Kasir</label>
                                            <select name="user_id" class="form-control">
                                                <option value="">Choose</option>
                                                @foreach ($users as $user)
                                                <option value="{{ $user->id }}" {{ request()->get('user_id') == $user->id ? 'selected': ''}}>
                                                    {{ $user->name}} - {{ $user->email }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            @slot('footer')

                            @endslot
                        @endcard
                    </div>

                    <!-- FORM UNTUK MENAMPILKAN DATA TRANSAKSI -->
                    <div class="col-md-12">
                        @card
                            @slot('title')
                                Data Transaction
                            @endslot

                            <!-- KOTAK UNTUK MENAMPILKAN TOTAL DATA -->
                            <div class="row">
                                <div class="col-4">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{ $sold }}</h3>
                                            <p>Item sold</p>
                                        </div>

                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3>Rp. {{ number_format($total) }}</h3>
                                            <p>Total Omset</p>
                                        </div>

                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="small-box bg-primary">
                                        <div class="inner">
                                            <h3>{{ $total_customer}}</h3>
                                            <p>Total Customer</p>
                                        </div>

                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TABLE UNTUK MENAMPILKAN DATA TRANSAKSI -->
                            <div class="table-reponsive">
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>Customer</th>
                                            <th>No.Phone</th>
                                            <th>Total Shopping</th>
                                            <th>Kasir</th>
                                            <th>Tgl Transaction</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <!-- LOOPING MENGGUNAKAN FORELSE, DIRECTIVE DI LARAVEL 5.6 -->
                                        @forelse($orders as $row)
                                        <tr>
                                            <td><strong># {{ $row->invoice }}</strong></td>
                                            <td>{{ $row->customer->name }}</td>
                                            <td>{{ $row->customer->phone }}</td>
                                            <td>Rp {{ number_format($row->total)}}</td>
                                            <td>{{ $row->user->name }}</td>
                                            <td>{{ $row->created_at->format('d-m-Y H:i:s') }}</td>
                                            <td>
                                                <a href="{{ route('order.pdf', $row->invoice) }}" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fa fa-print"></i>
                                                </a>

                                                <a href="{{ route('order.excel', $row->invoice) }}" target="_blank" class="btn btn-info btn-sm">
                                                    <i class="fa fa-file-excel-o"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td class="text-center" colspan="7">There is no transaction data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @slot('footer')

                            @endslot
                        @endcard
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $('#start_date').datepicker([
            autoclose: true,
            format: 'yyyy-mm-dd'
        ]);

        $('#end_date').datepicker([
            autoclose: true,
            format: 'yyyy-mm-dd'
        ]);
    </script>
@endsection