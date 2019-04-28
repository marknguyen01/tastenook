<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Permission;
use App\Models\Review;
use App\Models\Business;
use App\Models\Comment;

class ReviewController extends Controller
{
  public function store(Request $request, $slug) {
    $validatedData = $request->validate([
      'content' => 'required',
      'rating' => 'required|integer|min:1|max:5',
    ]);

    $business = Business::where('slug', $slug)->first();

    // Check if business is found
    if($business) {
      $user = \Auth::user();
      $permission = Permission::where('slug', 'review.business')->first();

      // if user has not reviewed this business
      if(!$user->allowed('review.businesses', $business)) {
        $review = Review::create([
          'user_id' => $user->id,
          'business_id' => $business->id,
          'content' => $request->content,
          'rating' => $request->rating,
          'slug' => generate_slug(),
        ]);

        if(!$review->save()) {
          return \Redirect::back()->withErrors(['Something went wrong. Your review has not been saved']);
        }
        else {
            $business->update([
                'rating_avg' => ($business->rating_avg * $business->review_count + $review->rating) / ($business->review_count + 1),
                'review_count' => $business->review_count + 1,
            ]);
            return \Redirect::back()->with(['Your review has been created!']);
        }
      }
      else {
        return \Redirect::back()->withErrors([
          'You have already reviewed this business!',
          'You can update or delete your review.'
        ]);
      }
    }
    else {
      abort(404);
    }
  }

  public function update(Request $request, $slug) {
    $business = Business::where('slug', $slug)->first();
    try {
      $review = Review::where([
        ['business_id', $business->id],
        ['user_id', \Auth::user()->id],
      ])->first();

      $total_vote = ($business->rating_avg * $business->review_count) - $review->rating;

      $updatedBusiness = $business->update([
          'rating_avg' => ($total_vote + $request->rating) / $business->review_count
      ]);

      $updatedReview = $review->update([
        'content' => $request->content,
        'rating' => $request->rating
      ]);

      if($updatedReview > 0 && $updatedBusiness > 0) {
        return redirect('/b/' . $slug)->with('success', 'Your review has been updated');
      }
      else {
        return redirect('/b/' . $slug)->with('error', 'Something went wrong! Your review has not been updated');
      }
    }
    catch (\Illuminate\Database\QueryException $e) {
      return redirect('/b/' . $slug)->with('error', 'Something went wrong! Please try again');
    }
  }

  public function destroy($id) {
    $review = Review::find($id);
    $business = $review->business()->first();
    $user = \Auth::user();

    $total_vote = ($business->rating_avg * $business->review_count) - $review->rating;

    $updatedBusiness = $business->update([
        'rating_avg' => $total_vote / ($business->review_count - 1),
        'review_count' => $business->review_count - 1,
    ]);

    if($review->delete()) {
      return \Redirect::back()->with('The review is successfully deleted');
    } else {
      return \Redirect::back()->withErrors(['Something went wrong. Your review has not been deleted!']);
    }
  }

  public function upvote($id) {
    $review = Review::find($id);
    $voted_user = $review->user();
    $user = \Auth::user();

    if(!$user->hasUpVoted($review) && $review && $user) {
      $user->upVote($review);
      $voted_user->increment('tasties');
    }
    else {
        $user->cancelVote($review);
        $voted_user->decrement('tasties');
    }
    return response()->json([
        'action' => 'vote',
        'upvotes' => $review->countUpVoters(),
        'downvotes' => $review->countDownVoters(),
        'user_tasties' => $voted_user->first()->tasties,
    ], 200);
  }

  public function downvote($id) {
    $review = Review::find($id);
    $voted_user = $review->user();
    $user = \Auth::user();

    if(!$user->hasDownVoted($review) && $review && $user) {
      $user->downVote($review);
      $voted_user->decrement('tasties');
    }
    else {
        $user->cancelVote($review);
        $voted_user->increment('tasties');
    }
    return response()->json([
        'action' => 'vote',
        'upvotes' => $review->countUpVoters(),
        'downvotes' => $review->countDownVoters(),
        'user_tasties' => $voted_user->first()->tasties,
    ], 200);
  }

  public function storeComment(Request $request, $id) {
      $validatedData = $request->validate([
        'content' => 'required',
      ]);
      $review = Review::find($id);
      if($review) {
          $createdReview = $review->comments()->create([
                  'user_id' => \Auth::user()->id,
                  'content' => $request->content,
          ]);
          if($createdReview->save()) {
              return \Redirect::back()->with(['Your comment has been created!']);
          }
          else {
              return \Redirect::back()->withError(['Something went wrong. Your comment has not been created!']);
          }
      }
  }
}
