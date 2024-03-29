<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Retail;
use App\Models\Truck;
use App\Models\Tambon;
use App\Models\OrderList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\TruckRouteList;

use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Redirect;
use DB;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('order_cancelled', 'asc')
        ->withCount('products')
        ->where('order_status', '!=', 'สำเร็จแล้ว')
        ->orderBy(DB::raw('order_transportDate IS NULL', 'order_transportDate'), 'ASC')
        ->orderBy('order_transportDate', 'ASC')
        ->orderBy('created_at', 'desc')
        ->paginate(5);
        
        return view('orders.index', ["orders"=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
        abort_if(Gate::denies('employee_order_add_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (!empty($request->term) && !empty($request->type)) 
        {
            if ($request->type == "retails")
            {
                $retails = Retail::query();

                $res = $retails->where(fn($query) => $query->where("retail_name","LIKE","%{$request->term}%")->orWhere("id","LIKE","%{$request->term}%"))->get();
            
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
                    ->where("trucks.truck_status","=",1)
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

    public function store(StoreOrderRequest $request)
    {
        $order = new Order;
        $order->fill($request->all());
        $order->save();
        
        return redirect(route('orders.edit', compact('order')));
    }

    public function show(Order $order)
    {
        $order->load('products');
        $order->load('transport');

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

        abort_if(Gate::denies('user_order_edit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $products = Product::query();
        $searchInput = "";

        if($request->has('action_method'))
        {
            if ($order->order_status != "รอดำเนินการ")
            {
                return response()->json([
                    'statusCode' => 200,
                    'error' => [
                        'msg' => "ไม่สามารถแก้ไขรายการสินค้าในออเดอร์นี้ได้"
                    ]
                ]);
            }
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

        $products->where(fn($query) => $query->where("prod_name","LIKE","%{$request->name}%")->orWhere("prod_type_name","LIKE","%{$request->name}%")->orWhere("id","LIKE","%{$request->name}%"));
        // $products->where('prod_name', 'Like', '%' . $request->name . '%');
        $products = $products->paginate(5);

        return view('orders.edit', compact('order', 'provinces', 'amphoes', 'tambons', 'data', 'products', 'searchInput'));
    }

    public function patch(Request $request, $id)
    {
        $order = Order::find($id);

        if ($request->order_cancelled)
        {
            $order->order_cancelDateTime = now();
            $order->order_status = "ถูกยกเลิก";

            // remove routes

            $routes = TruckRouteList::where('order_id', '=', $order->id);
            $routes->delete();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $validatedData = $request->validate([
            'id' => [
                'required',
                Rule::unique('products')->where(function ($query) use($request, $order) {
                    return $query->where('id', $order->id);
                })->ignore($order->id)
            ]
        ],
        [
         'id.unique'=> 'รหัสสินค้าซ้ำกัน'
        ]);

        if ($request->order_cancelled)
        {
            $order->order_cancelDateTime = now();
            $order->order_status = "ถูกยกเลิก";

            // remove routes

            $routes = TruckRouteList::where('order_id', '=', $order->id);
            $routes->delete();
        }
        else
        {
            $order->order_cancelled = 0;
        }

        if ($order->order_status == "สำเร็จแล้ว" && $request->order_status != $order->order_status)
        {
            $exists = TruckRouteList::where('order_id', $order->id)->where('route_list_status', "1")->count();
            if ($exists > 0)
            {
                return redirect()->back()->withErrors(['msg' => 'โปรดยกเลิกการจัดส่งออเดอร์นี้เพื่อเปลี่ยนสถานะ']);
            }
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
