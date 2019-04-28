<div id="reviews__form" class="my-3">
  <form method="post" action="{{ $user_review ? route('review.update', $business->slug) : route('review.store', $business->slug) }}">
    {{ csrf_field() }}
    @include('partials/form-rating', ['rating' => $user_review ? $user_review->rating : 0])
    <textarea type="text" name="content" class="form-control my-2 mr-sm-2" rows="3"
    placeholder="{{ $user_review ? "Enter your review" : ""}}">{{ $user_review ? $user_review->content : ""}}</textarea>
    <div class="btn-group w-100" role="group">
        <button type="submit" class="btn btn-dark mb-2 {{ $user_review ? "w-50" : ""}}">{{ $user_review ? "Save" : "Submit" }}</button>
        @if($user_review)
        <a href="{{ route('review.delete', $user_review->id) }}" class="btn btn-danger mb-2 w-50">Delete</a>
        @endif
    </div>
  </form>
</div>
