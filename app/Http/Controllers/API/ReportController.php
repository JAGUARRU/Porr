<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use DB;

use App\Models\Order;
use App\Models\OrderList;

class ReportController extends Controller
{
    public function salesChart(Request $request)
    {
        $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        
        $listArray = Order::select(
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('SUM(order_lists.total) as sale'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereYear('orders.order_date', $selectedYear)
            ->groupBy('year', 'month')
            ->get()
            ->toArray();

        $orderArray = Order::select(
                DB::raw('COUNT(orders.id) as order_count'), 
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereYear('orders.order_date', $selectedYear)
            ->groupBy('year', 'month')
            ->get()
            ->toArray();

        foreach($listArray as $key=>$value)
        {
            foreach($orderArray as $orderKey=>$orderValue)
            {
                if ($listArray[$key]['labels'] == $orderArray[$key]['labels'])
                {
                    $listArray[$key]['order_count'] = $orderArray[$key]['order_count'];
                }
            }
        }
    
        return response()->json($listArray);
    }
}
