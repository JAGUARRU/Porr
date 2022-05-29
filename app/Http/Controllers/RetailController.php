<?php

namespace App\Http\Controllers;
use App\Models\Retail;
use Illuminate\Http\Request;
use Redirect;

class RetailController extends Controller
{
    public function index()
    {
        $retail = Retail::paginate(5);

        return view('retail.retail', ["retail"=>$retail]);
    }

    public function create()
    {
        return view('retail.create');
    }

    public function store(Request $request)
    {
        $retail = new Retail;
        $retail->retail_id = $request->input('retail_id');
        $retail->retail_name = $request->input('retail_name');
        $retail->retail_address = $request->input('retail_address');
        $retail->retail_district = $request->input('retail_district');
        $retail->retail_sub_district = $request->input('retail_sub_district');
        $retail->retail_postcode = $request->input('retail_postcode');
        $retail->retail_phone = $request->input('retail_phone');
        $retail->retail_contact = $request->input('retail_contact');
        $retail->save();
        return Redirect::route('retail')->with('status','Retail Added Successfully');
    }

    public function edit($retail_id)
    {
        $retail = Retail::find($retail_id);
        return view('retail.edit', compact('retail'));
    }

    public function update(Request $request, $retail_id)
    {
        $retail = Retail::find($retail_id);
        $retail->retail_name = $request->input('retail_name');
        $retail->retail_address = $request->input('retail_address');
        $retail->retail_district = $request->input('retail_district');
        $retail->retail_sub_district = $request->input('retail_sub_district');
        $retail->retail_postcode = $request->input('retail_postcode');
        $retail->retail_phone = $request->input('retail_phone');
        $retail->retail_contact = $request->input('retail_contact');
        $retail->update();
        return Redirect::route('retail')->with('status','Retail Updated Successfully');
    }

    public function destroy(Retail $retail_id)
    {
        $retail_id->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
