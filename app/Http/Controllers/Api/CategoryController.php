<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            "success" => true,
            "data" => CategoryResource::collection($categories),
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "success" => false,
                "category" => null
            ]);
        }
        return response()->json([
            "success" => true   ,
            "category" => new CategoryResource($category)
        ]);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:categories|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => "false",
                "errors" => $validator->errors()
            ]);
        }

        // return $request;

        $category = new Category();
        $category->title = $request->title;
        $category->slug = str()->slug($request->title);

        $category->save();
        return response()->json([
            "success" => true,
            "message" => "Category created successfully",
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:60',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => "false",
                "errors" => $validator->errors()
            ]);
        }
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                "success" => "false",
                "message" => "Invalid URL"
            ]);
        }
        $category->title = $request->title;
        $category->slug = str()->slug($request->title);
        $category->save();
        return response()->json([
            "success" => true,
            "category" => $category,
            "message" => "Category updated successfully",
        ]);
    }
    public function delete($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            "success" => "true",
            "message" => "Category deleted Successfully"
        ]);
    }
}
