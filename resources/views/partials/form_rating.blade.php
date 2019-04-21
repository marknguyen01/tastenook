<div class="form-rating">
    <div class="form-rating__wrap">
        @for($i = 5; $i > 0; $i--)
            <input class="form-rating__input" id="form-rating-{{ $i }}"
            type="radio" name="rating" value="{{ $i }}"
            {{ $i == $rating ? "checked" : ""}}>
            <label class="form-rating__ico fa fa-star-o fa-lg" for="form-rating-{{ $i }}" title="{{ $i }} out of 5 stars"></label>
        @endfor
    </div>
</div>
