<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['name', 'expired_at', 'description', 'code', 'user_id'];
    public function business() {
        return $this->belongsTo('App\Models\Business');
    }
}
