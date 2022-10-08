<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        //

        return view('reports.index');
    }

    public function monthly_sales()
    {
        //

        return view('reports.sales');
    }

    public function monthly_orders()
    {
        //

        return view('reports.orders');
    }

    public function monthly_compare()
    {
        //

        return view('reports.compare');
    }
}
