<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Review;
use App\Models\Business;

class ReviewController extends Controller
{
  public function create($slug) {
    $business = Business::where('slug', $slug)->first();
    if($business) {
      return view('reviews.create', [
        'business' => $business
      ]);
    }
    else {
      abort(404);
    }
  }

  public function store(Request $request, $slug) {
    $validatedData = $request->validate([
      'content' => 'required',
      'rating' => 'required|integer|min:1|max:5',
    ]);

    $business = Business::where('slug', $slug)->first();

    // Check if business is found
    if($business) {
      $user = \Auth::user();
      $permission = Permission::where('slug', 'review.business')->first();

      // if user has not reviewed this business
      if($user->allowed('review.businesses', $business)) {
        $review = Review::create([
          'user_id' => $user->id,
          'business_id' => $business->id,
          'content' => $request->request,
          'rating' => $request->rating,
          'slug' => generate_slug()
        ]);

        if(!$review->save()) {
          return \Redirect::back()->withErrors(['Something went wrong. Your review has not been saved']);
        }
      }
      else {
        return \Redirect::back()->withErrors([
          'You have already reviewed this business!',
          'You can update or delete your review.'
        ]);
      }
    }
    else {
      abort(404);
    }
  }

  public function destroy($slug) {
    $business = Business::where('slug', $slug)->first();
    $user = \Auth::user();

    if($user->reviews->where('business_id', $business->id)->delete()) {
      return \Redirect::back()->with('The review is successfully deleted');
    } else {
      return \Redirect::back()->withErrors(['Something went wrong. Your review has not been deleted!']);
    }
  }
}
