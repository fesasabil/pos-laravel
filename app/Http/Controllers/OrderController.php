<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Order_detail;
use Carbon\Carbon;
use App\User;
use Cookie;
use DB;
use PDF;

class OrderController extends Controller
{
    public function addOrder()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('orders.add', compact('products'));
    }

    public function getProduct()
    {
        $products = Product::findOrFail($id);
        return response()->json($products, 200);
    }

    public function addToCart(Request $request)
    {
         //validasi data yang diterima dari ajax request addToCart mengirimkan product_id dan qty
         $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer'
         ]);

         //mengambil data product berdasarkan id
         $product = Product::findOrFail($request->product_id);
         //mengambil cookie cart dengan $request->cookie('cart')
         $getCart = json_decode($request->cookie('cart'), true);

         //jika datanya ada
         if ($getCart) {
             if (array_key_exists($request->product_id, $getCart)) {
                 $getCart[$request->product_id]['qty'] += $request->qty;
                 return response()->json($getCart, 200)
                    ->cookie('cart', json_encode($getCart), 120);
             }
         }

         $getCart[$request->product_id] = [
            'code' => $product->code,
            'name' => $product->name,
            'price' => $product->price,
            'qty' => $product->qty,
         ];
         return response()->json($getCart, 200)
            ->cookie('cart', json_encode($getCart), 120);
    }

    public function getCart()
    {
        $cart = json_decode(request()->cookie('cart'), true);
        return response()->json($cart, 200);
    }

    public function removeCart($id)
    {
        $cart = json_decode(request()->cookie('cart'), true);
        unset($cart[$id]);
        return response()->json($cart, 200)->cookie('cart', json_encode($cart), 120);
    }

    public function checkout()
    {
        return view('Orders.checkout');
    }

    public function storeOrder(Request $request)
    {
        //validate
        $this->validate($requesta, [
            'email' => 'required|email',
            'name' => 'required|string|max:50',
            'address' => 'required',
            'phone' => 'required|numeric'
        ]);

        //get list cart from cookie
        $cart = json_decode($request->cookie('cart'), true);
        //memanipulasi array untuk menciptakan key baru yakni result dari hasil perkalian price * qty
        $result = collect($cart)->map(function($value) {
            return [
                'code' => $value['code'],
                'name' => $value['name'],
                'qty' => $value['qty'],
                'price' => $value['price'],
                'result' => $value['price'] * $value['qty']
            ];
        })->all();

        //database transaction
        DB::beginTransaction();
        try{
            $customer = Customer::firstOrCreate([
                'email' => $request->email,
            ], [
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone
            ]);

            //table order
            $order = Order::create([
                'invoice' => $this->generateInvoice(),
                'customer_id' => $customer->id,
                'user_id' => auth()->user()->id,
                'qty' => array_sum(array_column($result, 'result'))
            ]);

            //looping cart untuk disimpan ke table order_details
            foreach($result as $key => $row) {
                $order->order_detail()->create([
                    'product_id' => $key,
                    'qty' => $row['qty'],
                    'price' => $row['price']
                ]);
            }
            //apabila tidak terjadi error, penyimpanan diverifikasi
            DB::commit();
            
            //me-return status dan message berupa code invoice, dan menghapus cookie
            return response()->json([
                'status' => 'success',
                'message' => $order->invoice,
            ], 200)->cookie(Cookie::forget('cart'));
        }catch (Exception $e) {
            //jika ada error, maka akan dirollback sehingga tidak ada data yang tersimpan
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ], 400);
        }

    }

    public function generateInvoice()
    {
        $order = Order::orderBy('created_at', 'DESC');
        if ($order->count() > 0) {
            $order = $order->first();
            $explode = explode('-', $order->invoice);
            $count = $explode[1] + 1;
            return 'INV-' . $count;
        }
        return 'INV-1';
    }

    public function index(Request $request)
    {
        //Get customer data
        $customers = Customer::orderBy('name', 'ASC')->get();
        //Get user data with role kasir
        $users = User::role('kasir')->orderBy('name', 'ASC')->get();
        //Get transaction data
        $orders = Order::orderBy('created_at', 'DESC')->with('order_detail', 'customer');

        //JIKA PELANGGAN DIPILIH PADA COMBOBOX
        if (!empty($request->customer_id)) {
            //MAKA DITAMBAHKAN WHERE CONDITION
            $orders = $orders->where('customer_id', $request->customer_id);
        }

        if (!empty($request->user_id)) {
            $orders = $orders->where('user_id', $request->user_id);
        }

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $this->validate($request, [
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date'
            ]);

            $start_date = Carbon::parse($request->start_date)->format('Y-m-d') . ' 00:00:01';
            $end_date = Caebon::parse($request->end_date)->format('Y-m-d') . '23:59:59';
            
            $orders = $orders->whereBetween('created_at', [$start_date, $end_date])->get();
        } else {
            $orders = $orders->take(10)->skip(0)->get();
        }

        //MENAMPILKAN KE VIEW
        return view('orders.index', [
            'orders' => $orders,
            'sold' => $this->countitem($orders),
            'total' => $this->countTotal($orders),
            'total_customer' => $this->countCustomer($orders),
            'customers' => $customers,
            'users' => $users,
        ]);
    }

    private function countCustomer($orders)
    {
        $customer = [];

        if($orders->count() > 0) {
            foreach ($orders as $row) {
                $customer[] = $row->customer->email;
            }
        }
        return count(array_unique($customer));
    }

    private function countTotal($orders)
    {
        $total = 0;

        if($orders->count() > 0) {
            //MENGAMBIL VALUE DARI TOTAL -> PLUCK() AKAN MENGUBAHNYA MENJADI ARRAY
            $sub_total = $orders->pluck('total')->all();
            $total = array_sum($sub_total);
        }
        return $total;
    }

    private function countItem($orders)
    {
        $data = 0;

        if($order->count() > 0) {
            foreach ($order as $row) {
                $qty = $row->order_detail->pluck('qty')->all();
                $val = array_sum($qty);
                $data += $val;
            }
        }
        return $data;
    }

    public function invoicePdf($invoice)
    {
        $order = Order::where('invoice', $invoice)->with('customer', 'order_detail', 'order_detail.product')->first();
        $pdf = PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif'])
            ->loadView('orders.report.invoice', compact('order'));
        return $pdf->stream();
    }
    
}