<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Customer;
use App\User;
use Carbon\Carbon;
use DB;

class HomeController extends Controller
{
   /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product = Product::count();
        $order = Order::count();
        $customer = Customer::count();
        $user = User::count();
        return view('home', compact('product', 'order', 'customer', 'user'));
    }

    public function getChart()
    {
        $start = Carbon::now()->subWeek()->addDay()->format('Y-m-d') . ' 00:00:01';
        $end = Carbon::now()->format('Y-m-d') . ' 23:59:00';

        //SELECT DATA KAPAN RECORDS DIBUAT DAN JUGA TOTAL PESANAN
        $order = Order::select(DB::raw('date(created_at) as order_date'), DB::raw('count(*) as total_order'))
            //DENGAN KONDISI ANTARA TANGGAL YANG ADA DI VARIABLE $start DAN $end 
            ->whereBetween('created_at', [$start, $end])
            //KEMUDIAN DI KELOMPOKKAN BERDASARKAN TANGGAL
            ->groupBy('created_at')
            ->get()->pluck('total_order', 'order_date')->all();

        //LOOPING TANGGAL DENGAN INTERVAL SEMINGGU TERAKHIR
        for ($i = Carbon::now()->subWeek()->addDay(); $i <= Carbon::now(); $i->addDay()) {
            if (array_key_exists($i->format('Y-m-d'), $order)) {
                //MAKA TOTAL PESANANNYA DI PUSH DENGAN KEY TANGGAL
                $data[$i->format('Y-m-d')] = $order[$i->format('Y-m-d')];
            } else {
                //JIKA TIDAK, MASUKKAN NILAI 0
                $data[$i->format('Y-m-d')] = 0;
            }
        }
        return response()->json($data);
    }
}
