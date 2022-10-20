<?php

namespace App\Http\Controllers;
use App\Models\Retail;
use App\Models\Tambon;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Redirect;

class RetailsController extends Controller
{
    public function index()
    {
        $retail = Retail::paginate(5);
        
        return view('retails.index', ["retail"=>$retail]);
    }

    public function create()
    {
        $provinces = Tambon::select('province')->distinct()->get();
        $amphoes = Tambon::select('amphoe')->distinct()->get();
        $tambons = Tambon::select('tambon')->distinct()->get();

        $id = IdGenerator::generate(['table' => 'retails', 'length' => 10, 'prefix' =>'RETAIL-']);
        return view('retails.create')->with(compact('provinces','amphoes','tambons', 'id'));
    }

    public function store(Request $request)
    {

        $this->validate(
            $request, 
            [   
                'retail_province'          => 'required|string',
                'retail_district'          => 'required|string',
                'retail_sub_district'      => 'required|string',
                'retail_postcode'          => 'required|numeric'
            ],
            [   
                'retail_province.required'    => 'โปรดระบุจังหวัด',
                'retail_district.required'    => 'โปรดระบุอำเภอ',
                'retail_sub_district.required'    => 'โปรดระบุตำบล',
                'retail_postcode.required'    => 'โปรดระบุรหัสไปรษณี',
                'retail_postcode.numeric'    => 'รหัสไปรษณีต้องเป็นตัวเลขเท่านั้น'
            ]
        );

        $retail = new Retail;
        $retail->id = $request->input('id');
        $retail->retail_name = $request->input('retail_name');
        $retail->retail_address = $request->input('retail_address');
        $retail->retail_province = $request->input('retail_province');
        $retail->retail_district = $request->input('retail_district');
        $retail->retail_sub_district = $request->input('retail_sub_district');
        $retail->retail_postcode = $request->input('retail_postcode');
        $retail->retail_phone = $request->input('retail_phone');
        $retail->retail_contact = $request->input('retail_contact');
        $retail->save();
        return Redirect::route('retails.index')->with('status','Retail Added Successfully');
    }

    public function edit($id)
    {
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

    public function update(Request $request, $id)
    {

        $this->validate(
            $request, 
            [   
                'retail_province'          => 'required|string',
                'retail_district'          => 'required|string',
                'retail_sub_district'      => 'required|string',
                'retail_postcode'          => 'required|numeric'
            ],
            [   
                'retail_province.required'    => 'โปรดระบุจังหวัด',
                'retail_district.required'    => 'โปรดระบุอำเภอ',
                'retail_sub_district.required'    => 'โปรดระบุตำบล',
                'retail_postcode.required'    => 'โปรดระบุรหัสไปรษณี',
                'retail_postcode.numeric'    => 'รหัสไปรษณีต้องเป็นตัวเลขเท่านั้น'
            ]
        );

        
        $retail = Retail::find($id);
        $retail->retail_name = $request->input('retail_name');
        $retail->retail_address = $request->input('retail_address');
        $retail->retail_province = $request->input('retail_province');
        $retail->retail_district = $request->input('retail_district');
        $retail->retail_sub_district = $request->input('retail_sub_district');
        $retail->retail_postcode = $request->input('retail_postcode');
        $retail->retail_phone = $request->input('retail_phone');
        $retail->retail_contact = $request->input('retail_contact');
        $retail->update();
        return Redirect::route('retails.index')->with('status','Retail Updated Successfully');
    }

    public function destroy(Retail $id)
    {
        $id->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
