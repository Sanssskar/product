<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Cart;
use App\Mail\OrderPlacedMail;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Order created
     */
    public function created(Order $order): void
    {
        Mail::to($order->user->email)
            ->send(new OrderPlacedMail($order));
    }

    /**
     * Order updated (Admin panel)
     */
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {

            // 📧 Send status update mail
            Mail::to($order->user->email)
                ->send(new OrderStatusUpdatedMail($order));

            // 🛒 Delete cart if order canceled or delivered
            if (in_array($order->status, ['cancel', 'delivered'])) {
                Cart::where('user_id', $order->user_id)->delete();
            }
        }
    }
}
