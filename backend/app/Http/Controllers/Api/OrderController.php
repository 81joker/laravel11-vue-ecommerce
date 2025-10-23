<?php

namespace App\Http\Controllers\Api;

use Stripe\Stripe;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class OrderController extends Controller
{
    /**
     * Store users orders
     */
    public function storeUserOrders(Request $request)
    {
        foreach($request->cartItems as $item){
            $order = Order::create([
                "qty" => $item['qty'],
                "user_id" => $request->user()->id,
                "coupon_id" => $item['coupon_id'],
                "total" => $this->calculateEachOrderTotal($item['price'], $item['qty'], $item['coupon_id'])
            ]);

            $order->products()->attach($item['product_id']);
        }
        return response()->json([
            "user" => UserResource::make($request->user()),
        ]);
    }

    /**
     * Calculate each order total
     */
    private function calculateEachOrderTotal($price, $qty, $coupon_id)
    {
        $total = $price * $qty;
        $discount = 0;
        if($coupon_id){
            $coupon = Coupon::find($coupon_id);
            if($coupon && $coupon->checkIfValid()){
                $discount = ($total * $coupon->discount) / 100;
                $total = $total - $discount;
            }
        }
        return $total;
    }

    /**
     * Pay orders
     */
    public function payOrdersByStripe(Request $request)
    {

        Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $checkout_session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Order Payment T-Shirt',
                        ],
                        'unit_amount' => $this->calculateTotalToPay($request->cartItems)
                        // 'unit_amount' => $request->amount * 100, // amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $request->success_url,
                // 'cancel_url' => $request->cancel_url,
            ]);
            // return the linl to strip checkout  from
            return response()->json([
                'url' => $checkout_session->url,
                // 'checkout_session' => $checkout_session,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }

        // try {
        //     $paymentIntent = \Stripe\PaymentIntent::create([
        //         'amount' => $request->amount * 100, // amount in cents
        //         'currency' => 'usd',
        //         'payment_method' => $request->payment_method,
        //         'confirmation_method' => 'manual',
        //         'confirm' => true,
        //     ]);

        //     return response()->json([
        //         'paymentIntent' => $paymentIntent,
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         'error' => $e->getMessage(),
        //     ], 500);
        // }
    }

    /**
     * Calculate total to pay
     */
    public function calculateTotalToPay($items)
    {
        $total = 0;
        foreach ($items as $item) {
            $total += $this->calculateEachOrderTotal($item['qty'],$item['price'],$item['coupon_id']);
        }
        return $total * 100;
    }
}
