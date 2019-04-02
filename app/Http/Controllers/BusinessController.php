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

    public function store_review(Request $request, $slug) {
      $validatedData = $request->validate([
        'content' => 'required',
        'rating' => 'required|integer|min:1|max:5',
      ]);

      $business = Business::where('slug', $slug)->first();

      if($business) {
        $review = Review::create([
          'user_id' => \Auth::user()->id,
          'business_id' => $business->id,
          'content' => $request->request,
          'rating' => $request->rating,
          'slug' => generate_slug()
        ]);
      }
      else {
        abort(404);
      }
    }

    public function edit () {}
}
