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
        $newBusinesses = Business::orderBy('created_at')->limit(3)->get();
        $hotBusinesses = Business::orderBy('view_count')->limit(3)->get();
        if($newBusinesses || $hotBusinesses)
            return view('welcome', ['newBusinesses' => $newBusinesses, 'hotBusinesses' => $hotBusinesses]);
        else abort(500);
    }
}
