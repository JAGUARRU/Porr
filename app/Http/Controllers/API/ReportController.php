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
        $listArray = Order::select(
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('SUM(order_lists.total) as sale'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->groupBy('year', 'month')
            ->leftJoin('order_lists', 'orders.id', '=', 'order_lists.order_id')
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->get()
            ->toArray();

        // select date_format(created_at,'%b') as labels, sum(total) as sale from order_lists group by year(created_at),month(created_at) order by year(created_at), month(created_at);
        return response()->json($listArray);
    }
}
