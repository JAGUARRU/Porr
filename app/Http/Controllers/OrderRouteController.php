<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderRouteLists;
use App\Models\OrderRoute;
use App\Models\Order;

use App\Models\Truck;
use DB;

class OrderRouteController extends Controller
{
    public function index()
    {
        $routes = Order::where('order_cancelled', "=", false)->where('order_status', '!=', 'ถูกยกเลิก')->where('order_status', '!=', 'สำเร็จแล้ว')->orderBy('created_at', 'desc')->paginate(5);
        return view('routes.index', ["routes"=>$routes]);
    }

    public function list()
    {
        $routes = OrderRoute::with('order')->with('truck')->where('status', '=', 0)->orderBy('created_at', 'desc')->paginate(5);
        return view('routes.list', ["routes"=>$routes]);
    }

    public function order()
    {
        $orders = Order::where('order_status', '=', 'สำเร็จแล้ว')->orderBy('id', 'desc')->orderBy('created_at', 'desc')->paginate(5);
        return view('routes.order', ["orders"=>$orders]);
    }

    public function confirm($id)
    {
        $orderRoute = OrderRoute::find($id);

        $orderRoute->load('order');
        $orderRoute->load('truck');
        $orderRoute->load('lists');


        return view('routes.confirm', compact('orderRoute'));
    }

    public function create(Request $request)
    {
        if (!empty($request->term) && !empty($request->type)) 
        {
            if ($request->type == "trucks")
            {
                $trucks = Truck::query();

                $res = $trucks
                    ->select('users.*','users.id as user_id', 'routes.*','routes.id as route_id', 'trucks.*','trucks.id as truck_id')
                    ->leftJoin('users', 'users.id', '=', 'trucks.user_id')
                    ->leftJoin(DB::raw('(SELECT * FROM `order_routes` ORDER BY `id` DESC LIMIT 1) routes'), function($join)
                    {
                        $join->on('routes.truck_id', '=', 'trucks.id');
                    })
                    ->groupBy('routes.id')
                    ->groupBy('trucks.id')
                    ->orderBy(DB::raw('LOCATE("'.$request->term.'", trucks.truck_district)'), 'desc')
                    ->orderBy(DB::raw('LOCATE("'.$request->term.'", trucks.plateNumber)'), 'desc')
                    ->orderBy(DB::raw('LOCATE("'.$request->term.'", users.name)'), 'desc')
                    ->orderBy('routes.id', 'desc')
                    ->take(10)
                    ->get();

                return response()->json($res);
            }
        }
    }

    public function confirmRoute(Request $request)
    {
        $items = [];

        foreach($request->products as $key=>$value)
        {
            if ($request->qty[$key] - $request->changes[$key] > 0)
            {
                $items[] = [
                    'order_route_id' => $request->order_id,
                    'product_id' => $request->products[$key],
                    'qty' => -($request->qty[$key] - $request->changes[$key])
                ];
            }
        }

        DB::transaction(function () use ($request, $items)
        {
            $orderRoute = OrderRoute::find($request->order_id);
            $orderRoute->status = 1;
            $orderRoute->update();
    
            if(count($items) > 0)
            {
                OrderRouteLists::insert($items);
            }
    
            $order = Order::find($orderRoute->order_id);
            $routeCheck = OrderRouteLists::selectRaw('sum(route_lists.qty) as amount, route_lists.product_id')
            ->leftJoin('order_routes', 'order_routes.id', '=', 'route_lists.order_route_id')
            ->leftJoin('orders', 'orders.id', '=', 'order_routes.order_id')
            ->where('orders.id', '=', $orderRoute->order_id)
            ->groupBy('route_lists.product_id')
            ->get()->toArray();

            $orderArray = $order->products->toArray();

            $count = 0;
            $numProducts = count($orderArray);

            foreach($orderArray as $order)
            {
                foreach($routeCheck as $route)
                {
                    if ($order['product_id'] == $route['product_id'])
                    {
                        if ($order['qty'] != $route['amount'])
                        {
                            return redirect('routes');
                        }
                        $count++;
                    }
                }
            }

            if ($numProducts != $count)
            {
                return redirect('routes');
            }
    
            $order = Order::find($orderRoute->order_id);
            $order->order_status = "สำเร็จแล้ว";
            $order->update();
        });

        return redirect('routes/order');
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
                'order_id'             => 'required',
                'truck_id'          => 'required'
            ],
            [   
                'order_id.required'    => 'เกิดข้อผิดพลาดในการโหลดข้อมูลไอดีออเดอร์',
                'truck_id.required'    => 'โปรดเลือกพาหนะที่ใช้ในการขนส่งจากระบบ'
            ]
        );

        if (!$request->productId || count($request->productId) == 0)
        {
            return redirect()->back()->withErrors(['msg' => 'รายการสินค้ารอส่งต้องมีอย่างน้อย 1 รายการ']);
        }

        $order = Order::find($request->order_id);
        $order->order_status = "กำลังดำเนินการ";
        $order->update();

        $route = new OrderRoute;
        $route->fill($request->all());
        $route->save();

        foreach($request->productId as $key=>$value)
        {
            $items[] = [
                'order_route_id' => $route->id,
                'product_id' => $request->productId[$key],
                'qty' => $request->productLists[$key]
            ];
        }

        OrderRouteLists::insert($items);

        return redirect('routes/list');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);

        $order->load('products');
        $order->load('routes');

        // OrderRouteLists order_route_id


        if (count($order->routes))
        {
            foreach($order->routes as $key => $value)
            {
                $order->routes[$key]->route = OrderRouteLists::where('order_route_id', '=', $order->routes[$key]->id)->get()->toArray();
            }
        }

        return view('routes.create', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
