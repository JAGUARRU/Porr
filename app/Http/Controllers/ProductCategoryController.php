<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Response;

class ProductCategoryController extends Controller
{
    public function store(StoreProductCategoryRequest $request)
    {
        $productCategory = ProductCategory::create($request->validated());

        return Response::json($productCategory);
    }

    public function index(Request $request)
    {

        $data = ProductCategory::query();

        if (strlen($request->term))
        {
            $data->where("name","LIKE","%{$request->term}%");
        }

        $data = $data->orderBy('created_at', 'desc')->limit(5)->get()->toArray();

        return response()->json([
            'statusCode' => 200,
            'data' => $data
        ]);

    }

    public function show(UpdateProductCategoryRequest $request)
    {
        $category = ProductCategory::find($request->id);

        if ($request->name)
        {

            $validatedData = $request->validate([
                'name' => [
                    'required',
                    Rule::unique('product_categories')->where(function ($query) use($request) {
                        return $query->where('name', $request->input('name'));
                    })->ignore($request->id)
                ]
            ],
            [
             'name.unique'=> 'ประเภทสินค้าซ้ำกัน (ประเภทสินค้านี้มีอยู่ในฐานข้อมูลแล้ว)'
            ]);

            $category->name = $request->name;
            $category->update();
        }
        else
        {
            $category->delete();
        }

        return response()->json([
            'statusCode' => 200,
            'change' => $category->where("name","LIKE","%{$request->search}%")->orderBy('created_at', 'desc')->limit(5)->get(),
            'current_data' => $category->get()
        ]);
    
    }
}
