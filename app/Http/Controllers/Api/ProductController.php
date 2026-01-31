<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:categories|max:20',
            'price' => 'required|unique:categories|max:20',
            'discount' => 'required|numeric|max:20',

        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => "false",
                "errors" => $validator->errors()
            ]);
        }

        $product = new Product();
        $product->title = $request->title;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->category_id = $request->category_id;
        $image = $request->file('image');

        if ($image) {
            $file_name = time() . "." . $image->getClientOriginalExtension();
            $image->move("images", $file_name);
            $product->image = "image/$file_name";
        }
        $product->save();
        return response()->json([
            "success" => true,
            "message" => "product saved sucessfully"
        ]);
    }
    public function update(Request $request,$id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:20',
            'price' => 'required|max:20',
            'discount' => 'required|numeric|max:20',

        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => "false",
                "errors" => $validator->errors()
            ]);
        }

        $product = Product::find($id);

         if (!$product) {
            return response()->json([
                "success" => "false",
                "message" => "Invalid URL"
            ]);
        }
        $product->title = $request->title;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->category_id = $request->category_id;
        $image = $request->file('image');

        if ($image) {
            $file_name = time() . "." . $image->getClientOriginalExtension();
            $image->move("images", $file_name);
            $product->image = "image/$file_name";
        }
        $product->save();
        return response()->json([
            "success" => true,
            "message" => "product saved sucessfully"
        ]);
    }
    public function delete($id){
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            "success" => true,
            "message" => "Product deleted successfully"
        ]);
    }
}
