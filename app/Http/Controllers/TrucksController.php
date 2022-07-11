<?php

namespace App\Http\Controllers;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Truck;
use Illuminate\Http\Request;
use Redirect;

class TrucksController extends Controller
{
    public function index()
    {
        $trucks = Truck::with('user')->paginate(5);
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
        $truck->truck_id = $request->input('truck_id');
        $truck->save();

        return Redirect::route('trucks')->with('status','Truck Added Successfully');
    }

    public function show($truck_id)
    {
        $truck = Truck::find($truck_id);
        return view('trucks.edit', compact('truck', 'id'));
    }

    public function update(Request $request, $truck_id)
    {
        $truck = Truck::find($truck_id);
        $truck->update();
        
        return Redirect::route('trucks')->with('status','... Updated Successfully');
    }

    public function destroy(Truck $truck_id)
    {
        $truck_id->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
