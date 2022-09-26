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

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $res = array();

        $resultArray = User::query()
        ->select('users.id', 'users.empId', 'users.name')
        ->where(fn($query) => $query->where("empId","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%"))
        ->take(5)->get()->toArray();

        foreach($resultArray as $user)
        {
            array_push($res, array("title"=> $user['empId']. ": " . $user['name'], "url"=>"users/".$user['id']."/edit", "category"=>"ผู้ใช้"));
        }

        $resultArray = Product::query()
        ->where("prod_name","LIKE","%{$request->term}%")->take(5)->get();

        foreach($resultArray as $product)
        {
            array_push($res, array("title"=> $product['id']. ": " . $product['prod_name'], "url"=>"products/".$product['id'], "category"=>"สินค้า"));
        }

        $resultArray = Retail::query()
        ->where("retail_name","LIKE","%{$request->term}%")->take(5)->get();

        foreach($resultArray as $retail)
        {
            array_push($res, array("title"=> $retail['id']. ": " . $retail['retail_name'], "url"=>"retails/".$retail['id'], "category"=>"ร้านค้า"));
        }

        $resultArray = Truck::query()->select('users.*','users.id as user_id', 'trucks.*','trucks.id as truck_id')
        ->leftJoin('users', 'users.id', '=', 'trucks.user_id')
        ->where(fn($query) => $query->where("plateNumber","LIKE","%{$request->term}%")->orWhere("name","LIKE","%{$request->term}%"))
        ->groupBy('trucks.id')
        ->take(5)
        ->get();

        foreach($resultArray as $truck)
        {
            array_push($res, array("title"=> $truck['id']. ": " . ($truck['name'] ? $truck['name'] : ("ไม่พบคนขับ")) . " (" . $truck['plateNumber'] . ")", "url"=>"trucks/".$truck['id'], "category"=>"รถยนต์"));
        }

        $resultArray = Order::query()
        ->where("id","LIKE","%{$request->term}%")->take(5)->get();

        foreach($resultArray as $order)
        {
            array_push($res, array("title"=> $order['id'], "url"=>"orders/".$order['id'], "category"=>"ออเดอร์"));
        }

        return response()->json($res);
    }
}
