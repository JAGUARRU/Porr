<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Redirect;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('products.index', ["products"=>$products]);
    }

    public function create()
    {
        $config = [
            'table' => 'products',
            'length' => 10,
            'prefix' => 'PROD-'
        ];
        
        $id = IdGenerator::generate($config);
        $categories = ProductCategory::orderBy('id','desc')->get();

        return view('products.create')->with(compact('categories', 'id'));
    }

    public function store(Request $request)
    {
        $product = new Product;
        $product->id = $request->input('id');
        $product->prod_name = $request->input('prod_name');
        $product->prod_price = $request->input('prod_price');
        $product->prod_type_name = $request->input('prod_type_name');
        $product->prod_detail = $request->input('prod_detail');
        //$product->stock = $request->input('stock');
        $product->save();
        return Redirect::route('products.index')->with('status','Product Added Successfully');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = ProductCategory::orderBy('id','desc')->get();
        return view('products.edit', compact(['product', 'categories']));
    }

    public function show(Product $product)
    {
        return view('products.show', compact(['product']));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        $product->prod_name = $request->input('prod_name');
        $product->prod_price = $request->input('prod_price');
        $product->prod_type_name = $request->input('prod_type_name');
        $product->prod_detail = $request->input('prod_detail');
        //$product->stock = $request->input('stock');
        $product->update();
        //return redirect()->back()->with('status','... Updated Successfully');
        return Redirect::route('products.index')->with('status','... Updated Successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
