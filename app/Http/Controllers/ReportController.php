<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Order;
use DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = intval($request->input('year'));
        if ($selectedYear == 0)
        {
            $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        }
 
        $reports = Order::select(
            DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
            DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
            DB::raw('SUM(order_lists.total) as sale'), 
            DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
        ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
        ->where('orders.order_status', '=', 'สำเร็จแล้ว')
        ->whereYear('orders.order_date', $selectedYear)
        ->groupBy('year', 'month')
        ->get();

        $orderArray = Order::select(
                DB::raw('COUNT(orders.id) as order_count'), 
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereYear('orders.order_date', $selectedYear)
            ->groupBy('year', 'month')
            ->get();

        foreach($reports as $key=>$value)
        {
            foreach($orderArray as $orderKey=>$orderValue)
            {
                if ($reports[$key]->labels == $orderArray[$key]->labels)
                {
                    $reports[$key]->order_count = $orderArray[$key]->order_count;
                }
            }
        }

        return view('reports.index', compact('reports'));
    }

    public function monthly_sales(Request $request)
    {

        $selectedYear = intval($request->input('year'));
        if ($selectedYear == 0)
        {
            $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        }
 
        $reports = Order::select(
            DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
            DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
            DB::raw('SUM(order_lists.total) as sale'), 
            DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
        ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
        ->where('orders.order_status', '=', 'สำเร็จแล้ว')
        ->whereYear('orders.order_date', $selectedYear)
        ->groupBy('year', 'month')
        ->get();

        return view('reports.sales', compact('reports'));
    }

    public function monthly_orders(Request $request)
    {
        $selectedYear = intval($request->input('year'));
        if ($selectedYear == 0)
        {
            $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        }

        $reports = Order::select(
            DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
            DB::raw('COUNT(orders.id) as order_count'), 
            DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
            DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
        ->where('orders.order_status', '=', 'สำเร็จแล้ว')
        ->whereYear('orders.order_date', $selectedYear)
        ->groupBy('year', 'month')
        ->get();

        return view('reports.orders', compact('reports'));
    }

    public function monthly_compare()
    {
        //

        return view('reports.compare');
    }
}
