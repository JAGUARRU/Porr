<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Response;

class ProductCategoryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'name' => 'required'
        ]);

        $productCategory = ProductCategory::create($data);

        return Response::json($productCategory);
    }
}
