<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(5);
        return view('orders.index', ["orders"=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $config = [
            'table' => 'orders',
            'length' => 10,
            'prefix' => 'ORDER-'
        ];
        
        $searchInput = "";
        $id = IdGenerator::generate($config);


        $products = Product::query();

        $products->where('stock', '>', 0);

        if (!empty($request->name)) 
        {
            $searchInput = $request->name;
            $products->where('prod_name', 'Like', '%' . $request->name . '%');
        }

        $products = $products->paginate(5);

        if (!empty($request->prod_id))
        {

            if (!empty($request->action_method) && $request->action_method == "del")
            {
                $data = json_decode($request->session()->get('products'), true) ?? [];
                $created = -1;
    
                if ($data)
                {
                    foreach ($data as $key => $value)
                    {
                        if($data[$key]["id"] == $request->prod_id)
                        {
                            $created = $key;
                            break;
                        }
                    }
                }
    
                $array = $data;
    
                if ($created != -1)
                {
                    unset($array[$created]);
                }

                $request->session()->put('products', json_encode($array));
            }
            else
            {
                $data = json_decode($request->session()->get('products'), true) ?? [];
                $created = -1;
    
                if ($data)
                {
                    foreach ($data as $key => $value)
                    {
                        if($data[$key]["id"] == $request->prod_id)
                        {
                            $created = $key;
                            break;
                        }
                    }
                }
    
                $array = $data;
    
                if ($created == -1)
                {
                    array_push($array, array("id"=>$request->prod_id, "name"=>$request->prod_name, "amount"=>1));
                }
                else
                {
                    $array[$created]["amount"] += 1;
                }
    
                $request->session()->put('products', json_encode($array));
            }
        
        }

        $data = json_decode($request->session()->get('products'), true) ?? [];

        return view('orders.create', compact('id', 'products', 'searchInput', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
