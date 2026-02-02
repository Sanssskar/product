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
        return response()->json([
            "sucess" => true,
            "carts" => CartResource::collection($carts)
        ]);
    }
      public function show($id)
    {
        $user = User::find(Auth::user()->id);

        $cart = Cart::find($id);
         if(!$cart){
        return response()->json([
            "success" => false,
            "message" => "Nothing to show"
        ]);
        }
        return response()->json([
            "sucess" => true,
            "carts" => new CartResource($cart)
        ]);
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $product = Product::find($request->product_id);
        $existing_cart = Cart::where("user_id", $user->id)->where('product_id', $product->id)->first();
        if ($existing_cart) {
            $existing_cart->qty += $request->qty;
            $existing_cart->amount += $request->qty * $product->discounted_price();
            $existing_cart->save();
        } else {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->product_id = $request->product_id;
            $cart->qty = $request->qty;
            $cart->amount = $request->qty * $product->discounted_price();
            $cart->save();
        }
        return response()->json([
            "success" => true,
            "cart" => new CartResource($cart)
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::find(Auth::user()->id);
        $product = Product::find($request->product_id);
        $existing_cart = Cart::where("user_id", $user->id)->where('product_id', $product->id)->first();
        $existing_cart->qty = $request->qty;
        $existing_cart->amount = $request->qty * $product->discounted_price();
        $existing_cart->save();
        return response()->json([
            "success" => true,
            "cart" => new CartResource($existing_cart)
        ]);
    }

    public function delete($id){
        $user = User::find(Auth::user()->id);
        $cart = Cart::find($id);
        $cart->delete();
        return response()->json([
            "success" => true,
            "message" => "Cart deleted successfully"
        ]);
    }
}
