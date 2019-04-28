<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jcc\LaravelVote\CanBeVoted;


class Review extends Model
{
    use CanBeVoted;
    use SoftDeletes;

    protected $vote = \App\Models\User::class;
    protected $guarded = ['id'];


    public function user() {
      return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function comments() {
      return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
