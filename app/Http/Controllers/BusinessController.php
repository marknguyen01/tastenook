<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;

class BusinessController extends Controller
{
    public function show($slug) {
      echo Business::where('slug', $slug)->get();
    }
}
