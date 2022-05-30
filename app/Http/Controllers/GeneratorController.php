<?php

namespace App\Http\Controllers;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Retail;
use App\Models\Truck;
use App\Models\Order;

class GeneratorController extends Controller
{
    function save(Request $request){
     
        $emp_name = $request->emp_name;
        $prod_name = $request->prod_name;
        $retail_name = $request->retail_name;
        $truck_name = $request->truck_name;
        $order_name = $request->order_name;
        $emp_id = Helper::IDGenerator(new Generator, 'emp_id', 4, 'EMP');
        $prod_id = Helper::IDGenerator(new Generator, 'prod_id', 4, 'PROD');
        $retail_id = Helper::IDGenerator(new Generator, 'retail_id', 4, 'RT');
        $truck_id = Helper::IDGenerator(new Generator, 'truck_id', 4, 'TRUCK');
        $order_id = Helper::IDGenerator(new Generator, 'order_id', 4, 'OD');
        
        $q = new Generator;
        $q->emp_id = $emp_id;
        $q->prod_id = $prod_id;
        $q->retail_id = $retail_id;
        $q->truck_id = $truck_id;
        $q->order_id = $order_id;
        $q->emp_name = $emp_name;
        $q->prod_name = $prod_name;
        $q->retail_name = $retail_name;
        $q->truck_name = $truck_name;
        $q->order_name = $order_name;
        $q->save();
 }
}
