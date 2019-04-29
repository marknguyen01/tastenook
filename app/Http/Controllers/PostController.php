<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Business;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $req, $slug) {
         $validatedData = $req->validate([
           'content' => 'required|max:255',
           'as_user' => 'boolean',
         ]);

         $user = \Auth::user();
         $business = Business::where('slug', $slug)->first();
         if($user->allowed('edit.businesses', $business) && $business) {
             $createdPost = $business->posts()->create([
                 'content' => $req->content,
                 'user_id' => $user->id,
                 'as_user' => $req->as_user,
                 'slug' => generate_slug(),
             ]);
             if($createdPost) return redirect(route('business.show', $slug));
         }
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, $post_id)
    {
        $business = Business::where('slug', $slug)->first();
        $post = Post::find($post_id);
        $user = \Auth::user();
        if($business && $post && $user->allowed('edit.businesses', $business)) {
            if($post->delete()) {
                return redirect(route('business.show', $slug))->with('success', 'Your post has been deleted');
            }
            else return redirect(route('business.show', $slug))->with('error', 'Something went wrong! Your post has not been deleted');
        }
        else return redirect(route('business.show', $slug))->with('error', 'Unauthorized');
    }


  public function upvote($id) {
    $post = Post::find($id);
    $voted_user = $post->user();
    $user = \Auth::user();

    if(!$user->hasUpVoted($post) && $post) {
      $user->upVote($post);
      if($post->as_user) $voted_user->increment('tasties');
      else $voted_business->increment('tasties');
    }
    else {
        $user->cancelVote($post);
        if($post->as_user) $voted_user->decrement('tasties');
        else $voted_business->decrement('tasties');
    }
    return response()->json([
        'action' => 'vote',
        'upvotes' => $post->countUpVoters(),
        'downvotes' => $post->countDownVoters(),
        'user_tasties' => $post->as_user ? $voted_user->first()->tasties : $voted_business->first()->tasties,
    ], 200);
  }

  public function downvote($id) {
    $post = Post::find($id);
    $voted_user = $post->user();
    $voted_business = $post->business();
    $user = \Auth::user();

    if(!$user->hasDownVoted($post) && $post) {
      $user->downVote($post);
      if($post->as_user) $voted_user->decrement('tasties');
      else $voted_business->decrement('tasties');
    }
    else {
        $user->cancelVote($post);
        if($post->as_user) $voted_user->increment('tasties');
        else $voted_business->increment('tasties');
    }
    return response()->json([
        'action' => 'vote',
        'upvotes' => $post->countUpVoters(),
        'downvotes' => $post->countDownVoters(),
        'user_tasties' => $post->as_user ? $voted_user->first()->tasties : $voted_business->first()->tasties,
    ], 200);
  }

  public function storeComment(Request $request, $id) {
      $validatedData = $request->validate([
        'content' => 'required',
      ]);
      $post = Post::find($id);
      if($post) {
          $createdPost = $post->comments()->create([
                  'user_id' => \Auth::user()->id,
                  'content' => $request->content,
          ]);
          if($createdPost->save()) {
              return \Redirect::back()->with(['Your comment has been created!']);
          }
          else {
              return \Redirect::back()->withError(['Something went wrong. Your comment has not been created!']);
          }
      }
  }
}
