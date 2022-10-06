<?php

namespace App\Http\Controllers;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Truck;
use App\Models\Tambon;
use Illuminate\Http\Request;
use Redirect;

class TrucksController extends Controller
{
    public function index()
    {
        $trucks = Truck::with(["routes" => function($res) {
            $res->where('status', '=', 0)->with('order')->orderBy('created_at', 'desc');
        }, "user"])->paginate(5);

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

        return view('trucks.create', compact('id'));
    }

    public function store(Request $request)
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
            $res->orderBy('created_at', 'desc')->take(1)->first();
        }, "user"])->first();

        return view('trucks.show', compact('truck'));
    }

    public function update(Request $request, Truck $truck)
    {


        $truck->fill($request->all());
        $truck->update();
        
        //return Redirect::route('trucks')->with('status','... Updated Successfully');
        //return view('trucks.index', ["trucks"=>$trucks]);

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
}
