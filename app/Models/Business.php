<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $guarded = [
      'id'
    ];

    public function users() {
      return $this->belongsToMany('App\Models\User', 'business_user');
    }

    public function reviews() {
      return $this->hasMany('App\Models\Review');
    }

    public function coupons() {
        return $this->hasMany('App\Models\Coupon');
    }

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }
}
