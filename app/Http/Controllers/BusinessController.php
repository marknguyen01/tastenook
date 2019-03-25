<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    public function show($slug) {
      $business = Business::where('slug', $slug)->first();

      if($business) {
        return view('businesses/show', ['business' => $business]);
      }
      else {
        abort(404);
      }
    }
}
