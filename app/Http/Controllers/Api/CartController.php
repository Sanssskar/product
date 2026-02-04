<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $carts = $user->carts;
        if (count($carts) == 0) {
            return response()->json([
                "success" => false,
                "message" => "Cart is empty"
            ]);
        }
        return response()->json([
            "sucess" => true,
            "carts" => CartResource::collection($carts)
        ]);
    }
    public function show($id)
    {
        $user = User::find(Auth::user()->id);

        $cart = Cart::find($id);
        if (!$cart) {
            return response()->json([
                "success" => false,
                "message" => "Nothing to show"
            ]);
        }
        return response()->json([
            "sucess" => true,
            "message" => "Cart Details",
            "carts" => new CartResource($cart)
        ]);
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $product = Product::find($request->product_id);
        $cart = Cart::where("user_id", $user->id)->where('product_id', $product->id)->first();
        if ($cart) {
            $cart->qty += $request->qty;
            $cart->amount += $request->qty * $product->discounted_price();
            $cart->save();
        } else {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->product_id = $request->product_id;
            $cart->qty = $request->qty;
            $cart->amount = $request->qty * $product->discounted_price();
        }
        $cart->save();
        return response()->json([
            "success" => true,
            "message" => "Items added to cart",
            "cart" => new CartResource($cart)
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $product = Product::find($request->product_id);
        $cart = Cart::where("user_id", $user->id)->where('product_id', $product->id)->first();
        $cart->qty = $request->qty;
        $cart->amount = $request->qty * $product->discounted_price();
        $cart->save();
        return response()->json([
            "success" => true,
            "message" => "Cart has been updated",
            "cart" => new CartResource($cart)
        ]);
    }

    public function remove($id)
    {
        $user = Auth::user();

        // Find cart item
        $cart = Cart::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$cart) {
            return response()->json([
                "success" => false,
                "message" => "Cart item not found"
            ]);
        }

        // Delete cart item
        $cart->delete();

        return response()->json([
            "success" => true,
            "message" => "Item removed from cart successfully"
        ]);
    }
}
