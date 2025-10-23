<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders
     */
    public function index(){
        $orders = Order::with(['products', 'user' , 'coupon'])->latest()->get();
        return view('admin.orders.index')->with(['orders' => $orders]);

    }

    /**
     * Update the orders delivery at date
     */
    public function updateDeliveryAtDate(Order $order){
   
        $order->update([
            'delivered_at' => Carbon::now()
        ]);
        return redirect()->route('admin.orders.index')
        ->with(['success' => 'Order delivery date updated successfully.']);

    }

    /**
     * Delete the specified order
     */
    public function destroy(Order $order){
        $order->delete();
        return redirect()->route('admin.orders.index')
        ->with(['success' => 'Order deleted successfully.']);
    } 
}
