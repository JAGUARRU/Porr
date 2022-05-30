<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Redirect;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5);
        return view('products.products', ["products"=>$products]);
    }

    public function create()
    {
        $categories = ProductCategory::orderBy('id','desc')->get();
        return view('products.create')->with(compact('categories'));
    }

    public function store(Request $request)
    {
        $product = new Product;
        $product->prod_id = $request->input('prod_id');
        $product->prod_name = $request->input('prod_name');
        $product->prod_price = $request->input('prod_price');
        $product->prod_type_name = $request->input('prod_type_name');
        $product->prod_detail = $request->input('prod_detail');
        $product->stock = $request->input('stock');
        $product->save();

        // return redirect()->back()->with('status','Product Added Successfully');

        return Redirect::route('products')->with('status','Product Added Successfully');
    }

    public function edit($prod_id)
    {
        $product = Product::find($prod_id);
        $categories = ProductCategory::orderBy('id','desc')->get();

        return view('products.edit', compact(['product', 'categories']));
    }

    public function update(Request $request, $prod_id)
    {
        $product = Product::find($prod_id);
        $product->prod_name = $request->input('prod_name');
        $product->prod_price = $request->input('prod_price');
        $product->prod_type_name = $request->input('prod_type_name');
        $product->prod_detail = $request->input('prod_detail');
        $product->stock = $request->input('stock');
        $product->update();
        //return redirect()->back()->with('status','... Updated Successfully');
        return Redirect::route('products')->with('status','... Updated Successfully');
    }

    //public function destroy($prod_id)
    //{
    //    $product = Product::find($prod_id);
    //    $product->delete();
    //    return redirect()->back()->with('status','... Deleted Successfully');
    //}

    public function destroy(Product $prod_id)
    {
        $prod_id->delete();

        return redirect()->back()->with('status','... Deleted Successfully');
    }
}
