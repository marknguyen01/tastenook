<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\Review;
use App\Models\Coupon;

class BusinessController extends Controller
{
    public function show($slug) {
      $business = Business::where('slug', $slug)->first();

      if($business) {
        // Query Reviews
        $reviews = $business->reviews;
        $coupons = $business->coupons;


        $business->increment('view_count', 1);
        // Format phone number
        $phone = $business->phone_number;
        $business->phone_number =  "(".substr($phone, 0, 3).")-".substr($phone, 3, 3)."-".substr($phone,6);
        // Format address
        $business->address = $business->street_address . ' '
        . $business->city . ', '. $business->state . ' ' . $business->zip_code;
        // Data array
        $arr = [
          'business' => $business,
          'reviews' => $reviews,
          'coupons' => $coupons,
        ];

        if(\Auth::user()) {
          $user_review = Review::where([
            ['business_id', $business->id],
            ['user_id', \Auth::user()->id],
          ])->first();
          $arr['user_review'] = $user_review;
        }


        return view('businesses/show', $arr);

      }
      else {
        abort(404);
      }
    }

    private function checkIfOnwer($business) {
        return \Auth::user()->allowed('edit.businesses', $business);
    }
    public function edit($slug) {
        $business = Business::where('slug', $slug)->first();
        if($this->checkIfOnwer($business))
            return view('businesses/edit', ['business' => $business]);
        else
            abort(404);
    }
    public function update(Request $rq, $slug) {
        $business = Business::where('slug', $slug)->first();
        if($business) {
            if($this->checkIfOwner($business)) {
                try {
                    $updatedBusiness = $business->update([
                        'name' => $rq->name,
                        'slug' => $rq->slug,
                        'street_address' => $rq->street,
                        'city' => $rq->city,
                        'state' => $rq->state,
                        'zip_code' => $rq->zip,
                        'phone_number' => $rq->phone,
                        'website' => $rq->website
                    ]);

                    if($updatedBusiness > 0) {
                        return redirect(route('business.edit', $slug))->with('success', 'Your business has been updated');
                    }
                    else {
                        return redirect(route('business.edit', $slug))->with('error', 'Something went wrong! Your business has not been updated');
                    }
                }
                catch (\Illuminate\Database\QueryException $e) {
                    return redirect(route('business.edit', $slug))->with('error', 'Something went wrong! Please try again');
                }
            }
            else {
                abort(404);
            }
        }
    }

    public function createCoupon() {
        return view('businesses/create-coupon');
    }
}
