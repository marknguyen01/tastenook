<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jcc\LaravelVote\CanBeVoted;

class Comment extends Model
{
    use CanBeVoted;
    protected $vote = \App\Models\User::class;

    protected $primaryKey = 'comment_id';
    protected $fillable = ['user_id', 'content'];
    public function commentable() {
      return $this->morphTo();
    }
    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
