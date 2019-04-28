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

    public function create() {
        return view('businesses/create');
    }

    public function store(Request $req) {
        $validatedData = $req->validate([
          'street' => 'required',
          'city' => 'required',
          'state' => 'required|size:2',
          'zip' => 'required|digits:5',
          'phone' => 'required|digits:10',
          'slug' => 'required|min:3,max:32',
          'website' => 'nullable|url',
        ]);
        $street_address = $req->street;
        $city = $req->city;
        $state = $req->state;
        $zip = $req->zip;
        $address = format_address($street_address, $city, $state, $zip);
        $place = file_get_contents('https://maps.googleapis.com/maps/api/place/textsearch/json?query=' . urlencode($address) . '&fields=photos,formatted_address,name,rating,opening_hours,geometry&key=' . config("settings.googleMapsAPIKey"));
        $place_json = json_decode($place);
        $place_result = $place_json->results[0];

        if($place_result) {
            $business = Business::where('street_address', $street_address)->where('zip_code', $zip)->first();
            if(!$business) {
                $createdBusiness = Business::create([
                    'name' => $req->name,
                    'slug' => urlencode($req->slug),
                    'street_address' => $street_address,
                    'city' => $city,
                    'state' => $state,
                    'zip_code' => $zip,
                    'phone_number' => $req->phone,
                    'website' => $req->website,
                    'lat' => $place_result->geometry->location->lat,
                    'lng' => $place_result->geometry->location->lng,
                ]);

                if($createdBusiness->save())
                    return \Redirect::back()->with('success', 'Business created!');
                else return \Redirect::back()->with('error', 'Something went wrong!');
            }
            else return \Redirect::back()->with('error', 'There\'s already a business with this addresss');
        }
        else return \Redirect::back()->with('error', 'This is not a valid address');
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
                        'slug' => urlencode($rq->slug),
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


    private function checkIfOnwer($business) {
        return \Auth::user()->allowed('edit.businesses', $business);
    }
}
