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
        $orders = Order::orderBy('order_cancelled', 'asc')->withCount('products')->where('order_status', '!=', 'สำเร็จแล้ว')->orderBy('created_at', 'desc')->paginate(5);
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
                    ->leftJoin(DB::raw('(SELECT * FROM `orders` ORDER BY `id` DESC LIMIT 1) orders'), function($join)
                    {
                        $join->on('orders.truck_id', '=', 'trucks.id');
                    })
                    ->where(fn($query) => $query->where("plateNumber","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%"))
                    ->where(fn($query) => $query->where("orders.order_cancelled","=","0")->orWhereNull("orders.order_cancelled"))
                    ->where("trucks.status","LIKE","พร้อมใช้งาน")
                    ->groupBy('orders.id')
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

        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();

        return view('orders.create', compact('id', 'provinces', 'amphoes', 'tambons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request, 
            [   
                'retail_id'             => 'required'
            ],
            [   
                'retail_id.required'    => 'โปรดเลือกร้านค้าจากระบบ'
            ]
        );
        
        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();
        
        $order = new Order;
        $order->fill($request->all());
        $order->save();
        
        $orderLists = OrderList::query();
        $data = $orderLists->where("order_id","=", $order->id)->get();

        $products = Product::query();
        $products = $products->paginate(5);
        $searchInput = "";

        return view('orders.edit', compact('order', 'provinces', 'amphoes', 'tambons', 'data', 'products', 'searchInput'));
    }

    public function show(Order $order)
    {
        $order->load('products');
        $order->load('routes');

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order, Request $request)
    {
        $products = Product::query();
        $searchInput = "";

        if($request->has('action_method'))
        {
            if ($request->action_method == "onchange")
            {
                $query = OrderList::where("order_id", "=", $order->id)->where('product_id', "=", $request->prod_id);

                $tempOrder = $query->get()->first();
                
                $update = $query
                ->update(
                    [
                        'qty' => $request->v,
                        'total' => $tempOrder->price * $request->v
                    ]
                );

                DB::statement('UPDATE orders INNER JOIN (
                  SELECT order_id, SUM(total) as total
                  FROM order_lists
                  GROUP BY order_id
                ) list ON orders.id = list.order_id
                SET orders.order_total = list.total');

                if ($update) 
                {
                    return response()->json([
                        'statusCode' => 200,
                        'prev' => $tempOrder,
                        'data' => $query->get()->first()
                    ]);
                }
            }
            else if ($request->action_method == "remove")
            {
                $result = OrderList::where("order_id","=", $order->id)->where("product_id","=", $request->prod_id)->delete();

                DB::statement('UPDATE orders INNER JOIN (
                    SELECT order_id, SUM(total) as total
                    FROM order_lists
                    GROUP BY order_id
                  ) list ON orders.id = list.order_id
                  SET orders.order_total = list.total');

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

                $total = $newQty * $request->prod_price;

                $addList = OrderList::upsert([
                    [
                        'order_id' => $order->id, 
                        'product_id' => $request->prod_id, 
                        'product_name' => $request->prod_name, 
                        'qty' => $newQty, 
                        'price' => $request->prod_price, 
                        'total' => $total
                    ]
                ], ['order_id', 'product_id'], ['qty', 'price', 'total']);

                DB::statement('UPDATE orders INNER JOIN (
                    SELECT order_id, SUM(total) as total
                    FROM order_lists
                    GROUP BY order_id
                  ) list ON orders.id = list.order_id
                  SET orders.order_total = list.total');

                return response()->json([
                    'statusCode' => 200,
                    'data' => [
                        'id' => $request->prod_id,
                        'name' => $request->prod_name,
                        'price' => $request->prod_price,
                        'qty' => $newQty,
                        'total' => $total
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
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
