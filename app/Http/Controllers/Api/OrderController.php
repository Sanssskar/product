<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order_ItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $orders = $user->orders;
        $order_items = $user->order_items;
        return response()->json([
            "success" => true,
            "message" => "Recent Orders",
            "orders" =>  OrderResource::collection($orders),
        ]);
    }
    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $totalAmount = 0;
        $items = $request->items;
        if (is_string($items)) {
            $items = json_decode($items, true); //decoding from string to array
        }

        foreach ($items as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) {
                return response()->json([
                    "success" => false,
                    "message" => "product id not found"
                ]);
            }
            $price = $product->discounted_price();
            $totalAmount += $price * $item['qty'];
        }

        $order = new Order();
        $order->Total_amt = $totalAmount;
        $order->user_id = $user->id;
        $img = $request->file('payment_receipt');
        if ($img) {
            $file_name = time() . "." . $img->getClientOriginalExtension();
            $img->storeAs('/', $file_name);
            $order->payment_receipt = $file_name;
        }
        $order->save();


        foreach ($items as $item) {
            $o_item = new OrderItem();
            $o_item->order_id = $order->id;
            $o_item->product_id = $item['product_id'];
            $o_item->qty = $item['qty'];
            $o_item->save();
        }

        $order = Order::find($order->id);

        return response()->json([
            "success" => true,
            "message" => "Order has been Placed",
            "orders" => new OrderResource($order)
        ]);
    }
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order && $order->user->id !== Auth()->user->id) {
            return response()->json([
                "success" => false,
                "message" => "Order not found"
            ]);
        }

        $order->status = $request->status;
        $order->save();

        // ✅ Delete cart when delivered or canceled
        if (in_array($order->status, ['delivered', 'cancel'])) {
            Cart::where('user_id', $order->user_id)->delete();
        }

        return response()->json([
            "success" => true,
            "message" => "Order status updated successfully",
            "order" => new OrderResource($order)
        ]);
    }
    public function delete($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                "success" => false,
                "message" => "Order not found"
            ]);
        }

        // ❌ Block delete if order is NOT canceled
        if ($order->status !== 'cancel') {
            return response()->json([
                "success" => false,
                "message" => "Order cannot be deleted unless it is canceled"
            ]);
        }

        // ✅ Delete order items first (safe)
        OrderItem::where('order_id', $order->id)->delete();

        // ✅ Delete order
        $order->delete();

        return response()->json([
            "success" => true,
            "message" => "Order deleted successfully"
        ]);
    }
}
