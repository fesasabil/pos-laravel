<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice  # {{ $order->invoice}}</title>
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
</head>
<body>
    <div class="header">
        <h3>Point of Sales</h3>
        <h4 style="line-height: 0px;">Invoice: {{ $order->invoice }}</h4>
        <p><small style="opacity: 0.5;">{{ $order->created_at->format('d-m-Y H:i:s') }}</small></p>
    </div>  

    <div class="customer">
        <table>
            <tr>
                <th>Name Customer</th>
                <td>:</td>
                <td>{{ $order->customer->name }}</td>
            </tr>

            <tr>
                <th>Address</th>
                <td>:</td>
                <td>{{ $order->customer->address }}</td>
            </tr>
        </table>
    </div>

    <div class="page">
        <table class="layout display responsive-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $no = 1;
                    $totalPrice = 0;
                    $totalQty = 0;
                    $total = 0;
                @endphp

                @forelse ($order->order_detail as $row)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->product->name }}</td>
                    <td>Rp. {{ number_format($row->price) }}</td>
                    <td>{{ $row->qty }} Item</td>
                    <td>Rp. {{ number_format($row->price * $row->qty) }}</td>
                </tr>

                @php
                    $totalPrice += $row->price;
                    $totalQty += $row->qty;
                    $total += ($row->price * $row->qty);
                @endphp

                @empty

                <tr>
                    <td colspan="5" class="text-center">Nothing Data</td>
                </tr>
                @endforelse
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="2">Amount</th>
                    <td>Rp. {{ number_format($totalPrice}}</td>
                    <td>{{ number_format($totalQty)}}</td>
                    <td>Rp. {{ number_format($total)}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    
</body>
</html>