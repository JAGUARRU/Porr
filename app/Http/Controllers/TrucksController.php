<?php

namespace App\Http\Controllers;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Truck;
use App\Models\Tambon;
use Illuminate\Http\Request;
use Redirect;
use PDF;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;

use Illuminate\Validation\Rule;

class TrucksController extends Controller
{
    public function index()
    {
        $trucks = Truck::paginate(5);

        return view('trucks.index', ["trucks"=>$trucks]);
    }

    public function create()
    {
        $config = [
            'table' => 'trucks',
            'length' => 6,
            'prefix' => 'T-'
        ];
        
        $id = IdGenerator::generate($config);

        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();
        
        return view('trucks.create', compact('id','provinces','amphoes','tambons'));
    }

    public function store(StoreTruckRequest $request)
    {
        $truck = new Truck;
        $truck->fill($request->all());
        $truck->save();

        return Redirect::route('trucks.index')->with('status','Truck Added Successfully');
    }

    public function edit(Truck $truck)
    {
        $truck->load('user');

        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();

        return view('trucks.edit', compact('truck','provinces','amphoes','tambons'));
    }

    public function show($id)
    {
        $truck = Truck::where('id', '=', $id)->with(["routes" => function($res) {
            $res->orderBy('created_at', 'desc');
        }, "user"])->first();

        return view('trucks.show', compact('truck'));
    }

    public function update(UpdateTruckRequest $request, Truck $truck)
    {

        $validatedData = $request->validate([
            'id' => [
                'required',
                Rule::unique('trucks')->where(function ($query) use($request, $truck) {
                    return $query->where('id', $request->id);
                })->ignore($truck->id)
            ],
            'plateNumber' => [
                'required',
                Rule::unique('trucks')->where(function ($query) use($request, $truck) {
                    return $query->where('plateNumber', $request->plateNumber);
                })->ignore($truck->plateNumber, 'plateNumber')
            ]
        ], [
            'id.required'    => 'โปรดระบุรหัสรถ',
            'id.unique'    => 'รหัสรถได้ถูกใช้แล้ว', 
            'plateNumber.required'    => 'โปรดระบุหมายเลขป้ายทะเบียน',
            'plateNumber.unique'    => 'ป้ายทะเบียนที่ระบุได้ถูกใช้แล้ว'
        ]);


        $truck->fill($request->all());
        $truck->update();
        
        return Redirect::route('trucks.index')->with('status', $truck->id . ' ได้รับการปรับปรุงเรียบร้อยแล้ว');
    }

    public function destroy(Truck $truck_id)
    {
        $truck_id->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }

    public function drivers(Request $request)
    {
        dd($request);
    }
    
    public function product_print(Request $request)
    {
        $truck = Truck::where('id', '=', $request['id'])->with(["routes" => function($res) {
            $res->orderBy('created_at', 'desc');
        }, "user"])->first();

        $pdf = PDF::loadView('trucks.product_print', ['truck' => $truck]);
        return $pdf->stream();
    }
}
