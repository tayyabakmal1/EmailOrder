<?php

namespace Botble\EmailOrder\Http\Controllers;

use Botble\EmailOrder\Models\OrderEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Botble\Ecommerce\Models\Order;

class OrderEmailController extends Controller
{
    /**
     * Send or save a custom email message to the customer for a given order.
     *
     * @param Request $request
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendOrSave(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $message = $request->input('message');
        $status = $request->input('action') === 'send' ? 'sent' : 'saved';

        if ($status === 'sent') {
            // Use Botble's mail system
            Mail::raw($message, function ($mail) use ($order) {
                $mail->to($order->user->email)
                    ->subject('Order Notification');
            });
        }

        $notification = OrderEmailNotification::create([
            'order_id' => $orderId,
            'message_content' => $message,
            'template_used' => null,
            'status' => $status,
        ]);

        return response()->json(['success' => true, 'notification' => $notification]);
    }

    /**
     * Get the latest email notification for a given order.
     *
     * @param int $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function latest($orderId)
    {
        $latest = OrderEmailNotification::where('order_id', $orderId)->latest()->first();
        return response()->json(['latest' => $latest]);
    }
} 