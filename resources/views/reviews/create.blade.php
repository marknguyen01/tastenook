<div id="reviews__form" class="my-3">
  <form method="post" action="{{ $user_review ? route('review.update', $business->slug) : route('review.store', $business->slug) }}">
    {{ csrf_field() }}
    @include('partials/form-rating', ['rating' => $user_review->rating])
    <textarea type="text" name="content" class="form-control my-2 mr-sm-2" rows="3"
    placeholder="{{ $user_review ? "Enter your review" : ""}}">{{ $user_review ? $user_review->content : ""}}</textarea>
    <button type="submit" class="btn btn-primary mb-2">{{ $user_review ? "Save" : "Submit" }}</button>
  </form>
</div>
