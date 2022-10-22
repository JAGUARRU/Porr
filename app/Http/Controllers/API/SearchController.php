<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Retail;
use App\Models\Truck;
use App\Models\Product;
use App\Models\Order;
use App\Models\TruckRoute;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $res = array();

        if (Gate::check('employee_view_access'))
        {
            $resultArray = User::query()
            ->select('users.id', 'users.empId', 'users.name')
            ->where(fn($query) => $query->where("empId","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%"))
            ->get()->toArray();
    
            foreach($resultArray as $user)
            {
                array_push($res, array("title"=> $user['empId']. ": " . $user['name'], "url"=>"users/".$user['id'], "category"=>"ผู้ใช้"));
            }
        }

        $resultArray = Product::query()
        ->where(fn($query) => $query->where("prod_name","LIKE","%{$request->term}%")->orWhere("prod_type_name","LIKE","%{$request->term}%"))
        ->get();

        foreach($resultArray as $product)
        {
            array_push($res, array("title"=> $product['id']. ": " . $product['prod_name'] . ' ประเภท: ' . $product['prod_type_name'], "url"=>"products/".$product['id'], "category"=>"สินค้า"));
        }

        $resultArray = Retail::query()
        ->where(fn($query) => $query->where("retail_name","LIKE","%{$request->term}%")->orWhere("id","LIKE","%{$request->term}%")->orWhereNull("retail_name"))
        ->get();

        foreach($resultArray as $retail)
        {
            array_push($res, array("title"=> $retail['id']. ": " . $retail['retail_name'], "url"=>"retails/".$retail['id'], "category"=>"ร้านค้า"));
        }

        $resultArray = Truck::query()->select('users.*','users.id as user_id', 'trucks.*','trucks.id as truck_id')
        ->leftJoin('users', 'users.id', '=', 'trucks.user_id')
        ->where(fn($query) => $query->where("plateNumber","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%")->orWhere("trucks.id","LIKE","%{$request->term}%")->orWhereNull("name"))
        ->get();

        foreach($resultArray as $truck)
        {
            array_push($res, array("title"=> $truck['id']. ": " . ($truck['name'] ? $truck['name'] : ("ไม่พบคนขับ")) . " (" . $truck['plateNumber'] . ")", "url"=>"trucks/".$truck['id'], "category"=>"รถยนต์"));
        }

        $resultArray = Order::query()
        ->where(fn($query) => $query->where("id","LIKE","%{$request->term}%")->orWhere("order_status","LIKE","%{$request->term}%"))
        ->withCount('products')->orderBy('created_at', 'desc')->get();

        foreach($resultArray as $order)
        {
            array_push($res, array("title"=> $order['id'] . ' สถานะ' . $order['order_status'] . ' (สินค้า '. $order->products_count .' รายการ)', "url"=>"orders/".$order['id'], "category"=>"ออเดอร์"));
        }

        return response()->json($res);
    }

    public function truck_load(Request $request)
    {
        $res = Truck::query()
            ->select(
                'users.*',
                'users.id as user_id', 
                'truck_routes.*',
                'truck_routes.id as route_id', 
                'truck_routes.route_status as route_status', 
                'trucks.*',
                'trucks.id as truck_id', 
                DB::raw('case when trucks.truck_district = "'.$request->district.'" then 1 else 0 end as match_district'))
            ->leftJoin('users', 'users.id', '=', 'trucks.user_id')
            ->leftJoin("truck_routes", function ($join) {
                $join->on('trucks.id', '=', 'truck_routes.truck_id')->On('truck_routes.route_status', '!=', DB::raw('2'));
            })
            ->orderBy(DB::raw('LOCATE("'.$request->term.'", trucks.truck_district)'), 'desc')
            ->orderBy(DB::raw('LOCATE("'.$request->term.'", trucks.plateNumber)'), 'desc')
            ->orderBy(DB::raw('LOCATE("'.$request->term.'", users.name)'), 'desc')
            ->orderBy('truck_routes.transportDate', 'ASC')
            ->orderBy(DB::raw('match_district'), 'DESC')
            ->where('trucks.truck_status', '=', 1)
            ->groupBy('trucks.id')
            ->get();

        return response()->json($res);
    }

    public function truck_route(Request $request)
    {
        $trucks = TruckRoute::query()
                ->select(
                    'truck_routes.*',
                    'truck_routes.id as route_id', 
                    'truck_routes.route_status as route_status', 
                    'trucks.*',
                    'trucks.id as truck_id',
                    DB::raw('COUNT(truck_routes.id) as routes_count'))
                ->leftJoin("trucks", function ($join) {
                    $join->on('trucks.id', '=', 'truck_routes.truck_id')->On('truck_routes.route_status', '!=', DB::raw('2'));
                })
                ->orderBy('truck_routes.transportDate', 'ASC')
                ->groupBy('trucks.id')
                ->where('trucks.id', '=', $request->truckId)
                ->where(fn($query) => $query->whereDate("truck_routes.transportDate",">=",now())->orWhereNull("truck_routes.transportDate"))
                ->get();


        $order = Order::find($request->orderId);

        foreach($trucks as $truck)
        {
            $diffDays = now()->diffInDays(\Carbon\Carbon::parse($truck->transportDate), false);

            $transportDiff = 0;
    
            if ($truck->transportDate && $order->order_transportDate)
                $transportDiff = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', Helper::DateTimeStringToEndOfDay($truck->transportDate))->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->order_transportDate), false);

            $truck['checkMatches'] = array('diffDays' => $diffDays, 'transportDiff' => $transportDiff, 'orderTransportDate' => $order->order_transportDate, 'district' => $order->retail_district == $truck->truck_district);
        }

        return response()->json($trucks);
    }
}
