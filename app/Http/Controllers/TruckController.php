<?php

namespace App\Http\Controllers;
use App\Models\Truck;
use Illuminate\Http\Request;
use Redirect;

class TruckController extends Controller
{
    public function index()
    {
        $trucks = Truck::with('employee')->paginate(5);
        return view('trucks.trucks', ["trucks"=>$trucks]);
    }

    public function create()
    {
        return view('trucks.create');
    }

    public function store(Request $request)
    {
        $truck = new Truck;
        $truck->truck_id = $request->input('truck_id');
        $truck->save();

        return Redirect::route('trucks')->with('status','Truck Added Successfully');
    }

    public function edit($truck_id)
    {
        $truck = Truck::find($truck_id);

        return view('trucks.edit', compact('truck'));
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
