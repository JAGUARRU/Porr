<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductCategoryRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
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

    public function show(Request $request)
    {
        $category = ProductCategory::find($request->id);

        if ($request->value)
        {
            $category->name = $request->value;
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
