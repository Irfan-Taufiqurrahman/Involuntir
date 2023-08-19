<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json(['data' => $categories], 200);
    }

    public function try()
    {
        return response()->json(['data' => Campaign::with('category')->get()], 200);
    }
}
