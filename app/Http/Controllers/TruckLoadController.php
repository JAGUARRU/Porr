<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use App\Models\Order;
use App\Models\Truck;
use App\Models\TruckRoute;
use App\Models\TruckRouteList;
use Illuminate\Validation\Rule;
use DB;
use PDF;

class TruckLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trucks = Truck::query()
        ->select('trucks.*','truck_routes.transportDate','truck_routes.confirmDate', 'truck_routes.route_status as route_status', DB::raw('COUNT(truck_routes.id) as routes_count'))
        ->leftJoin("truck_routes", function ($join) {
            $join->on('trucks.id', '=', 'truck_routes.truck_id')->On('truck_routes.route_status', '!=', DB::raw('2'));
        })
        ->where('truck_status', '=', 1)
        ->orderBy('truck_routes.transportDate', 'ASC')
        ->orderBy(DB::raw('truck_routes.confirmDate IS NULL', 'truck_routes.confirmDate'), 'DESC')
        ->orderBy('truck_routes.route_status', 'ASC')
        ->groupBy('trucks.id')
        ->paginate(5);

        $orders = Order::where('order_status', '=', 'รอดำเนินการ')
        ->withCount('products')
        ->orderBy(DB::raw('order_transportDate IS NULL', 'order_transportDate'), 'ASC')
        ->orderBy('order_transportDate', 'ASC')
        ->orderBy('created_at', 'desc')
        ->paginate(5);

        return view('truckloads.index', compact('trucks', 'orders'));
    }

    public function view($id)
    {
        
        $truckRoutes = Truck::query()
        ->select('trucks.*','truck_routes.transportDate','truck_routes.confirmDate', 'truck_routes.route_status as route_status', DB::raw('COUNT(truck_routes.id) as routes_count'))
        ->leftJoin("truck_routes", function ($join) {
            $join->on('trucks.id', '=', 'truck_routes.truck_id');
        })
        ->where('trucks.id', '=', $id)
        ->where('truck_status', '=', 1)
        ->orderBy('truck_routes.transportDate', 'ASC')
        ->orderBy(DB::raw('truck_routes.confirmDate IS NULL', 'truck_routes.confirmDate'), 'DESC')
        ->orderBy('truck_routes.route_status', 'ASC')
        ->groupBy('truck_routes.id')
        ->first();


        if (!$truckRoutes)
        {
            return redirect()->back();
        }


        return view('truckloads.view', compact('truckRoutes'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'truck_id' => ['required', 'string'],
            'truck_driver' => ['required', 'string'],
            'truck_plateNumber' => ['required', 'string'],
            'order_id' => [
                'required',
                Rule::unique('truck_route_lists')->where(function ($query) use($request) {
                    return $query->where('order_id', $request->input('order_id'));
                })
            ]
        ],
        [
            'truck_id.required'=> 'โปรดเลือกรถก่อนโหลดออเดอร์',
            'truck_driver.required'=> 'ไม่พบชื่อคนขับ',
            'truck_plateNumber.required'=> 'ไม่พบป้ายทะเบียนรถ',
            'order_id.required'=> 'เกิดข้อผิดพลาดในการโหลดข้อมูลออเดอร์',
            'order_id.unique'=> 'ออเดอร์นี้ได้อยู่โหลดอยู่แล้ว'
        ]);

        // ต้องสร้างเส้นทางใหม่ไหม
        $id = DB::transaction(function () use ($request)
        {
            $truckRoutes = null;

            if (!$request->route_id)
            {
                // สร้างใหม่
                $truckRoutes = new TruckRoute;
                $truckRoutes->truck_id = $request->truck_id;
                $truckRoutes->truck_driver = $request->truck_driver;
                $truckRoutes->truck_plateNumber = $request->truck_plateNumber;
                $truckRoutes->save();
            }
            else
            {
                $truckRoutes = TruckRoute::find($request->route_id);
            }

            // ตั้งออเดอร์ให้อยู่กับเส้นทางที่เลือก/สร้าง
            $routeItem = new TruckRouteList;
            $routeItem->truck_route_id = $truckRoutes->id;
            $routeItem->order_id = $request->order_id;
            $routeItem->route_list_status = 0;
            $routeItem->save();

            // เปลี่ยนวันที่จัดส่งออเดอร์ถ้าหากวันที่กำหนดส่งได้ถูกเซตไว้
            $order = Order::find($request->order_id);

            if ($truckRoutes->transportDate)
            {
                $order->order_transportDate = $truckRoutes->transportDate;
            }

            $order->order_status = "กำลังดำเนินการ";
            $order->update();

            return $truckRoutes->id;
        });

        return TruckLoadController::edit($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $route = TruckRoute::find($id);
        if (!$route)
        {
            return TruckLoadController::index();
        }

        $route->load("lists");

        return view('truckloads.edit', compact('route'));
    }

    public function update(Request $request, $id)
    {
        $route = TruckRoute::find($id);

        if ($request->route_status == "2")
        {
            $exists = TruckRouteList::where('truck_route_id', $id)->where('route_list_status', "!=", "1")->count();
            if ($exists > 0)
            {
                return redirect()->back()->withErrors(['msg' => 'มีออเดอร์ที่ยังค้างส่งอยู่']);
            }
            
            $route->confirmDate = now();
        }

        $route->fill($request->all());
        $route->update();

        return redirect()->route('truckloads.edit_route', ['id' => $id])->with('status','อัปเดตข้อมูลสำเร็จแล้ว!!');
    }

    public function update_order(Request $request, $id)
    {
        $order_id = $request->query('order_id');

        switch($request->query('type'))
        {
            case "toggle":
                DB::transaction(function () use ($order_id, $id)
                {
                    $routes = TruckRouteList::where('truck_route_id', $id)->where('order_id', $order_id)->get()->first();
                    if ($routes->route_list_status == Helper::GetRouteListStatus(0))
                    {
                        $routes->route_list_status = 1;
                    }
                    else
                    {
                        $routes->route_list_status = 0;
                    }
                    $routes->update();

                    $order = Order::find($order_id);
                    $order->order_status = ($routes->route_list_status == Helper::GetRouteListStatus(0)) ? "กำลังดำเนินการ" : "สำเร็จแล้ว";
                    $order->update();
                });
                break;

            case "cancel":
                DB::transaction(function () use ($order_id, $id)
                {
                    $routes = TruckRouteList::where('order_id', '=', $order_id);
                    $routes->delete();

                    $count = TruckRouteList::where('truck_route_id', $id)->count();
                    if (!$count)
                    {
                        TruckRoute::find($id)->delete();
                    }
                    
                    $order = Order::find($order_id);
                    $order->order_status = "รอดำเนินการ";
                    $order->update();
                });
                break;
        }

        return redirect()->route('truckloads.edit_route', ['id' => $id])->with('status','อัปเดตข้อมูลสำเร็จแล้ว!!');
    }

    public function destroy($id)
    {
        //
    }

    public function load_order($id)
    {

        $order = Order::find($id);

        if (!$order || $order->order_status != "รอดำเนินการ")
        {
            return redirect()->back();
        }

        $order->load('retail');
    
        $trucks = Truck::query()
                ->select(
                    'users.*',
                    'users.id as user_id', 
                    'truck_routes.*',
                    'truck_routes.id as route_id', 
                    'truck_routes.route_status as route_status', 
                    'trucks.*',
                    'trucks.id as truck_id', 
                    DB::raw('case when trucks.truck_district = "'.$order->retail->retail_district.'" then 1 else 0 end as match_district'), 
                    DB::raw('COUNT(truck_routes.id) as routes_count'))
                ->leftJoin('users', 'users.id', '=', 'trucks.user_id')
                ->leftJoin("truck_routes", function ($join) {
                    $join->on('trucks.id', '=', 'truck_routes.truck_id')->On('truck_routes.route_status', '!=', DB::raw('2'));
                })
                ->orderBy(DB::raw('LOCATE("'.$order->retail->retail_district.'", trucks.truck_district)'), 'desc')
                ->orderBy('truck_routes.transportDate', 'ASC')
                ->orderBy(DB::raw('match_district'), 'DESC')
                ->groupBy('trucks.id')
                ->where('truck_status', '=', 1)
                ->where(fn($query) => $query->whereDate("truck_routes.transportDate",">=",now())->orWhereNull("truck_routes.transportDate"))
                ->get();
          

        return view('truckloads.load_order', compact('order', 'trucks'));
    }

    public function view_route($id)
    {

        return view('truckloads.view_route');
    }

    public function routes()
    {
        $trucks = Truck::query()
        ->select('trucks.*','truck_routes.id as route_id','truck_routes.transportDate','truck_routes.confirmDate', 'truck_routes.route_status as route_status', DB::raw('COUNT(truck_routes.id) as routes_count'))
        ->leftJoin("truck_routes", function ($join) {
            $join->on('trucks.id', '=', 'truck_routes.truck_id')->On('truck_routes.route_status', '!=', DB::raw('2'));
        })
        ->where('truck_status', '=', 1)->where('truck_routes.route_status', '=', 1)
        ->orderBy('truck_routes.transportDate', 'ASC')
        ->orderBy(DB::raw('truck_routes.confirmDate IS NULL', 'truck_routes.confirmDate'), 'DESC')
        ->orderBy('truck_routes.route_status', 'ASC')
        ->groupBy('trucks.id')
        ->paginate(5);

        return view('truckloads.routes', compact('trucks'));
    }

    public function print_route($id)
    {
        $orderRoute = TruckRouteList::where('truck_route_id', $id)->with('order')->get();
        
        $pdf = PDF::loadView('truckloads.print_route', ['orderRoute'=>$orderRoute]);
        return $pdf->stream();
    }
}
