<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Retail;
use App\Models\Truck;
use App\Models\Tambon;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;
use Response;
use Redirect;
use DB;

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
        if (!empty($request->term) && !empty($request->type)) 
        {
            if ($request->type == "retails")
            {
                $retails = Retail::query();

                $res = $retails->where("retail_name","LIKE","%{$request->term}%")->take(10)->get();
            
                return response()->json($res);
            }
            else if ($request->type == "trucks")
            {
                $trucks = Truck::query();

                $res = $trucks
                    ->select('users.*','users.id as user_id', 'orders.*','orders.id as order_id', 'trucks.*','trucks.id as truck_id')
                    ->leftJoin('users', 'users.id', '=', 'trucks.user_id')
                    ->leftJoin('orders', 'orders.truck_id', '=', 'trucks.id')
                    ->where(fn($query) => $query->where("plateNumber","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%"))
                    ->where(fn($query) => $query->where("orders.order_cancelled","=","0")->orWhereNull("orders.order_cancelled"))
                    ->where(fn($query) => $query->where("orders.order_status","LIKE","กำลังดำเนินการ")->orWhereNull("orders.order_status"))
                    ->where("trucks.status","LIKE","พร้อมใช้งาน")
                    ->groupBy('trucks.id')
                    ->orderBy('orders.id', 'desc')
                    ->take(10)
                    ->get();

                return response()->json($res);
            }
        }

        $config = [
            'table' => 'orders',
            'length' => 10,
            'prefix' => 'ORDER-'
        ];
        
        $id = IdGenerator::generate($config);


        /*
        $searchInput = "";
        $products = Product::query();

        if (!empty($request->name)) 
        {
            $searchInput = $request->name;
            $products->where('prod_name', 'Like', '%' . $request->name . '%');
        }

        $products = $products->paginate(5);

        if (!empty($request->prod_id) && !empty($request->action_method))
        {

            if ($request->action_method == "del")
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
            else if ($request->action_method == "onchange")
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
    
                if ($created == -1 && $request->v > 0)
                {
                    array_push($array, array("id"=>$request->prod_id, "name"=>$request->prod_name, "amount"=>$request->v, "price"=>$request->prod_price));
                }
                else
                {
                    if ($request->v > 0) $array[$created]["amount"] = $request->v;
                    else
                    {
                        unset($array[$created]);
                    }
                }
    
                $request->session()->put('products', json_encode($array));
                return Response::json($array);
            }
            else if ($request->action_method == "add")
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
                    array_push($array, array("id"=>$request->prod_id, "name"=>$request->prod_name, "price"=>$request->prod_price, "amount"=>1));
                }
                else
                {
                    $array[$created]["amount"] += 1;
                }
    
                $request->session()->put('products', json_encode($array));
            }
        
        }

        $data = json_decode($request->session()->get('products'), true) ?? [];*/

        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();

    return view('orders.create', compact('id', 'provinces', 'amphoes', 'tambons'/*, 'products', 'searchInput', 'data'*/));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'retail_id' => 'required',
            'truck_id' => 'required',
            'truck_driver' => 'required'
        ]);
        
        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();
        
        $order = new Order;
        $order->fill($request->all());
        $order->save();
        
        /*DB::transaction(function() use($request) 
        {
            $productLists = json_decode($request->session()->get('products')); 
 
            $order->fill($request->all());
            $order->save();
        
            $orderProducts = [];
            foreach ($productLists as $product) {
                $orderProducts[] = [
                    'order_id' => $order->id,
                    'price' => $product->price,
                    'qty' => $product->amount,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'total' => $product->price * $product->amount
                ];
            }

            OrderList::insert($orderProducts);
            
        });*/

        $orderLists = OrderList::query();
        $data = $orderLists->where("order_id","=", $order->id)->get();

        $products = Product::query();
        $products = $products->paginate(5);
        $searchInput = "";

        return view('orders.edit', compact('order', 'provinces', 'amphoes', 'tambons', 'data', 'products', 'searchInput'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, Request $request)
    {

        $products = Product::query();
        $searchInput = "";

        if($request->has('action_method'))
        {
            if ($request->action_method == "onchange")
            {
                $update = OrderList::where("order_id", "=", $order->id)->where('product_id', "=", $request->prod_id)
                ->update(
                    [
                        'qty' => $request->v
                    ]
                );

                if ($update) 
                {
                    return response()->json([
                        'statusCode' => 200
                    ]);
                }
            }
            else if ($request->action_method == "remove")
            {
                $result = OrderList::where("order_id","=", $order->id)->where("product_id","=", $request->prod_id)->delete();

                return response()->json([
                    'statusCode' => 200,
                    'data' => [
                        'id' => $request->prod_id,
                        'result' => $result
                    ]
                ]);
            }
            else if ($request->action_method == "add")
            {
                $product = OrderList::where("order_id","=", $order->id)->where("product_id","=", $request->prod_id)->get()->first();

                $newQty = $product ? $product->qty + 1 : 1;

                $addList = OrderList::upsert([
                    ['order_id' => $order->id, 'product_id' => $request->prod_id, 'product_name' => $request->prod_name, 'qty' => $newQty, 'price' => $request->prod_price, 'total' => $newQty * $request->prod_price]
                ], ['order_id', 'product_id'], ['qty', 'price', 'total']);

                return response()->json([
                    'statusCode' => 200,
                    'data' => [
                        'id' => $request->prod_id,
                        'name' => $request->prod_name,
                        'price' => $request->prod_price,
                        'qty' => $newQty
                    ]
                ]);
            }
            else return response()->json([
                'statusCode' => 500
            ]);
        }

        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();

        //$data = json_decode($request->session()->get('products'), true) ?? [];

        $orderLists = OrderList::query();
        $data = $orderLists->where("order_id","=", $order->id)->get();

        $products->where('prod_name', 'Like', '%' . $request->name . '%');
        $products = $products->paginate(5);

        return view('orders.edit', compact('order', 'provinces', 'amphoes', 'tambons', 'data', 'products', 'searchInput'));
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
        
        /*if ($order->order_cancelled)
        {
            return;
        }*/

        if ($request->order_cancelled)
        {
            $order->order_cancelDateTime = now();
            $order->order_status = "ถูกยกเลิก";
        }
        else
        {
            $order->order_cancelled = 0;
        }

        $order->fill($request->all());
        $order->update();

        return Redirect::route('orders.index')->with('status', $order->id . ' ได้รับการปรับปรุงเรียบร้อยแล้ว');
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
