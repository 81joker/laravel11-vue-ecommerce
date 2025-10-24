<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the orders
     */
    public function index(){
        $reviews = Review::latest()->get();
        return view('admin.reviews.index')->with(['reviews' => $reviews]);

    }

    /**
     * Update the orders delivery at date
     */
    public function toggleApproveStatus(Review $review , $status){

        $review->update([
            'approved' => $status
        ]);
        return redirect()->route('admin.reviews.index')
        ->with(['success' => 'Review ' . ($status ? 'approved' : 'disapproved') . ' successfully.']);

    }

    /**
     * Delete the Review
     */
    public function destroy(Review $review){
        $review->delete();
        return redirect()->route('admin.reviews.index')
        ->with(['success' => 'Review deleted successfully.']);
    } 
}
