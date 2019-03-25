<?php

namespace App\Http\Controllers;

use App\Models\Business;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $newBusinesses = Business::orderBy('created_at')->limit(10)->get();
        return view('welcome', ['newBusinesses' => $newBusinesses]);
    }
}
