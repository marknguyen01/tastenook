<div id="reviews__form my-3">
  <form method="post" action="{{ $user_review ? route('review.update', $business->slug) : route('review.store', $business->slug) }}">
    {{ csrf_field() }}
    <div class="form__rating">
      @for($i = 5; $i > 0; $i--)
        <label class="{{ $i == $user_review->rating ? "selected" : ""}}">
          <input type="radio" name="rating" value="{{ $i }}" title="{{ $i }} stars" {{ $i == $user_review->rating ? "checked" : ""}}>
        </label>
      @endfor
    </div>
    <textarea type="text" name="content" class="form-control my-2 mr-sm-2" rows="3"
    placeholder="{{ $user_review ? "Enter your review" : ""}}">{{ $user_review ? $user_review->content : ""}}</textarea>
    <button type="submit" class="btn btn-primary mb-2">{{ $user_review ? "Save" : "Submit" }}</button>
  </form>
</div>
