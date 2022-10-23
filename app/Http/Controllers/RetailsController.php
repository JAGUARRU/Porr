<?php

namespace App\Http\Controllers;
use App\Models\Retail;
use App\Models\Tambon;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Redirect;

use App\Http\Requests\StoreRetailRequest;
use App\Http\Requests\UpdateRetailRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class RetailsController extends Controller
{
    public function index()
    {
        $retail = Retail::paginate(5);
        
        return view('retails.index', ["retail"=>$retail]);
    }

    public function create()
    {
        abort_if(Gate::denies('employee_retail_add_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();

        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        return view('retails.create')->with(compact('provinces','amphoes','tambons', 'id'));
    }

    public function store(StoreRetailRequest $request)
    {
        $retail = new Retail;
        $retail->fill($request->all());
        $retail->save();
        return Redirect::route('retails.index')->with('status','Retail Added Successfully');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_retail_edit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $retail = Retail::find($id);

        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();

        return view('retails.edit', compact('provinces','amphoes','tambons', 'retail'));
    }

    public function show($id)
    {
        $retail = Retail::where('id', '=', $id)->with(["orders" => function($res) {
            $res->orderBy('created_at', 'desc')->take(3);
        }])->first();

        return view('retails.show', compact('retail'));
    }

    public function update(UpdateRetailRequest $request, Retail $retail)
    {

        $validatedData = $request->validate([
            'id' => [
                'required',
                Rule::unique('retails')->where(function ($query) use($request, $retail) {
                    return $query->where('id', $request->id);
                })->ignore($retail->id)
            ]
        ],
        [
         'id.unique'=> 'รหัสร้านค้าซ้ำกัน'
        ]);
        

        $retail->fill($request->all());
        $retail->update();
        return Redirect::route('retails.index')->with('status','Retail Updated Successfully');
    }

    public function destroy(Retail $id)
    {
        $id->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
