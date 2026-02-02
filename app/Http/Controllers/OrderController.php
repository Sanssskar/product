<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        $orders = $user->orders;
        return response()->json([
            "success" => true,
            "orders" =>  OrderResource::collection($orders),
        ]);
    }
}
