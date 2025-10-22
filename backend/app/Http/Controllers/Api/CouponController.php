<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Applay coupon
     */
    public function applyCoupon(Request $request){
        $coupon = Coupon::whereName($request->name)->first();

        if ($coupon && $coupon->checkIfValid()) {
            return response()->json([
                'success' => true,
                'coupon' => $coupon,
                // 'discount' => $coupon->discount,
                'message' => 'Coupon applied successfully.'
            ]);
        } else {
            return response()->json([
                // 'success' => false,
                'error' => 'Invalid or expired coupon.'
                // 'error' => 'Invalid or expired coupon.Failed to apply coupon. Please try again.'
            ]);
        }
    }
}
