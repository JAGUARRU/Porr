<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Redirect;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::query()->orderBy('prod_status', 'DESC')->paginate(5);
        return view('products.index', ["products"=>$products]);
    }

    public function create()
    {
        abort_if(Gate::denies('employee_product_add_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $config = [
            'table' => 'products',
            'length' => 10,
            'prefix' => 'PROD-'
        ];
        
        $id = IdGenerator::generate($config);
        $categories = ProductCategory::orderBy('id','desc')->get();

        return view('products.create')->with(compact('categories', 'id'));
    }

    public function store(StoreProductRequest $request)
    {

        $validatedData = $request->validate([
            'prod_name' => [
                Rule::unique('products')->where(function ($query) use($request) {
                    return $query->where('prod_name', $request->input('prod_name'))->where('prod_type_name', $request->input('prod_type_name'));
                })
            ]
        ],
        [
         'prod_name.unique'=> 'รายการสินค้าซ้ำกัน (ชื่อสินค้าและประเภทสินค้านี้มีอยู่ในฐานข้อมูลแล้ว)'
        ]);

        $product = new Product;
        $product->id = $request->input('id');
        $product->prod_name = $request->input('prod_name');
        $product->prod_price = $request->input('prod_price');
        $product->prod_type_name = $request->input('prod_type_name');
        $product->prod_detail = $request->input('prod_detail');
 
        $product->save();
        return Redirect::route('products.index')->with('status','Product Added Successfully');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_product_edit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product = Product::find($id);
        $categories = ProductCategory::orderBy('id','desc')->get();
        return view('products.edit', compact(['product', 'categories']));
    }

    public function show(Product $product)
    {
        return view('products.show', compact(['product']));
    }

    public function patch(Request $request, $id)
    {
        abort_if(Gate::denies('user_product_edit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $product = Product::find($id);
        $product->fill($request->all());
        $product->update();

        return redirect()->back()->with('status', $id . ' update successfully');
    }

    public function update(UpdateProductRequest $request, $id)
    {

        $validatedData = $request->validate([
            'prod_name' => [
                'required',
                Rule::unique('products')->where(function ($query) use($request, $id) {
                    return $query->where('prod_name', $request->input('prod_name'))->where('prod_type_name', $request->input('prod_type_name'));
                })->ignore($id)
            ]
        ],
        [
         'prod_name.required'=> 'โปรดระบุชื่อสินค้า',
         'prod_type_name.required'=> 'โปรดระบุประเภทสินค้า',
         'prod_price.required'=> 'โปรดระบุราคาสินค้า',
         'prod_name.unique'=> 'รายการสินค้าซ้ำกัน (ชื่อสินค้าและประเภทสินค้านี้มีอยู่ในฐานข้อมูลแล้ว)'
        ]);

        $product = Product::find($id);
        $product->prod_name = $request->input('prod_name');
        $product->prod_price = $request->input('prod_price');
        $product->prod_type_name = $request->input('prod_type_name');
        $product->prod_detail = $request->input('prod_detail');
        $product->update();

        return Redirect::route('products.index')->with('status','... Updated Successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
