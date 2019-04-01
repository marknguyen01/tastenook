<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use CanBeVoted;
      
    protected $vote = App\Models\User::class;
    protected $guarded = ['id'];


    public function user() {
      return $this->belongsTo('App\Models\User', 'user_id');
    }
}
