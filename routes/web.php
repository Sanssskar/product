<?php

use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get("/order/details/{id}",function($id){
    $order = Order::find($id);
    return view("order-details",compact('order'));
})->name('order.details');

// Route::get('/test-mail', function () {
//     Mail::raw('Test email working', function ($message) {
//         $message->to('shresthasanskar95@gmail.com')
//                 ->subject('Laravel Mail Test');
//     });

//     return 'Mail sent';
// });



Route::get("/login",function(){
    return response()->json([
        "success" => false,
        "message" => "Invalid user"
    ]);
})->name("login");
