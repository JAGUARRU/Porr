<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Models\Order;
use DB;
use PDF;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return ReportController::monthly_sales($request);

        if ($request->input('startDate') != null && $request->input('endDate') 
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate')) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate')) !== false)
        {
            $from = $request->input('startDate');
            $to = $request->input('endDate');

            $reports = Order::select(
                DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('SUM(order_lists.total) as sale'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereBetween('orders.order_date', [$from, $to])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->get();
    
            $orderArray = Order::select(
                    DB::raw('COUNT(orders.id) as order_count'), 
                    DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                    DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
                ->where('orders.order_status', '=', 'สำเร็จแล้ว')
                ->whereBetween('orders.order_date', [$from, $to])
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
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
        $input = array();

        $selectedYear = intval($request->input('year'));
        if ($selectedYear == 0)
        {
            $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        }

        $input['year'] = $selectedYear;
        
        if ($request->input('startDate') != null && $request->input('endDate') 
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate')) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate')) !== false)
        {
            $from = $request->input('startDate');
            $to = $request->input('endDate');

            $reports = Order::select(
                DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('SUM(order_lists.total) as sale'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereBetween('orders.order_date', [$from, $to])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->get();
    
            $input['startDate'] = $from;
            $input['endDate'] = $to;

            return view('reports.sales', compact('reports', 'input'));
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

        return view('reports.sales', compact('reports', 'input'));
    }

    public function monthly_orders(Request $request)
    {

        $input = array();

        $selectedYear = intval($request->input('year'));
        if ($selectedYear == 0)
        {
            $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        }

        $input['year'] = $selectedYear;

        if ($request->input('startDate') != null && $request->input('endDate') 
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate')) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate')) !== false)
        {
            $from = $request->input('startDate');
            $to = $request->input('endDate');

            $reports = Order::select(
                DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
                DB::raw('COUNT(orders.id) as order_count'), 
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereBetween('orders.order_date', [$from, $to])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->get();
    
            $input['startDate'] = $from;
            $input['endDate'] = $to;

            return view('reports.orders', compact('reports', 'input'));
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

        return view('reports.orders', compact('reports', 'input'));
    }

    public function sales_pdf(Request $request)
    {
        $input = array();
        $input['startDate'] = null;
        $input['endDate'] = null;

        $selectedYear = intval($request->input('year'));
        if ($selectedYear == 0)
        {
            $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        }
        
        $input['year'] = $selectedYear;

        if ($request->input('startDate') != null && $request->input('endDate') 
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate')) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate')) !== false)
        {
            $from = $request->input('startDate');
            $to = $request->input('endDate');

            $reports = Order::select(
                DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('SUM(order_lists.total) as sale'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereBetween('orders.order_date', [$from, $to])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->get()->toArray();
    
            $input['startDate'] = $from;
            $input['endDate'] = $to;

            $pdf = PDF::loadView('reports.sales_pdf', ['reports' => $reports, 'input' => $input]);
            return $pdf->stream();
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
        ->get()->toArray();

        $pdf = PDF::loadView('reports.sales_pdf', ['reports' => $reports, 'input' => $input]);
        return $pdf->stream();
    }

    public function orders_pdf(Request $request)
    {
        $input = array();
        $input['startDate'] = null;
        $input['endDate'] = null;
        
        $selectedYear = intval($request->input('year'));
        if ($selectedYear == 0)
        {
            $selectedYear = intval(\Carbon\Carbon::now()->format('Y'));
        }
        
        $input['year'] = $selectedYear;

        if ($request->input('startDate') != null && $request->input('endDate') 
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate')) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate')) !== false)
        {
            $from = $request->input('startDate');
            $to = $request->input('endDate');

            $reports = Order::select(
                DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
                DB::raw('COUNT(orders.id) as order_count'), 
                DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
                DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
            ->where('orders.order_status', '=', 'สำเร็จแล้ว')
            ->whereBetween('orders.order_date', [$from, $to])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->get();
    
            $input['startDate'] = $from;
            $input['endDate'] = $to;

            $pdf = PDF::loadView('reports.orders_pdf', ['reports' => $reports, 'input' => $input]);
            return $pdf->stream();
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

        $pdf = PDF::loadView('reports.orders_pdf', ['reports' => $reports, 'input' => $input]);
        return $pdf->stream();
    }

    public function monthly_compare(Request $request)
    {
        $input = array();
  
        if ($request->input('startDate') != null && $request->input('endDate') != null
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate')) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate')) !== false)
        {
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate'))->format('Y-m');
            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate'))->format('Y-m');
        }
        else
        {
            $from = \Carbon\Carbon::now()->format('Y-m');
            $to = \Carbon\Carbon::now()->subMonth()->format('Y-m');
        }

    
        $reports = Order::select(
            DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
            DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
            DB::raw('SUM(order_lists.total) as sale'), 
            DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
        ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
        ->where('orders.order_status', '=', 'สำเร็จแล้ว')
        ->where(fn($query) => $query->where(DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m")'), '=', $from)->orWhere(DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m")'), '=', $to))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->get();


        $input['startDate'] = $from;
        $input['endDate'] = $to;

        return view('reports.compare', compact('reports', 'input'));
    }

    public function compare_pdf(Request $request)
    {
        $input = array();
        $input['startDate'] = null;
        $input['endDate'] = null;

        if ($request->input('startDate') != null && $request->input('endDate') 
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate')) !== false
            && \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate')) !== false)
        {
            $from = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('startDate'))->format('Y-m');
            $to = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('endDate'))->format('Y-m');
        }
        else
        {
            $from = \Carbon\Carbon::now()->format('Y-m');
            $to = \Carbon\Carbon::now()->subMonth()->format('Y-m');
        }

    
        $reports = Order::select(
            DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m-%d %H:%i:%s") as datetime'),
            DB::raw('DATE_FORMAT(orders.order_date, "%b") as labels'), 
            DB::raw('SUM(order_lists.total) as sale'), 
            DB::raw('YEAR(orders.order_date) year, MONTH(orders.order_date) month'))
        ->join('order_lists', 'orders.id', '=', 'order_lists.order_id')
        ->where('orders.order_status', '=', 'สำเร็จแล้ว')
        ->where(fn($query) => $query->where(DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m")'), '=', $from)->orWhere(DB::raw('DATE_FORMAT(orders.order_date, "%Y-%m")'), '=', $to))
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->get();


        $input['startDate'] = $from;
        $input['endDate'] = $to;

        $pdf = PDF::loadView('reports.compare_pdf', ['reports' => $reports, 'input' => $input]);
        return $pdf->stream();
    }
}
