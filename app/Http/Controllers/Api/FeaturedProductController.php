<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FeaturedProductController extends Controller
{
    public function index()
    {
        $products = Product::featured()->with('category')->get();

        return response()->json([
            'success' => true,
            'data'    => ProductResource::collection($products),
        ]);
    }

    public function feature(Request $request, $id)
    {

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ]);
        }

        $product->is_featured    = true;
        $product->featured_order = $request->input('featured_order', 0);

        if ($request->hasFile('featured_image')) {
            $validator = Validator::make($request->all(), [
                'featured_image' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'  => $validator->errors(),
                ]);
            }

            if ($product->featured_image) {
                Storage::delete('public/' . $product->featured_image);
            }

            $image     = $request->file('featured_image');
            $file_name = 'featured_' . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/featured', $file_name);
            $product->featured_image = 'featured/' . $file_name;
        }

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product marked as featured',
            'data'    => new ProductResource($product),
        ]);
    }

    public function unfeature($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ]);
        }

        if ($product->featured_image) {
            Storage::delete('public/' . $product->featured_image);
        }

        $product->is_featured    = false;
        $product->featured_order = null;
        $product->featured_image = null;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from featured',
        ]);
    }


    public function updateFeaturedImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'featured_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }

        $product = Product::find($id);

        if (!$product || !$product->is_featured) {
            return response()->json([
                'success' => false,
                'message' => 'Featured product not found',
            ]);
        }

        if ($product->featured_image) {
            Storage::delete('public/' . $product->featured_image);
        }

        $image     = $request->file('featured_image');
        $file_name = 'featured_' . time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/featured', $file_name);
        $product->featured_image = 'featured/' . $file_name;
        $product->save();

        return response()->json([
            'success'       => true,
            'message'       => 'Featured image updated',
            'data'          => new ProductResource($product),
        ]);
    }


    public function reorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order'                => 'required|array|min:1',
            'order.*.id'           => 'required|integer|exists:products,id',
            'order.*.featured_order' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ]);
        }

        foreach ($request->input('order') as $item) {
            Product::where('id', $item['id'])
                ->where('is_featured', true)
                ->update(['featured_order' => $item['featured_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Featured order updated',
        ]);
    }
}
