<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jcc\LaravelVote\CanBeVoted;

class Post extends Model
{
    use CanBeVoted;
    use SoftDeletes;
    protected $vote = \App\Models\User::class;
    protected $fillable = ['user_id', 'content', 'as_user', 'slug'];


    public function business() {
        return $this->belongsTo('App\Models\Business');
    }
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    public function comments() {
      return $this->morphMany('App\Models\Comment', 'commentable');
    }
}
