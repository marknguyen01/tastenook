<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    public function show($slug) {
      $business = Business::where('slug', $slug)->first();

      if($business) {
        $business->increment('view_count', 1);
        return view('businesses/show', ['business' => $business]);
      }
      else {
        abort(404);
      }
    }
}
