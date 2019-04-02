<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Review;

class BusinessController extends Controller
{
    public function show($slug) {
      $business = Business::where('slug', $slug)->first();

      if($business) {
        // Query Reviews
        $reviews = Review::where('business_id', $business->id)->get();

        $business->increment('view_count', 1);
        // Format phone number
        $phone = $business->phone_number;
        $business->phone_number =  "(".substr($phone, 0, 3).")-".substr($phone, 3, 3)."-".substr($phone,6);

        // Format address
        $business->address = $business->street_address . ' '
        . $business->city . ', '. $business->state . ' ' . $business->zip_code;

        return view('businesses/show', [
          'business' => $business,
          'reviews' => $reviews
        ]);

      }
      else {
        abort(404);
      }
    }
    public function edit () {}
}
