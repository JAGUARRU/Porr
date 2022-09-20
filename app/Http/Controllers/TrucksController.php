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
        $truck->fill($request->all());
        $truck->save();

        return Redirect::route('trucks.index')->with('status','Truck Added Successfully');
    }

    public function show(Truck $truck)
    {
        $trucks = Truck::query();

        $truck->user = $trucks
            ->select('users.*','users.id as user_id')
            ->leftJoin('users', 'users.id', '=', 'trucks.user_id')
            ->where("trucks.id","=",$truck->id)
            ->first()->toArray();

        return view('trucks.edit', compact('truck'));
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
